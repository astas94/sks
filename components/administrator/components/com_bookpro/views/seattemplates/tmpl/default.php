<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 26 2012-07-08 16:07:54Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

/* @var $this BookingViewReservations */

JHTML::_('behavior.tooltip');

$bar = JToolBar::getInstance('toolbar');

BookProHelper::setSubmenu(2);




$colspan = $this->selectable ? 9 : 10;

echo $this->selectable;

$editCustomer = JText::_('Edit Seat');
$titleEditAcount = JText::_('Edit Seat');


$orderDir = $this->lists['order_Dir'];
$order = $this->lists['order'];

$itemsCount = count($this->items);

$pagination = &$this->pagination;

?>
<div class="span10">
<form action="index.php?option=com_bookpro&view=seattemplates" method="post" name="adminForm" id="adminForm">
		<table class="table" >
			<thead>
				<tr>
					<th width="1%">#</th>
					<?php if (! $this->selectable) { ?>
						<th width="2%">
							<input type="checkbox" class="inputCheckbox" name="toggle" value="" onclick="checkAll(<?php echo $itemsCount; ?>);" />
						</th>
					<?php } ?>	
					
					<th class="title" width="20%">
				        <?php echo JText::_('COM_BOOKPRO_TITLE') ?>
					</th>
					<th width="4%">
				        <?php echo JHTML::_('grid.sort', 'ID', 'id', $orderDir, $order); ?>
					</th>
					<th class="title" width="5%">
				        <?php echo JText::_('Действия') ?>
					</th>					
				</tr>
			</thead>
			<tfoot>
    			<tr>
    				<td colspan="<?php echo $colspan; ?>">
    				    <?php echo $pagination->getListFooter(); ?>
    				</td>
    			</tr>
			</tfoot>
			<tbody>
				<?php if (! is_array($this->items) || ! $itemsCount) { ?>
					<tr><td colspan="<?php echo $colspan; ?>"><?php echo JText::_('No items found.'); ?></td></tr>
				<?php } else { ?>
				    <?php for ($i = 0; $i < $itemsCount; $i++) { ?>
				    
				    	<?php $subject = &$this->items[$i];
				    	
							$link = JRoute::_(ARoute::edit(CONTROLLER_SEATTEMPLATE, $subject->id));
				    	?>
				    	     
				    	<tr class="row<?php echo ($i % 2); ?>">
				    		<td  style="text-align: right; white-space: nowrap;"><?php echo number_format($pagination->getRowOffset($i), 0, '', ' '); ?></td>
				    		<?php if (! $this->selectable) { ?>
				    			<td class="checkboxCell"><?php echo JHTML::_('grid.checkedout', $subject, $i); ?></td>
				    		<?php } ?>
				    		<td><a href="<?php echo JRoute::_('index.php?option=com_bookpro&task=seattemplate.edit&id='.$subject->id);?>"><?php echo $subject->title; ?></a></td>
				    		<td style="text-align: right; white-space: nowrap;"><?php echo number_format($subject->id, 0, '', ' '); ?></td>
				    		<td>
				    		    <input type="submit" class="input-mini btn btn-success" name="departbtn" value="Дублировать" onclick="document.getElementById('maintask').value='dublicatebus';document.getElementById('idval').value='<?php echo number_format($subject->id, 0, '', ' '); ?>';" />		
				    		</td>
				    	</tr>
				    <?php } ?>
				<?php } ?>
			</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
		<input type="hidden" id="idval" name="idval" value="" />	
		<input type="hidden" id="maintask" name="task" value="dublicatebus" />	
		<input type="hidden" name="controller" value="seattemplates" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	<?php echo JHTML::_('form.token'); ?>
</form>	
</div>