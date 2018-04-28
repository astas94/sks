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

JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addScript(JUri::base().'components/com_bookpro/assets/js/bootstrap-timepicker.min.js');
$document->addStyleSheet(JUri::base().'components/com_bookpro/assets/css/bootstrap-timepicker.min.css');

$bar = JToolBar::getInstance('toolbar');
//JToolBarHelper::addNew();
$bar->appendButton( 'Link', 'back', 'Назад', 'index.php?option=com_bookpro&view=bustrips');

//JToolBarHelper::cancel();
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
	
	<?php
        	$route_arr = explode (",",$this->obj->route);
	        $time_to = $this->getFullBustrip($this->obj->id,$route_arr);
	        //var_dump($time_to);
	        $time_to2 = $this->getFullBustrip2($this->obj->id,$route_arr);
	        //var_dump($time_to2);
	        $route_arr_ret= array_reverse ($route_arr);
	        $time_return = $this->getFullBustripReturn($this->obj->id,$route_arr_ret);
	
	?>

	<div class="span8">
	    <h3>Маршрут № <?php echo ($this->obj->code) ?></h3>
	    <div>


	        <table>
	            	            <th style="width:230px;">
	                Пункт назначения
	            </th>
	            <th style="width:210px;">
	                Маршрут туда
	            </th>
	            <?php if($time_return != null){ ?>
	            <th style="width:210px;">
	                Маршрут обратно
	            </th>
	            <?php } ?>
	        </table>
	        <table>
	            	            <th style="width:230px;">
	                
	            </th>
	            <th style="width:105px;">
	                Прибытие
	            </th>
	            <th style="width:105px;">
	                Отправление
	            </th>
	            <?php if($time_return != null){ ?>
	            <th style="width:105px;">
	                Прибытие
	            </th>
	            <th style="width:105px;">
	                Отправление
	            </th>
	            <?php } ?>
	        </table>
	        <table>

	        <?php
	        
	        //var_dump($time_return);

	        
	       // var_dump($time_return);
	        $time_return2 = $this->getFullBustripReturn2($this->obj->id,$route_arr_ret);
	        //var_dump($time_return2);
	        //var_dump ($time_to);
	        
	        $temp000 = '';
	        $temp000return = '';
	        
	        $icount=0;
	        
	        foreach ($route_arr as $arr_item){
	            if ($icount==0)
				{
				    $temp000 = $time_to[$icount]->start_time;
				    if($time_return != null){
	                    $temp000return = $time_return[count($time_return)-1]->end_time;
				    }
				}
				else if ($icount!= (count($route_arr)-1))
				{  
				    $temp000 =$temp000.','. ($time_to[$icount]->start_time);
				    if($time_return != null){
	                    $temp000return = ($time_return[count($time_return)-$icount-1]->start_time).','.$temp000return;
				    }
				}
				else
				{
				    $temp000 =$temp000.','. ($this->obj->end_time);
				    if($time_return != null){
	                    $temp000return = ($time_return[count($time_return)-$icount-1]->start_time).','.$temp000return;
				    }
	                //var_dump ($time_return);
	                //var_dump($this->obj);
				}
	            
	            $icount=$icount+1;
	        }
	        //var_dump ($time_return);
	        //echo $temp000.'---'.$temp000return;
	        
            $icount=0;
	        
	        foreach ($route_arr as $arr_item){  ?>
	            <tr>
	                <td>
        	            <form action="index.php" method="post" name="adminForm" >
        	            <div class="form-inline">
        				<?php 	echo $this->getDestinationSelectBox($arr_item);	 ?>
        				    
        							<div class="input-append bootstrap-timepicker" style="width:106px;">
                                        <?php if ($icount>0) { ?>
        							    <input type="text" class="input-mini timepicker validate-duration" name="arrival1" value="<?php echo ($icount>0?  $time_to2[$icount]->end_time : $this->obj->end_time) ?>" />
        							    <span class="add-on"><i class="icon-clock"></i></span>
        							    <?php }  ?>

        							    
        							</div>
        							<div class="input-append bootstrap-timepicker" style="width:106px;">
                                        <?php if ($icount<((count($time_to)-1))) { ?>
        							    <input type="text" class="input-mini timepicker validate-duration" name="depart1" value="<?php echo ((count($time_to)-1)>$icount?  $time_to[$icount]->start_time : $this->obj->end_time) ?>" />
        							    <span class="add-on"><i class="icon-clock"></i></span>
        							    <?php }  ?>
        							</div>
        							<?php if($time_return != null){ ?>
        							<div class="input-append bootstrap-timepicker" style="width:106px;">
        							    <?php if ($icount<((count($time_to)-1))) { ?>
        							    <input type="text" class="input-mini timepicker validate-duration" name="arrival2" value="<?php echo ($time_return2[count ($route_arr) -$icount-2]->end_time ) ?>" />
        							    <span class="add-on"><i class="icon-clock"></i></span>
        							    <?php }  ?>
        							</div>
        							<div class="input-append bootstrap-timepicker" style="width:106px;">
        							    <?php if ($icount>0) { ?>
        							    <input type="text" class="input-mini timepicker validate-duration" name="depart2" value="<?php echo (0<$icount?  $time_return[count ($route_arr) -$icount-1]->start_time : $time_return[count($time_return)-1]->end_time) ?>" />
        							    <span class="add-on"><i class="icon-clock"></i></span>
        							    <?php }  ?>
        							</div>
        							<?php }  ?>
        							
        							<div class="input-append bootstrap-timepicker" style="width:106px;">
        							    <input type="submit" class="input-mini btn btn-success" name="departbtn<?php echo ('_' . $arr_item . '_' . $icount) ?>" value="Сохранить" />
        							</div>
        							
        							<?php 
        							
        							?>
        
        							<input type="hidden" name="depart0" value="<?php echo ($arr_item) ?>" /> 
        							
        							<input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
        							<input type="hidden" name="route" value="<?php echo ($this->obj->route); ?>" /> 
        							<input type="hidden" name="controller" value="roomrate2" /> 
                                <input type="hidden" name="task" value="saveonechange" />
        
                                <input type="hidden" name="idval" value="<?php echo ($this->obj->id)?>" />
                                
        				</div>
				    </form>
				</td>
				<?php if ($icount<count($route_arr)-1) { ?>
				<td>
    				<form action="index.php" method="post" name="adminForm<?php echo ('_' . $arr_item ) ?>" >
    				    <div class="form-inline">
    				    <div class="input-append bootstrap-timepicker">
    						<input type="submit" class="input-mini btn btn-success" name="departbtn<?php echo ('_' . $arr_item . '_' . $icount) ?>" value="Добавить" />
    					</div>
    				    
    				    <input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
    					<input type="hidden" name="controller" value="roomrate2" /> 
                        <input type="hidden" name="task" value="addonechange" />
                        <input type="hidden" name="idval" value="<?php echo ($this->obj->id)?>" />
    	                <input type="hidden" name="route" value="<?php echo ($this->obj->route); ?>" /> 
    	                <input type="hidden" name="routetime" value="<?php echo ($temp000); ?>" /> 
    	                <input type="hidden" name="routereverttime" value="<?php echo ($temp000return); ?>" /> 
    	                <input type="hidden" name="routenumber" value="<?php echo ($icount); ?>" /> 
    	                <input type="hidden" name="code" value="<?php echo ($this->obj->code)?>" />
    	                </div>
    	            </form>
	            </td>
	            <?php } ?>
	            <?php if (($icount>0) and ($icount<count($route_arr)-1)) { ?>
	            <td>
    	            <form action="index.php" method="post" name="adminForm<?php echo ('_' . $arr_item ) ?>" >
    				    <div class="form-inline">
    				    <div class="input-append bootstrap-timepicker">
    						<input type="submit" class="input-mini btn btn-danger" name="departbtn<?php echo ('_' . $arr_item . '_' . $icount) ?>" value="Удалить" />
    					</div>
    				    <input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
    				    <input type="hidden" name="controller" value="roomrate2" /> 
                        <input type="hidden" name="task" value="delonechange" />
                        <input type="hidden" name="idval" value="<?php echo ($this->obj->id)?>" />
    	                <input type="hidden" name="route" value="<?php echo ($this->obj->route); ?>" /> 
                        <input type="hidden" name="depart0" value="<?php echo ($arr_item) ?>" /> 
                        </div>
    	            </form>
	            </td>
				<?php } ?>
				</tr>
	        <?php  $icount=$icount+1; } ?>
	        </table>
	    </div>
	    
	    <?php 
	    //print_r (($this->obj)); 
	    
	    ?>
	    
	</div>
	<input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
<input type="hidden" name="controller" value="roomrate" /> 
<input type="hidden" name="task" value="save" /> 
<input type="hidden" name="boxchecked" value="1" /> 
<input type="hidden" name="cid[]" value="<?php echo $this->obj->id; ?>" id="cid" />

	<div class="span8">

	</div>



	<?php echo JHTML::_('form.token'); ?>

<script type="text/javascript">

jQuery(document).ready(function($) {
	
	$('.timepicker').timepicker({
		 
	    template: 'modal',
	    modalBackdrop:false,
	    appendWidgetTo: 'body',
	    
	    showMeridian: false
	    
	});
	$('.timeduration').timepicker({
	    minuteStep: 1,
	    template: 'modal',
	    appendWidgetTo: 'body',
	    showSeconds: true,
	    showMeridian: false,
	    defaultTime: false
	});
	
	
});				 
</script>
