<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuViewRuleset extends JViewLegacy
{
	protected $form;
	protected $item;

	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		JToolbarHelper::title(JText::_('COM_WEMAHU_VIEW_RULESETS_TOOLBAR_TITLE'), 'rulesets.png');

		JToolbarHelper::apply('ruleset.apply');
		JToolbarHelper::save('ruleset.save');
		JToolbarHelper::save2new('ruleset.save2new');
		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('ruleset.cancel');
		}
		else
		{
			JToolbarHelper::cancel('ruleset.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}