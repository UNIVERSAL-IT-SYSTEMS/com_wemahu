<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuViewRulesets extends JViewLegacy
{
	protected $items;
	protected $pagination;

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		JToolbarHelper::title(JText::_('COM_WEMAHU_VIEW_RULESETS_TOOLBAR_TITLE'), 'rulesets.png');
		JToolbarHelper::addNew('ruleset.add');
		JToolbarHelper::deleteList('', 'rulesets.delete');
		JToolbarHelper::preferences('com_wemahu');
		WemahuHelper::addSubmenu('rulesets');
		$this->sidebar = JHtmlSidebar::render();
	}
}