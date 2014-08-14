<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

class WemahuModelDashboard extends JModelAdmin
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_wemahu.dashboard', 'ajax_audit');
		if (empty($form))
		{
			return false;
		}
		return $form;
	}
}