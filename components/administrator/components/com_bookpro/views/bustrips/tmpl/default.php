<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

/* @var $this BookingViewSubjects */
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('bootstrap.tooltip');
AImporter::helper('date','currency');

BookProHelper::setSubmenu(1);

$itemsCount = count($this->items);
$pagination = &$this->pagination;

$listOrder = $this->escape ( $this->state->get ( 'list.ordering' ) );
$listDirn = $this->escape ( $this->state->get ( 'list.direction' ) );
?>

<div class="span10">
	<form action="<?php echo JRoute::_('index.php?option=com_bookpro&view=bustrips'); ?>" method="post" name="adminForm" id="adminForm">
		<div>
			<div class="form-inline">
				
				<?php echo $this->dfrom;?>
				<?php echo $this->dto;?>
				<?php echo $this->agents;?>
				<!-- 
				<button class="btn" onclick="this.form.submit();"><?php echo JText::_('COM_BOOKPRO_SEARCH'); ?></button>
				 -->
			</div>
		</div>
		<table class="table">
			<thead>
				<tr>

					<th width="1%" class="hidden-phone"><?php echo JHtml::_('grid.checkall'); ?>

					</th>
					<th width="1%"><?php echo JHTML::_('grid.sort', JText::_('JSTATUS'), 'state', $listDirn, $listOrder); ?>
					</th>
					<th class="title" width="10%"><?php echo JHTML::_('grid.sort', JText::_('COM_BOOKPRO_BUSTRIP_TITLE'), 'title', $listDirn, $listOrder); ?>
					</th>
					<th width="5%"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE'); ?>
					
					<th width="5%"><?php echo JText::_('COM_BOOKPRO_COMPANY'); ?>
					</th>
					<th width="5%"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_BUS'); ?>
					</th>
					<th width="5%"><?php echo JText::_('COM_BOOKPRO_SEATTEMPLATE'); ?>
					</th>
					<th width="5%"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_START_TIME'); ?>
					</th>
					<th width="5%"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_END_TIME'); ?>
					</th>

					<th width="7%"><?php echo JText::_('Действия'); ?>
					</th>
					
					 
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="10"><?php echo $pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php 
						 for ($i = 0; $i < count($this->items); $i++) {
				    	 	$subject = &$this->items[$i];
				    	 	?>
				<tr class="<?php if (($subject->price==0) || !$subject->seattemplate_title ) echo "warning"; else echo "success" ?>">

					<td class="checkboxCell"><?php echo JHTML::_('grid.checkedout', $subject, $i); ?>
					</td>
					<td>
					<?php echo JHtml::_('jgrid.published', $subject->state, $i, 'bustrips.', true, 'cb', null,null); ?>
					</td>
					<td><?php echo str_repeat('<span class="gi">&mdash;</span>', $subject->level - 1) ?>
						<a	href="<?php echo JRoute::_('index.php?option=com_bookpro&task=bustrip.edit&id='.$subject->id);?>" target="_blank"><?php echo $subject->title; ?> </a>
					</td>
					<td><a href="<?php echo JUri::base().'index.php?option=com_bookpro&view=route&id='.$subject->id?>"><?php  echo $subject->code;?></a>
					<br/><a href="<?php echo JUri::base().'index.php?option=com_bookpro&view=route&id='.$subject->id?>"><?php echo JText::_('COM_BOOKPRO_VIEW_ROUTE_MAP'); ?></a>
					<td><?php  echo $subject->brandname;?>
					</td>
					<td><?php  echo $subject->bus_name;?>
					</td>
					<td><?php  echo $subject->seattemplate_title;?>
					</td>
					
					<td><?php echo JFactory::getDate($subject->start_time)->format('H:i'); ?></td>
					<td><?php echo JFactory::getDate($subject->end_time)->format('H:i'); ?></td>
					
					<?php 
					$color='';
					if($subject->price > 0){
						$color='style="color:blue;"';
					}else{
						$color='style="color:red"';
						}
					?>
					<td>
					
					
					
					

				    <?php $linkr = ARoute::view('roomrate2',null,null,array('bustrip_id'=>($subject->associated_parent_id!=0)?$subject->associated_parent_id:$subject->id));?>
						<a href="<?php echo $linkr;?>" class="btn btn-success"><?php echo JText::_('Изменить маршрут') ?></a> <?php $linkrd = ARoute::view('roomrates2',null,null,array('bustrip_id'=>$subject->id));?>
					<?php $linkr = ARoute::view('roomrate3',null,null,array('bustrip_id'=>($subject->associated_parent_id!=0)?$subject->associated_parent_id:$subject->id));?>
						<a href="<?php echo $linkr;?>" class="btn btn-success"><?php echo JText::_('Задать цены') ?></a> <?php $linkrd = ARoute::view('roomrates2',null,null,array('bustrip_id'=>$subject->id));?>
				    <?php $linkr = ARoute::view('roomrate3',null,null,array('bustrip_id'=>($subject->associated_parent_id!=0)?$subject->associated_parent_id:$subject->id));?>
				    
				    <a href="<?php echo JRoute::_('index.php?option=com_bookpro&view=seattemplate&layout=edit&id='.$subject->seattemplate_id).'&bustrip=1';?>" class="btn btn-success"><?php echo JText::_('Изменить схему мест') ?></a>
						
					<?php $linkrd = ARoute::view('seattemplate',null,null,array('bustrip_id'=>$subject->id));?>
				    <input type="submit" class="input-mini btn btn-danger" name="departbtn" value="Удалить" onclick="document.getElementById('maintask').value='delete1';document.getElementById('maincontroller').value='bustrips';document.getElementById('idval').value='<?php echo (($subject->associated_parent_id!=0)?$subject->associated_parent_id:$subject->id)?>';" />		


					</td>

					 
				<?php 
}

					?>
			</tbody>
		</table>
        <input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
		<input type="hidden" id="maincontroller" name="controller" value="" />
		<input type="hidden" name="idval" id="idval" value="" />
		<input type="hidden" id="maintask" name="task" value="" />		
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHTML::_('form.token'); ?>
	</form>
</div>
