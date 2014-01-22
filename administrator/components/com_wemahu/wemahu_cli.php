<?php
/**
 * Wemahu CLI script. Can be used to run Wemahu periodically using cronjobs.
 * By default a report will be send by email.
 * Possible Parameters:
 * --force_output Force output to STDOUT instead of sending mail.
 * --ruleset id_ruleset Ruleset to use.
 *
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
const _JEXEC = 1;
defined('_JEXEC') or die('Restricted access');

// Load system defines
if(!defined('_JDEFINES'))
{
	define('JPATH_BASE', substr(__DIR__, 0, strpos(__DIR__, 'administrator')-1));
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_LIBRARIES . '/import.legacy.php';
require_once JPATH_LIBRARIES . '/cms.php';
require_once JPATH_CONFIGURATION . '/configuration.php';
require_once JPATH_ADMINISTRATOR . '/components/com_wemahu/libs/wemahu/src.php';

class WemahuCli extends JApplicationCli
{
	public function doExecute()
	{
		// prepare settings:
		$lang = JFactory::getLanguage();
		$lang->load('com_wemahu', JPATH_ADMINISTRATOR . '/components/com_wemahu');

		$WemahuParams = JComponentHelper::getComponent('com_wemahu')->params;
		$rulesetId = $WemahuParams->get('cron_ruleset', 0);
		$rulesetId = (empty($rulesetId)) ? 1 : $rulesetId;
		$rulesetOverride = $this->input->getInt('ruleset', 0);
		if($rulesetOverride > 0)
		{
			$rulesetId = $rulesetOverride;
		}
		$sendReportEmail = $WemahuParams->get('cron_sendmail', 1);
		$sendReportEmail = ((int)$sendReportEmail === 1) ? true : false;
		if($sendReportEmail === true)
		{
			$emailSystem = $this->config->get('mailfrom');
			$emailRecipient = $WemahuParams->get('cron_email', '');
			$emailRecipient = (empty($emailRecipient)) ? $emailSystem : $emailRecipient;
		}
		$forceOutput = (int)$this->input->get('force_output', 0);
		$forceOutput = ($forceOutput === 1) ? true : false;

		$JDBObject = JFactory::getDbo();
		$JDBObject->setQuery("SELECT * FROM #__wm_rulesets WHERE id = " . (int)$rulesetId);
		$JDBObject->execute();
		$Ruleset = $JDBObject->loadObject();
		if(empty($Ruleset))
		{
			$this->out('Error: Could not load ruleset.');
			return false;
		}

		$WemahuSettings = new Wemahu\Settings();
		$WemahuSettings->useApi = ((int)$WemahuParams->get('use_api', 1) === 1) ? true : false;
		$WemahuSettings->audits['filecheck'] = ((int)$Ruleset->filecheck === 1) ? true : false;
		$WemahuSettings->auditSettings['filecheck']['regexCheck'] = ((int)$Ruleset->regex_check === 1) ? true : false;
		$WemahuSettings->auditSettings['filecheck']['hashCheck'] = ((int)$Ruleset->hash_check === 1) ? true : false;
		$WemahuSettings->auditSettings['filecheck']['scanDir'] = JPATH_ROOT;
		$WemahuSettings->auditSettings['filecheck']['tmpDir'] = JPATH_ROOT . '/tmp';
		$WemahuSettings->auditSettings['filecheck']['pathRegexWhitelistUser'] = JPATH_ROOT . '/tmp/wemahu_regex_whitelist.wmdb';
		$WemahuSettings->auditSettings['filecheck']['pathFilehashDb'] = JPATH_ROOT . '/tmp/wemahu_filehashes.wmdb';
		if(!empty($Ruleset->scandir))
		{
			$WemahuSettings->auditSettings['filecheck']['scanDir'] = $Ruleset->scandir;
		}
		if(!empty($Ruleset->regex_db))
		{
			$WemahuSettings->auditSettings['filecheck']['pathRegexDb'] = JPATH_ADMINISTRATOR . '/components/com_wemahu/libs/wemahu/db/' . $Ruleset->regex_db . '.wmdb';
		}
		if(!empty($Ruleset->filetypes))
		{
			$WemahuSettings->auditSettings['filecheck']['extensionFilter'] = $Ruleset->filetypes;
		}
		if(!empty($Ruleset->filesize_max))
		{
			$WemahuSettings->auditSettings['filecheck']['sizeFilter'] = $Ruleset->filesize_max;
		}
		if(!empty($Ruleset->max_results_file))
		{
			$WemahuSettings->auditSettings['filecheck']['maxResultsFile'] = $Ruleset->max_results_file;
		}
		if(!empty($Ruleset->max_results_total))
		{
			$WemahuSettings->auditSettings['filecheck']['maxResultsTotal'] = $Ruleset->max_results_total;
		}

		// Init Wemahu:
		$Wemahu = new Wemahu\Wemahu;
		$Wemahu->setSettings($WemahuSettings);
		$WemahuStorage = new Wemahu\Storage;
		$Wemahu->setStorage($WemahuStorage);
		$WemahuDatabase = new Wemahu\JoomlaDatabase($JDBObject);
		$Wemahu->setDatabase($WemahuDatabase);
		$initResult = $Wemahu->init();
		$runResult = $Wemahu->run();
		if($runResult !== true)
		{
			$this->out('Error while running Wemahu.');
			return false;
		}

		// Handle report:
		$WemahuReport = new Wemahu\WemahuReport($WemahuDatabase);
		$WemahuReport->loadItems();
		if($forceOutput === true)
		{
			$this->displayReport($WemahuReport);
			return true;
		}

		if($sendReportEmail === true)
		{
			$sendEmptyReport = (int)$WemahuParams->get('cron_emptyreport', 0);
			if(empty($WemahuReport->reportItems) && $sendEmptyReport !== 1)
			{
				return true;
			}
			$this->mailReport($WemahuReport, $emailRecipient, $emailSystem);
		}
	}

	protected function displayReport($WemahuReport)
	{
		$reportText = $this->_getReportText($WemahuReport);
		$this->out($reportText);
	}

	protected function mailReport($WemahuReport, $emailTo, $emailFrom)
	{
		$JMailer = JFactory::getMailer();
		$JMailer->setSender(array($emailFrom, $this->config->get('fromname')));
		$JMailer->addRecipient($emailTo);
		$JMailer->setSubject('Wemahu Report');
		$mailBody = $this->_getReportText($WemahuReport);
		$JMailer->setBody($mailBody);
		$JMailer->Send();
	}

	private function _getReportText($WemahuReport)
	{
		$reportText = '';
		if(empty($WemahuReport) || empty($WemahuReport->reportItems))
		{
			$reportText .= JText::_('COM_WEMAHU_NO_REPORT_DATA') . "\n";
		}
		else
		{
			if(empty($WemahuReport->reportItems['filecheck']))
			{
				$reportText .= JText::_('COM_WEMAHU_NO_FILECHECK_DATA') . "\n";
			}
			else
			{
				$reportText = "=== Results of RegEx Check ===\n";
				$reportText.= "\n";
				foreach($WemahuReport->getItems('filecheck') as $i => $ReportItem)
				{
					if($ReportItem->checkName !== 'regexCheck')
					{
						continue;
					}
					$reportText .= "--- MATCH ---\n";
					$reportText .= "File: " . $ReportItem->affectedFile . "\n";
					$reportText.= "Matching Rule: " . $ReportItem->matchName . "\n";
					$reportText.= "Code: " . $ReportItem->match . "\n";
					$reportText.= "\n";
				}

				$reportText.= "=== Results of Hash Check ===\n";
				$reportText.= "\n";
				foreach($WemahuReport->getItems('filecheck') as $i => $ReportItem)
				{
					if($ReportItem->checkName !== 'hashCheck')
					{
						continue;
					}
					$reportText.= "--- MATCH ---\n";
					$reportText.= "File: " . $ReportItem->affectedFile . "\n";
					if($ReportItem->type === 'new_file')
					{
						$reportText.= "Type: " . JText::_('COM_WEMAHU_HASHCHECK_NEW_FILE') . "\n";
					}
					elseif($ReportItem->type === 'modified_file')
					{
						$reportText.= "Type: " . JText::_('COM_WEMAHU_HASHCHECK_MODIFIED_FILE') . "\n";
					}
					$reportText.= "\n";
				}
			}
		}

		return $reportText;
	}
}

JApplicationCli::getInstance('WemahuCli')->execute();