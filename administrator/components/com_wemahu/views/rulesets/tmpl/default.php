<?php
/**
 * @package	com_wemahu
 * @license GNU General Public License version 2 or later; see license.txt
 * @copyright nekudo.com
 * @author Simon Samtleben <support@nekudo.com>
 */
defined('_JEXEC') or die('Restricted access');;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
?>

<form action="<?php echo JRoute::_('index.php?option=com_wemahu&view=rulesets'); ?>" method="post" name="adminForm" id="adminForm">
	<?php $mainSpan = (!empty( $this->sidebar)) ? 'span10' : 'span12'; ?>
	<?php if(!empty($this->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
	<?php endif; ?>
	<div id="j-main-container" class="<?php echo $mainSpan; ?>">


		<table class="table table-striped">
			<thead>
				<tr>
					<th width="20">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th class="title">
						<?php echo JText::_('COM_WEMAHU_VIEW_RULESETS_NAME'); ?>
					</th>
					<th width="1%" class="nowrap center">
						<?php echo JText::_('JGRID_HEADING_ID'); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach($this->items as $i => $item): ?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="center">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td>
						<a href="<?php echo JRoute::_('index.php?option=com_wemahu&task=ruleset.edit&id='.$item->id);?>" title="<?php echo $this->escape($item->name); ?>">
							<?php echo $this->escape($item->name); ?>
						</a>
					</td>
					<td class="center">
						<?php echo (int)$item->id; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>



		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />

		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>