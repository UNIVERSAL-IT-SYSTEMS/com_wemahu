<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');
?>
<h2><?php echo JText::_('COM_WEMAHU_REPORT'); ?></h2>
<?php if(empty($this->Report) || empty($this->Report->reportItems)): ?>
	<em><?php echo JText::_('COM_WEMAHU_NO_REPORT_DATA'); ?></em>
<?php else: ?>
	<!-- Filecheck Report -->
	<?php $itemCount = 1; ?>
	<?php if(empty($this->Report->reportItems['filecheck'])): ?>
		<em><?php echo JText::_('COM_WEMAHU_NO_FILECHECK_DATA'); ?></em>
	<?php else: ?>
		<h3><?php echo JText::_('COM_WEMAHU_REGEX_CHECK_RESULTS'); ?></h3>
		<table class="table table-hover" id="wmReportTable">
			<thead>
				<tr>
					<th>#</th>
					<th>Type</th>
					<th>Match</th>
					<th>File</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->Report->getItems('filecheck') as $i => $ReportItem): ?>
					<?php if($ReportItem->checkName !== 'regexCheck'): continue; endif; ?>
					<tr class="wmReportItem" data-reportitemid="<?php echo $i; ?>">
						<td><?php echo $itemCount; ?></td>
						<td><?php echo $ReportItem->matchName; ?></td>
						<td><?php echo $this->escape(substr($ReportItem->matchSnippet, 0, 100)); ?></td>
						<td><?php echo $ReportItem->affectedFile; ?></td>
					</tr>
					<?php $itemCount++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h3><?php echo JText::_('COM_WEMAHU_HASH_CHECK_RESULTS'); ?></h3>
		<table class="table table-hover" id="wmHashcheckReportTable">
			<thead>
				<tr>
					<th>#</th>
					<th>Type</th>
					<th>File</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->Report->getItems('filecheck') as $i => $ReportItem): ?>
					<?php if($ReportItem->checkName !== 'hashCheck'): continue; endif; ?>
					<tr class="wmReportItem" data-reportitemid="<?php echo $i; ?>">
						<td><?php echo $itemCount; ?></td>
						<td>
							<?php if($ReportItem->type === 'new_file'): ?>
								<?php echo JText::_('COM_WEMAHU_HASHCHECK_NEW_FILE'); ?>
							<?php elseif($ReportItem->type === 'modified_file'): ?>
								<?php echo JText::_('COM_WEMAHU_HASHCHECK_MODIFIED_FILE'); ?>
							<?php endif; ?>
						</td>
						<td><?php echo $ReportItem->affectedFile; ?></td>
					</tr>
					<?php $itemCount++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
	<!-- /Filecheck Report -->

	<div id="wmAjaxModalPlaceholder"></div>
<?php endif; ?>