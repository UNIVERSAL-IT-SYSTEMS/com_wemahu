<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuModelRuleset extends JModelAdmin
{
	protected $text_prefix = 'COM_WEMAHU_RULESET';

	public function getTable($type = 'Ruleset', $prefix = 'WemahuTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_wemahu.ruleset', 'ruleset', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app  = JFactory::getApplication();
		$data = $app->getUserState('com_wemahu.edit.ruleset.data', array());

		if(empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}
}