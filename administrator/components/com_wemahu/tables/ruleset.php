<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuTableRuleset extends JTable
{
	public function __construct(&$_db)
	{
		parent::__construct('#__wm_rulesets', 'id', $_db);
		$date = JFactory::getDate();
		$this->created = $date->toSql();
	}
}