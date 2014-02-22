<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'ruleset.cancel' || document.formvalidator.isValid(document.id('ruleset-form')))
		{
			Joomla.submitform(task, document.getElementById('ruleset-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_wemahu&layout=edit&id='.(int)$this->item->id); ?>" method="post" name="adminForm" id="ruleset-form" class="form-horizontal">
	<div class="span12 form-horizontal">

		<fieldset>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo JText::_('COM_WEMAHU_GENERAL');?></a></li>
				<li><a href="#filecheck" data-toggle="tab"><?php echo JText::_('COM_WEMAHU_FILECHECK_SETTINGS');?></a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="general">
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('name'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('name'); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('filecheck'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('filecheck'); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('id'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('id'); ?>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="filecheck">
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('scandir'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('scandir'); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('regex_check'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('regex_check'); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('regex_db'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('regex_db'); ?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('hash_check'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('hash_check'); ?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('hash_check_blacklist'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('hash_check_blacklist'); ?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('filetypes'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('filetypes'); ?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('filesize_max'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('filesize_max'); ?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('max_results_file'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('max_results_file'); ?>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('max_results_total'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('max_results_total'); ?>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>