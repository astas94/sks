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
JToolBarHelper::apply();
JToolBarHelper::deleteList('Вы уверены, что хотите удалить стоимость','delete');
JToolBarHelper::custom('emptylog','delete','','Очистить историю цен');
JToolBarHelper::custom('emptyrate','delete','','Очистить цену');

JToolBarHelper::cancel();
JHtmlBehavior::framework();
JHtmlBehavior::formvalidation();
JToolBarHelper::title(JText::_('COM_BOOKPRO_RATE_MANAGER'), 'calendar');
$itemsCount = count($this->items);
$pagination = &$this->pagination;

$mainframe=JFactory::getApplication();
$startdate=$mainframe->getUserStateFromRequest ('rate.startdate', 'startdate',JFactory::getDate()->format('Y-m-d') );
$enddate=$mainframe->getUserStateFromRequest ('rate.enddate', 'enddate',JFactory::getDate()->add(new DateInterval('P60D'))->format('Y-m-d') );


?>
<script type="text/javascript">       
 Joomla.submitbutton = function(task) {     
      var form = document.adminForm;
      form.task.value = task;

        var startDate = new Date(form.startdate.value);
        var endDate = new Date(form.enddate.value);
//alert(task);
   		if (task == 'apply') {

          if (startDate >= endDate){
            alert('<?php echo JText::_('COM_BOOKPRO_END_DATA_MUST_BE_GREATER_THAN_START_DATE'); ?>');
            return false;
          } 
          if (jQuery('#adult').val()==''){
              alert('<?php echo JText::_('Необходимо заполнить стоимость'); ?>');
              return false;
            }  

          if (jQuery('#child').val()==''){
              alert('<?php echo JText::_('Необходимо заполнить стоимость'); ?>');
              return false;
            }  
          if (jQuery('#infant').val()==''){
              alert('<?php echo JText::_('Необходимо заполнить стоимость'); ?>');
              return false;
            }  

          if (jQuery('#adult_roundrip').val()==''){
              alert('<?php echo JText::_('Необходимо заполнить стоимость'); ?>');
              return false;
            }  

          if (jQuery('#child_roundrip').val()==''){
              alert('<?php echo JText::_('Необходимо заполнить стоимость'); ?>');
              return false;
            }  
          if (jQuery('#infant_roundrip').val()==''){
              alert('<?php echo JText::_('Необходимо заполнить стоимость'); ?>');
              return false;
            }  
                     
       }
        form.submit();       
     
   }
	</script>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="span4">
		<div class="well well-small">
		<div class="row-fluid">
			
			<label><?php echo JText::_('COM_BOOKPRO_ROOM_'); ?> 
			</label>
			<?php echo $this->rooms ?>
			 <?php $linkrd = JUri::base().'index.php?option=com_bookpro&view=roomrates&bustrip_id='.$this->obj->id;?>
						<a href="<?php echo $linkrd;?>" ><i
							class="icon-calendar icon-large"></i>Просмотр</a>

			<label><?php echo JText::_('COM_BOOKPRO_START_DATE_'); ?> 
			</label>
			<?php echo JHtml::calendar($startdate, 'startdate', 'startdate','%Y-%m-%d','readonly="readonly"') ?>

			<label><?php echo JText::_('COM_BOOKPRO_END_DATE_'); ?> 
			</label>
			<?php echo JHtml::calendar($enddate, 'enddate', 'enddate','%Y-%m-%d','readonly="readonly"') ?>
			
			<label><?php echo JText::_('COM_BOOKPRO_WEEK_DAY'); ?> 
			</label>
			
			<?php echo $this->getDayWeek('weekday[]') ?>
			<hr/>			
						
			<table style="width:250px">
				<tr>
				  <td></td>
				  <td><?php echo JText::_('COM_BOOKPRO_ONEWAY'); ?></td>		
				  <td><?php echo JText::_('COM_BOOKPRO_ROUNDTRIP'); ?></td>
				</tr>
				<tr>
				  <td><?php echo JText::_('COM_BOOKPRO_ADULT'); ?></td>
				  <td><input class="input-mini required" type="text" name="adult"
					id="adult" size="60" maxlength="255" value="" required /></td>		
				  <td><input class="input-mini required" type="text"
					name="adult_roundtrip" id="adult_roundtrip" size="60"
					value="" /></td>
				</tr>
				<tr>
				  <td><?php echo JText::_('COM_BOOKPRO_CHILD'); ?></td>
				  <td><input class="input-mini required" type="text" name="child" required
					id="child" size="60" maxlength="255" value="" /></td>		
				  <td><input class="input-mini required" type="text"
					name="child_roundtrip" id="child_roundtrip" size="60" maxlength="255"
					value="" /></td>
				</tr>
				<tr>
				  <td><?php echo JText::_('COM_BOOKPRO_INFANT'); ?> </td>
				  <td><input class="input-mini required" type="text" name="infant"
					id="infant" size="60" maxlength="255" value="" /></td>		
				  <td><input class="input-mini required" type="text"
					name="infant_roundtrip" id="infant_roundtrip" size="60" maxlength="255"
					value="" /></td>
				</tr>
			</table>

	
			</div>
		</div>

	</div>
	<input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
<input type="hidden" name="controller" value="roomrate" /> 
<input type="hidden" name="task" value="save" /> 
<input type="hidden" name="boxchecked" value="1" /> 
<input type="hidden" name="cid[]" value="<?php echo $this->obj->id; ?>" id="cid" />

	<div class="span8">
		
		<div class="row-fluid">
			<?php echo $this->loadTemplate('calendar')?>
		</div>
		
		<h3><?php echo JText::_('COM_BOOKPRO_PRICE_HISTORY')?></h3>	
		<table class="table table-stripped">
			<thead>
				<tr>
					<th width="30%"><?php echo JText::_("COM_BOOKPRO_ROOM_TYPE_NAME");?>
					</th>
					<th><?php echo JText::_("COM_BOOKPRO_DATE__END_DATE");?></th>
					<th><?php echo JText::_("COM_BOOKPRO_ADULT");?>
					</th>
					<th><?php echo JText::_("COM_BOOKPRO_CHILD");?>
					</th>
					<th><?php echo JText::_("COM_BOOKPRO_INFANT");?>
					</th>
					
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="9"><?php echo $pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>


			<?php if (! is_array($this->items)) { ?>
			<tbody>
				<tr>
					<td colspan="5" class="emptyListInfo"><?php echo JText::_('COM_BOOKPRO_NO_ITEMS_FOUND'); ?>
					</td>
				</tr>
			</tbody>
			<?php 

} else {

                                     for ($i = 0; $i < $itemsCount; $i++) {
                                         $subject = &$this->items[$i];
                                         $reg=new Joomla\Registry\Registry();
                                         $reg->loadString($subject->params);
                                         $params=$reg->toArray();
                                         ?>
			<tbody>
				<tr <?php if($i==0) echo 'class="success"'?>>

					<td><?php echo $subject->from_name ?>-<?php echo $subject->to_name ?></td>
					<td style="font-weight: normal;"><?php echo DateHelper::formatDate($params['start'],'Y-m-d').' '.JText::_('COM_BOOKPRO_TO').' '.DateHelper::formatDate($params['end'],'Y-m-d'); ?>
					</td>
					<td><?php echo CurrencyHelper::displayPrice($params['adult']) ?></td>
					<td><?php echo CurrencyHelper::displayPrice($params['child']) ?></td>
					<td><?php echo CurrencyHelper::displayPrice($params['infant']) ?></td>
					
				</tr>
			</tbody>
			<?php 
                                    }
                                }
                                ?>
		</table>

	</div>



	<?php echo JHTML::_('form.token'); ?>
</form>

