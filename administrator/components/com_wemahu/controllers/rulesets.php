<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuControllerRulesets extends JControllerAdmin
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	public function getModel($name = 'Ruleset', $prefix = 'WemahuModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}