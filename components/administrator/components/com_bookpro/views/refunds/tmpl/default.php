<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
AImporter::helper('date');
BookProHelper::setSubmenu(4);
JToolBarHelper::title(JText::_('COM_BOOKPRO_REFUND_MANAGER'), 'clock');
$itemsCount = count($this->items);
$pagination = &$this->pagination;
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

?>
<div class="span10">
<form action="index.php?option=com_bookpro&view=refunds" method="post" name="adminForm" id="adminForm">
	
	
		<table class="table" >
			<thead>
				<tr>
					<th width="1%" class="hidden-phone"><?php echo JHtml::_('grid.checkall'); ?>
					</th>
					<th width="5%"><?php echo JText::_('COM_BOOKPRO_AGENT_STATUS'); ?></th>
					<th class="title" width="10%">
				        <?php echo JHTML::_('grid.sort', 'COM_BOOKPRO_REFUND_HOUR', 'refund.number_hour', $listDirn, $listOrder); ?>
					</th>
					
					<th width="8%">
				        <?php echo JHTML::_('grid.sort', 'COM_BOOKPRO_REFUND_AMOUND', 'refundamount', $listDirn, $listOrder); ?>
					</th>
					
					
					<th width="1%">
				        <?php echo JHTML::_('grid.sort', 'COM_BOOKPRO_AIRPORT_ID', 'id', $listDirn, $listOrder); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
    			<tr>
    				<td colspan="5">
    				    <?php echo $pagination->getListFooter(); ?>
    				</td>
    			</tr>
			</tfoot>
			<tbody>
				<?php if (!is_array($this->items) || !$itemsCount) { ?>
					<tr><td colspan="5" class="emptyListInfo"><?php echo JText::_('COM_BOOKPRO_AIRPORT_NO_ITEMS_FOUND'); ?></td></tr>
				<?php 
				
					} else {
				?>				
				<?php for ($i = 0; $i < $itemsCount; $i++) { ?>	
				<?php 
				    	 	$subject = &$this->items[$i];
				    	 	
				    		$link = JRoute::_(ARoute::edit(CONTROLLER_REFUND, $subject->id));
				?>
				    	<tr>

							<td class="checkboxCell"><?php echo JHTML::_('grid.checkedout', $subject, $i); ?>
							</td>
		
							<td class="text-left"><?php echo JHtml::_('jgrid.published', $subject->state, $i, 'refunds.', true, 'cb', null, null); ?>
				    		<td>
					    		<a href="<?php echo JRoute::_('index.php?option=com_bookpro&task=refund.edit&id='.$subject->id); ?>" title="<?php echo $titleEdit; ?>">
					    		<?php echo DateHelper::convertHourToDay($subject->number_hour); ?></a>
					    		
				    		</td>
                            
				    		<td>
				    			                 
						        <?php 
						        
						        echo $subject->amount.' %';
						        ?>
						        	
				    		</td>
				    		
				    			<td style="text-align: left; white-space: nowrap;"><?php echo number_format($subject->id, 0, '', ' '); ?></td>
				    	</tr>
				    <?php 
				    	}
					} 
					?>
			</tbody>
		</table>
		
		
	
	<input type="hidden" name="option" value="<?php echo OPTION; ?>"/>
	<input type="hidden" name="task" value=""/>
	 
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="controller" value="<?php echo CONTROLLER_REFUND; ?>"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	
	<?php echo JHTML::_('form.token'); ?>
</form>	
</div>