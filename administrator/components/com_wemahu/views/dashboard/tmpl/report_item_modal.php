<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php if($this->ReportItem->checkName === 'regexCheck'): ?>
	<div id="reportModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel"><?php echo JText::_('COM_WEMAHU_REPORT_MODAL_HEADER'); ?></h3>
		</div>
		<div class="modal-body">
			<div id="wmAjaxSystemMsg"></div>

			<h4><?php echo JText::_('COM_WEMAHU_REPORT_ITEM_INFO'); ?></h4>
			<p class="reportItemDesc"><?php echo htmlentities($this->ReportItem->matchDescription); ?></p>

			<h4><?php echo JText::_('COM_WEMAHU_REPORT_ITEM_SNIPPET'); ?></h4>
			<pre class="reportItemSnippet"><?php echo htmlentities($this->ReportItem->matchSnippet); ?></pre>
		</div>
		<div class="modal-footer">
			<form method="post" action="<?php echo JRoute::_('index.php?option=com_wemahu'); ?>">
				<input type="hidden" name="report_id" value="<?php echo $this->reportId; ?>" />
				<?php if($this->useApi === true): ?>
					<button class="btn btn-danger wmAjaxAddToList wmAjaxBlacklistButton" data-task="addToBlacklist"><?php echo JText::_('COM_WEMAHU_CONFIRM_MALWARE'); ?></button>
				<?php endif; ?>
				<button class="btn btn-success wmAjaxAddToList wmAjaxWhitelistButton" data-task="addToWhitelist"><?php echo JText::_('COM_WEMAHU_ADD_TO_WHITELIST'); ?></button>
				<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_WEMAHU_CLOSE'); ?></button>
			</form>
		</div>
	</div>
<?php endif; ?>

<?php if($this->ReportItem->checkName === 'hashCheck'): ?>
	<div id="reportModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel"><?php echo JText::_('COM_WEMAHU_REPORT_MODAL_HEADER'); ?></h3>
		</div>
		<div class="modal-body">
			<div id="wmAjaxSystemMsg"></div>

			<h4><?php echo JText::_('COM_WEMAHU_REPORT_ITEM_INFO'); ?></h4>
			<p>
				<?php if($this->ReportItem->type === 'new_file'): ?>
					<?php echo JText::_('COM_WEMAHU_REPORT_NEW_FILE'); ?>
				<?php elseif($this->ReportItem->type === 'modified_file'): ?>
					<?php echo JText::_('COM_WEMAHU_REPORT_MODIFIED_FILE'); ?>
				<?php endif; ?>
			</p>
			<p>
				<strong><?php echo JText::_('COM_WEMAHU_TIME_LASTMOD'); ?></strong> <?php echo $this->ReportItem->lastmod; ?>
			</p>
		</div>
		<div class="modal-footer">
			<form method="post" action="<?php echo JRoute::_('index.php?option=com_wemahu'); ?>">
				<input type="hidden" name="report_id" value="<?php echo $this->reportId; ?>" />
				<?php if($this->useApi === true): ?>
					<button class="btn btn-danger wmAjaxAddToList wmAjaxBlacklistButton" data-task="addToBlacklist"><?php echo JText::_('COM_WEMAHU_CONFIRM_MALWARE'); ?></button>
				<?php endif; ?>
				<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_WEMAHU_CLOSE'); ?></button>
			</form>
		</div>
	</div>
<?php endif; ?>