<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldRulesets extends JFormFieldList
{
	protected $type = 'Rulesets';

	public function getOptions()
	{
		$Dbo = JFactory::getDbo();
		$Dbo->setQuery("SELECT id,name FROM #__wm_rulesets ORDER BY name");
		$Dbo->execute();
		$rows = $Dbo->loadAssocList();

		$options = array();
		foreach($rows as $row)
		{
			$options[] = JHtml::_('select.option', $row['id'], $row['name']);
		}
		return $options;
	}
}