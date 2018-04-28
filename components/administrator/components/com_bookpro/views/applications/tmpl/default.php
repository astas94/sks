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
//JHTML::_('behavior.tooltip');

BookProHelper::setSubmenu(1);

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$app		= JFactory::getApplication();
$listOrder = $this->escape ( $this->state->get ( 'list.ordering' ) );
$listDirn = $this->escape ( $this->state->get ( 'list.direction' ) );
$sortFields = $this->getSortFields ();
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<div class="span10" id="j-main-container">
<form action="<?php echo JRoute::_('index.php?option=com_bookpro&view=applications');?>" method="post" id="adminForm" name="adminForm">
<!--  <div id="filter-bar" class="btn-toolbar">
		<!-- search input 
		<div class="filter-search btn-group pull-left">
			<label for="filter_search" class="element-invisible">
				<?php echo JText::_('COM_BOOKPRO_SEARCH');?>
			</label>
			<input type="text" name="filter_search" id="filter_search" class="hasTooltip"
				placeholder="<?php echo JText::_('COM_BOOKPRO_SEARCH');?>"
				value="<?php echo $this->escape($this->state->get('filter.search'));?>"
				title="<?php echo JText::_('COM_BOOKPRO_SEARCH');?>"
			/>
			
		</div>
				
		
		<div class="btn-group pull-left">
			<button class="btn hasTooltip" type="submit" 
			title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT');?>"	>
				<i class="icon-search"></i>
			</button>
			<button class="btn hasTooltip" type="button"
			title="<?php echo JText::_('JSEARCH_FILTER_CLEAR');?>"
			onclick="document.id('filter_search').value='';				
				this.form.submit();" >
				<i class="icon-remove"></i>
			</button>
		</div>
	
		<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		
		
		<div class="btn-group pull-right hidden-phone">	
			<label for="directionTable" class="element-invisible">
				<?php echo JText::_('JFIELD_ORDERING_DESC');?>
			</label>
			<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
				<option value="">
					<?php echo JText::_('JFIELD_ORDERING_DESC');?>
				</option>
				<option value="asc"	<?php if($listDirn == 'asc') echo 'selected="selected"' ?>>
					<?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?>
				</option>
				<option value="desc" <?php if($listDirn=='desc') echo 'selected="selected"'?>>
					<?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?>
				</option>
			</select>	
		</div>
		
		<div class="btn-group pull-right">
			<label for="sortTable" class="element-invisible">
				<?php echo JText::_('JGLOBAL_SORT_BY');?>
			</label>
			<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
				<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
				<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); //option = columes of database?>
			</select>
		</div>
</div> -->
<div class="clearfix"></div>	
	<div id="editcell">
		<table class="adminlist table-striped table">
			<thead>
				<tr>
					<th width="1%" class="hidden-phone">
							<?php echo JHtml::_('grid.checkall'); ?>							
							
					</th>
					<th width="5%" style="min-width: 55px" class="nowrap center">
							<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder);?>
					</th>
					<th style="min-width: 55px">
							<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder);?>
					</th>
					<th style="min-width: 55px">
							<?php echo JHtml::_('grid.sort', 'Code', 'a.code', $listDirn, $listOrder);?>
					</th>
					<th width="1%" style="min-width: 55px" class="nowrap center">
							<?php echo JHtml::_('grid.sort', 'ID', 'a.id', $listDirn, $listOrder);?>
					</th>
				</tr>
			</thead>
			
			<tfoot>
					<tr>
						<td colspan="6">
						<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
			</tfoot>
			
			<tbody>
				<?php if (empty($this->items)) { ?>
					<tr><td colspan="5" class="emptyListInfo"><?php echo JText::_('No items found.'); ?></td></tr>
				<?php }?>
				<?php foreach ( $this->items as $i => $item ) :?>
				<tr class="row<?php echo $i%2;?>" sorttable-group-id="1">
					<td class="center hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id);?>
					</td>
					<td class="center ">						
						<?php
							echo JHtml::_('jgrid.published', $item->state, $i, 'applications.', true, 'cb');
							
						?>					
					</td>
					<td class="nowrap has-context">
						<a href="<?php echo JRoute::_('index.php?option=com_bookpro&task=application.edit&id='.(int)$item->id);?>">
								<?php echo $this->escape($item->title); ?>
						</a>
					</td>
					<td class="left hidden-phone">
						<?php echo $this->escape($item->code);?>
					</td>
					<td class="center hidden-phone">
						<?php echo $this->escape($item->id);?>
					</td>
				</tr>				
				<?php endforeach;?>
				
				
			</tbody>
		</table>
	</div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="applications" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
</form>	
</div>