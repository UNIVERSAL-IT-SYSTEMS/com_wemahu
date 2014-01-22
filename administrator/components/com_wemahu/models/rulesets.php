<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuModelRulesets extends JModelList
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	protected function getListQuery()
	{

		$Db = $this->getDbo();
		$Query = $Db->getQuery(true);
		$Query->select('rs.*')->from('#__wm_rulesets rs');
		return $Query;
	}
}