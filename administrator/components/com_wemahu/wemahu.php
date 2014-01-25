<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 * @version 1.0.1
 */
defined('_JEXEC') or die('Restricted access');

JHtml::_('bootstrap.framework');
JHtml::script('administrator/components/com_wemahu/assets/js/moment.min.js');
JHtml::script('administrator/components/com_wemahu/assets/js/jquery.nanoscroller.min.js');
JHtml::script('administrator/components/com_wemahu/assets/js/wemahu.js');
JHtml::stylesheet('administrator/components/com_wemahu/assets/css/wemahu.css');

// Execute the task.
$controller	= JControllerLegacy::getInstance('Wemahu');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();