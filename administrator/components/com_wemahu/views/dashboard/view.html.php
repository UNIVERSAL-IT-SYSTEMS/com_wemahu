<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuViewDashboard extends JViewLegacy
{
	public function display($tpl = null)
	{
		$this->addToolbar();
		$this->form = $this->get('Form');
		WemahuHelper::addSubmenu('dashboard');
		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}

	protected function addToolbar()
	{
		JToolbarHelper::title(JText::_('COM_WEMAHU_VIEW_DASHBOARD_TOOLBAR_TITLE'), 'wemahu.png');
		JToolbarHelper::preferences('com_wemahu');
	}
}