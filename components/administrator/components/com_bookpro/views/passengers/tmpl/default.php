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
AImporter::helper('currency','date');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
$config = JComponentHelper::getParams('com_bookpro');


BookProHelper::setSubmenu();

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$params		= (isset($this->state->params)) ? $this->state->params : new JObject;
$saveOrder	= $listOrder == 'ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_bookpro&task=passengers.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
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
<div class="span10">
	<form action="index.php?option=com_bookpro&view=passengers"
		method="post" name="adminForm" id="adminForm">


		<div id="j-main-container">
			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search pull-left form-inline">
					<input id="filter_search" name="filter_search" value="<?php echo $this->state->get('filter.search')?>" class="input" placeholder="<?php echo JText::_('COM_BOOKPRO_KEYWORD')?>" >
					&nbsp;<?php echo $this->agents ?>
					
				</div>
				<div class="btn-group pull-left">
					<button type="submit" class="btn hasTooltip"
						title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>">
						<i class="icon-search"></i>
					</button>
					<button type="button" class="btn hasTooltip"
						title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"
						onclick="document.id('filter_search').value='';this.form.submit();">
						<i class="icon-remove"></i>
					</button>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?>
					</label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?>
					</label> <select name="directionTable" id="directionTable"
						class="input-medium" onchange="Joomla.orderTable()">
						<option value="">
							<?php echo JText::_('JFIELD_ORDERING_DESC');?>
						</option>
						<option value="asc"
						<?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>>
							<?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?>
						</option>
						<option value="desc"
						<?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>>
							<?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?>
						</option>
					</select>
				</div>
				<div class="btn-group pull-right">
					<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?>
					</label> <select name="sortTable" id="sortTable"
						class="input-medium" onchange="Joomla.orderTable()">
						<option value="">
							<?php echo JText::_('JGLOBAL_SORT_BY');?>
						</option>
						<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
					</select>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

<br/>
		<table class="table" id="articleList">
			<thead>
				<tr>

					<th width="1%"><input type="checkbox" name="checkall-toggle"
						value="" title="(<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>"
						onclick="Joomla.checkAll(this)" />
					</th>
					<?php if ($config->get('ps_firstname')){?>
					<th><?php echo JHTML::_('grid.sort', JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME'), 'a.firstname', $listDirn, $listOrder ); ?>
					</th>
					<?php }?>
					
<?php if ($config->get('ps_midlename')){?>
					<th width="10%"><?php echo JHTML::_('grid.sort', JText::_('COM_BOOKPRO_PASSENGER_MIDLENAME'), 'a.midlename', $listDirn, $listOrder ); ?>
					</th>
					<?php }?>

					<?php if ($config->get('ps_lastname')){?>
					<th width="10%"><?php echo JHTML::_('grid.sort', JText::_('COM_BOOKPRO_PASSENGER_LASTNAME'), 'a.lastname', $listDirn, $listOrder ); ?>
					</th>
					<?php }?>
					
					<?php if ($config->get('ps_group')){?>
					<th width="10%"><?php echo JHTML::_('grid.sort', JText::_('COM_BOOKPRO_PASSENGER_GROUP'), 'a.group_id', $listDirn, $listOrder ); ?>
					</th>
					<?php }?>

					<?php if ($config->get('ps_gender')){?>
					<th width="10%"><?php echo JHTML::_('grid.sort', JText::_('COM_BOOKPRO_GENDER'), 'a.gender', $listDirn, $listOrder ); ?>
					</th>
					<?php }?>
					
					<?php if ($config->get('ps_birthday')){?>
					<th width="10%"><?php echo JHTML::_('grid.sort',JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY'), 'a.birthday', $listDirn, $listOrder ); ?>
					</th>
					<?php }?>
					
				 
					

				
					<th><?php echo JText::_('COM_BOOKPRO_PASSENGER_TICKET_NO') ?>
					</th>
					<th><?php echo JText::_("COM_BOOKPRO_ORDER_STATUS") ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="11"><?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php
				if (count($this->items)) :
				foreach ($this->items as $i => $item) :
				$canCreate  = $user->authorise('core.create');
				$canEdit    = $user->authorise('core.edit');
				$canChange  = $user->authorise('core.edit.state');
					
				$disableClassName = '';
				$disabledLabel	  = '';
				if (!$saveOrder) {
					$disabledLabel    = JText::_('JORDERINGDISABLED');
					$disableClassName = 'inactive tip-top';
				}

				$onclick = "";
					
			
    			$link = JRoute::_( 'index.php?option=com_bookpro&view=passenger&task=passenger.edit&id='. $item->id );
    			$checked = JHTML::_('grid.id', $i, $item->id);

    			?>
				<tr class="row<?php echo $i % 2; ?>">

					<td><?php echo $checked;  ?></td>
					<?php if ($config->get('ps_firstname')){?>
						<td>
							<div class="pull-left">
								<?php if ($canEdit) : ?>
								<a href="<?php  echo $link; ?>"> <?php  echo $this->escape($item->firstname); ?>
								</a>
								<?php  else : ?>
								<?php  echo $this->escape($item->firstname); ?>
								<?php  endif; ?>
	
							</div>
							<div class="pull-left">
								<?php
								// Create dropdown items
								JHtml::_('dropdown.edit', $item->id, 'passenger.');
	
								// render dropdown list
								echo JHtml::_('dropdown.render');
								?>
							</div>
						</td>
					<?php } ?>
					<?php if ($config->get('ps_midlename')){?>
						<td><?php echo $item->midlename; ?></td>
					<?php } ?>
					<?php if ($config->get('ps_lastname')){?>
						<td><?php echo $item->lastname; ?></td>
					<?php } ?>
					
					<?php if ($config->get('ps_group')){?>
						<td><?php echo $item->group_title; ?></td>
					<?php } ?>

					<?php if ($config->get('ps_gender')){?>
						<td><?php echo BookProHelper::formatGender($item->gender) ?></td>
					<?php } ?>
				 
				 	<?php if ($config->get('ps_birthday')){?>
						<td>
						<?php if($item->birthday !=""):?>
							<?php 
							echo DateHelper::toShortDate($item->birthday);
							?>
						<?php endif;?>
						</td>
					<?php } ?>
					
					<td><?php echo $item->order_number.'-'.$item->id; ?></td>
					<td><?php echo OrderStatus::format($item->order_status) ?></td>
				</tr>
				<?php

				endforeach;
				else:
				?>
				<tr>
					<td colspan="12"><?php echo JText::_( 'There are no items present' ); ?>
					</td>
				</tr>
				<?php
				endif;
				?>
			</tbody>
		</table>

		<input type="hidden" name="option" value="com_bookpro" /> <input
			type="hidden" name="task" value="passenger" /> <input type="hidden"
			name="view" value="passengers" /> <input type="hidden"
			name="boxchecked" value="0" /> <input type="hidden"
			name="filter_order" value="<?php echo $listOrder; ?>" /> <input
			type="hidden" name="filter_order_Dir" value="" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
