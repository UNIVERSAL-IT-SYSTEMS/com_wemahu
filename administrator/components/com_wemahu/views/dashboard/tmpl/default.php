<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');
?>

<?php $mainSpan = (!empty( $this->sidebar)) ? 'span10' : 'span12'; ?>
<?php if(!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
<?php endif; ?>

<div id="j-main-container" class="<?php echo $mainSpan; ?>">
	<h2><?php echo JText::_('COM_WEMAHU_START_NEW_AUDIT'); ?></h2>

	<form action="<?php echo JRoute::_('index.php?option=com_wemahu'); ?>" method="post" name="ajaxAudit" id="wmAjaxAuditForm" class="form-horizontal">
		<fieldset class="adminform">
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('ruleset'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('ruleset'); ?></div>
			</div>

			<div class="control-group">
				<div class="control-label">&nbsp;</div>
				<div class="controls">
					<button id="wmAjaxAuditSubmit" type="submit" class="btn btn-success">Start</button>
				</div>
			</div>
		</fieldset>

		<input type="hidden" name="task" value="dashboard.ajaxAudit" />
		<?php echo JHtml::_('form.token'); ?>
	</form>

	<div id="wmProgress">
		<div class="progress progress-striped">
			<div class="bar" style="width: 0%;"></div>
		</div>
		<a href="#" id="wmToggleConsole" class="btn btn-small btn-info"><?php echo JText::_('COM_WEMAHU_TOGGLE_CONSOLE'); ?> <i class="icon-chevron-down"></i></a>
		<div id="console" class="nano" style="display:none;">
			<div id="log" class="content"></div>
		</div>
	</div>

	<div id="wmAjaxResponse"></div>
</div>