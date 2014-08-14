<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT_ADMINISTRATOR . '/libs/class.json_response.php';
require_once JPATH_COMPONENT . '/libs/wemahu/src.php';

class WemahuControllerDashboard extends JControllerAdmin
{
	protected $JsonResponse = null;

	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->JsonResponse = new JsonResponse;
	}

	/**
	 * Inits wemahu scanner by passing necessary objects like settings and database.
	 *
	 */
	public function initWemahu()
	{
		$rulesetId = $this->input->getInt('ruleset', 0);
		if(empty($rulesetId))
		{
			$this->returnError('No ruleset selected.');
		}
		$rulesetData = $this->getModel('ruleset')->getItem($rulesetId);
		if(empty($rulesetData))
		{
			$this->returnError('Invalid ruleset.');
		}

		// prepare Wemahu settings:
		$WemahuParams = JComponentHelper::getComponent('com_wemahu')->params;

		$WemahuSettings = new Wemahu\Settings();
		$WemahuSettings->intervalMode = true;
		$WemahuSettings->useApi = ((int)$WemahuParams->get('use_api', 1) === 1) ? true : false;
		$WemahuSettings->audits['filecheck'] = ((int)$rulesetData->filecheck === 1) ? true : false;
		$WemahuSettings->auditSettings['filecheck']['regexCheck'] = ((int)$rulesetData->regex_check === 1) ? true : false;
		$WemahuSettings->auditSettings['filecheck']['hashCheck'] = ((int)$rulesetData->hash_check === 1) ? true : false;
		$WemahuSettings->auditSettings['filecheck']['scanDir'] = JPATH_ROOT;
		$WemahuSettings->auditSettings['filecheck']['tmpDir'] = JPATH_ROOT . '/tmp';
		$WemahuSettings->auditSettings['filecheck']['pathRegexWhitelistUser'] = JPATH_ROOT . '/tmp/wemahu_regex_whitelist.wmdb';
		if(!empty($rulesetData->scandir))
		{
			$WemahuSettings->auditSettings['filecheck']['scanDir'] = $rulesetData->scandir;
		}
		$WemahuSettings->auditSettings['filecheck']['scanDir'] = rtrim($WemahuSettings->auditSettings['filecheck']['scanDir'], '/');
		if(!empty($rulesetData->regex_db))
		{
			$WemahuSettings->auditSettings['filecheck']['pathRegexDb'] = JPATH_ADMINISTRATOR . '/components/com_wemahu/libs/wemahu/db/' . $rulesetData->regex_db . '.wmdb';
		}
		if(!empty($rulesetData->filetypes))
		{
			$WemahuSettings->auditSettings['filecheck']['extensionFilter'] = $rulesetData->filetypes;
		}
		if(!empty($rulesetData->filesize_max))
		{
			$WemahuSettings->auditSettings['filecheck']['sizeFilter'] = $rulesetData->filesize_max;
		}
		if(!empty($rulesetData->max_results_file))
		{
			$WemahuSettings->auditSettings['filecheck']['maxResultsFile'] = $rulesetData->max_results_file;
		}
		if(!empty($rulesetData->max_results_total))
		{
			$WemahuSettings->auditSettings['filecheck']['maxResultsTotal'] = $rulesetData->max_results_total;
		}
		if($WemahuSettings->auditSettings['filecheck']['hashCheck'] === true && !empty($rulesetData->hash_check_blacklist))
		{
			$WemahuSettings->auditSettings['filecheck']['hashCheckBlacklist'] = explode("\n", str_replace("\r", "", $rulesetData->hash_check_blacklist));
		}

		// Init Wemahu:
		$Wemahu = new Wemahu\Wemahu;
		$Wemahu->setSettings($WemahuSettings);
		$WemahuStorage = new Wemahu\Storage;
		$Wemahu->setStorage($WemahuStorage);
		$JDBObject = JFactory::getDbo();
		$WemahuDatabase = new Wemahu\JoomlaDatabase($JDBObject);
		$Wemahu->setDatabase($WemahuDatabase);
		$initResult = $Wemahu->init();

		// Send Response:
		if($initResult === false)
		{
			$this->JsonResponse->setError('Wemahu initialization failed.');
		}
		$auditMessages = $Wemahu->getAuditMessages();
		$auditMessagesHtml = implode('<br />', $auditMessages) . '<br />';
		$this->JsonResponse->setType('init_success');
		$this->JsonResponse->setData('init_msg', $auditMessagesHtml);
		echo $this->JsonResponse->getResponseData();
		JFactory::getApplication()->close();
	}

	public function runWemahu()
	{
		// Continue last Wemahu request:
		$Wemahu = new Wemahu\Wemahu;
		$JDBObject = JFactory::getDbo();
		$WemahuDatabase = new Wemahu\JoomlaDatabase($JDBObject);
		$Wemahu->setDatabase($WemahuDatabase);
		$WemahuStorage = new Wemahu\Storage;
		$Wemahu->setStorage($WemahuStorage);
		$Wemahu->reinit();
		$runResult = $Wemahu->run();
		if($runResult !== true)
		{
			$this->JsonResponse->setError('An error appeared while running the audits.');
		}
		if($Wemahu->isComplete() === true)
		{
			$this->JsonResponse->setType('audit_complete');
			$this->JsonResponse->setData('audit_msg', 'Audit complete. Fetching results...<br />');
		}
		else
		{
			$auditMessages = $Wemahu->getAuditMessages();
			$auditMessagesHtml = implode('<br />', $auditMessages) . '<br />';
			$this->JsonResponse->setType('audit_incomplete');
			$this->JsonResponse->setData('audit_msg', $auditMessagesHtml);
			$this->JsonResponse->setData('percentDone', $Wemahu->getPercentageDone());
		}

		echo $this->JsonResponse->getResponseData();
		JFactory::getApplication()->close();
	}

	public function getWemahuReport()
	{
		$JDBObject = JFactory::getDbo();
		$WemahuDatabase = new Wemahu\JoomlaDatabase($JDBObject);
		$WemahuReport = new Wemahu\WemahuReport($WemahuDatabase);
		$WemahuReport->loadItems();
		$View = $this->getView('dashboard', 'html');
		$View->setLayout('report');
		$View->Report = $WemahuReport;
		$this->JsonResponse->setType('report_success');
		$this->JsonResponse->setData('reportHtml', $View->loadTemplate());
		echo $this->JsonResponse->getResponseData();
		JFactory::getApplication()->close();
	}

	public function addToWhitelist()
	{
		$reportId = $this->input->getInt('reportId', 0);
		if(empty($reportId))
		{
			$this->JsonResponse->setError('No report-id given.');
			echo $this->JsonResponse->getResponseData();
			JFactory::getApplication()->close();
		}

		$Wemahu = new Wemahu\Wemahu;
		$JDBObject = JFactory::getDbo();
		$WemahuDatabase = new Wemahu\JoomlaDatabase($JDBObject);
		$Wemahu->setDatabase($WemahuDatabase);
		$WemahuStorage = new Wemahu\Storage;
		$Wemahu->setStorage($WemahuStorage);
		$initResult = $Wemahu->reinit();
		if($initResult !== true)
		{
			$this->JsonResponse->setError('Could not init Wemahu.');
			echo $this->JsonResponse->getResponseData();
			JFactory::getApplication()->close();
		}

		$addResult = $Wemahu->addToFilecheckWhitelist($reportId);
		if($addResult !== true)
		{
			$this->JsonResponse->setError('Could not add item to whitelist.');
			echo $this->JsonResponse->getResponseData();
			JFactory::getApplication()->close();
		}

		$this->JsonResponse->setMsg('Item successfully added to whitelist.');
		echo $this->JsonResponse->getResponseData();
		JFactory::getApplication()->close();
	}

	public function addToBlacklist()
	{
		$reportId = $this->input->getInt('reportId', 0);
		if(empty($reportId))
		{
			$this->JsonResponse->setError('No report-id given.');
			echo $this->JsonResponse->getResponseData();
			JFactory::getApplication()->close();
		}

		$Wemahu = new Wemahu\Wemahu;
		$JDBObject = JFactory::getDbo();
		$WemahuDatabase = new Wemahu\JoomlaDatabase($JDBObject);
		$Wemahu->setDatabase($WemahuDatabase);
		$WemahuStorage = new Wemahu\Storage;
		$Wemahu->setStorage($WemahuStorage);
		$initResult = $Wemahu->reinit();
		if($initResult !== true)
		{
			$this->JsonResponse->setError('Could not init Wemahu.');
			echo $this->JsonResponse->getResponseData();
			JFactory::getApplication()->close();
		}

		$addResult = $Wemahu->reportMalware($reportId);
		if($addResult !== true)
		{
			$this->JsonResponse->setError('Could not send malware-report.');
			echo $this->JsonResponse->getResponseData();
			JFactory::getApplication()->close();
		}

		$this->JsonResponse->setMsg('Item successfully reported as malware. Thanks for your help.');
		echo $this->JsonResponse->getResponseData();
		JFactory::getApplication()->close();
	}

	public function getReportItemModal()
	{
		$reportId = $this->input->getInt('reportId', 0);
		if(empty($reportId))
		{
			$this->JsonResponse->setError('No report-id given.');
			echo $this->JsonResponse->getResponseData();
			JFactory::getApplication()->close();
		}

		$JDBObject = JFactory::getDbo();
		$WemahuDatabase = new Wemahu\JoomlaDatabase($JDBObject);
		$WemahuReport = new Wemahu\WemahuReport($WemahuDatabase);
		$ReportItem = $WemahuReport->getItem($reportId);
		if(empty($ReportItem))
		{
			$this->JsonResponse->setError('Invalid report item');
			echo $this->JsonResponse->getResponseData();
			JFactory::getApplication()->close();
		}

		$WemahuParams = JComponentHelper::getComponent('com_wemahu')->params;
		$View = $this->getView('dashboard', 'html');
		$View->setLayout('report_item_modal');
		$View->reportId = $reportId;
		$View->ReportItem = $ReportItem;
		$View->useApi = ((int)$WemahuParams->get('use_api', 0) === 1) ? true : false;
		$this->JsonResponse->setData('modalHtml', $View->loadTemplate());
		echo $this->JsonResponse->getResponseData();
		JFactory::getApplication()->close();
	}

	public function getModel($name = 'Dashboard', $prefix = 'WemahuModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	protected function returnError($errorMessage = '')
	{
		$this->JsonResponse->setError($errorMessage);
		echo $this->JsonResponse->getResponseData();
		JFactory::getApplication()->close();
	}
}