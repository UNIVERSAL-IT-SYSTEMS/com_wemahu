<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuHelper
{
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_WEMAHU_DASHBOARD'),
			'index.php?option=com_wemahu&view=dashboard',
			$vName === 'dashboard'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_WEMAHU_RULESETS'),
			'index.php?option=com_wemahu&view=rulesets',
			$vName === 'rulesets'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_WEMAHU_HELP_ABOUT'),
			'index.php?option=com_wemahu&view=help',
			$vName === 'help'
		);
	}
}