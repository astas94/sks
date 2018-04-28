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

JToolBarHelper::apply();


JHtmlBehavior::framework();

$bar = JToolBar::getInstance('toolbar');
//JToolBarHelper::addNew();
$bar->appendButton( 'Link', 'cancel', 'Отмена', 'index.php?option=com_bookpro&view=roomrate3&bustrip_id='.$this->obj->id);
JHtmlBehavior::formvalidation();
JToolBarHelper::title(JText::_('COM_BOOKPRO_RATE_MANAGER'), 'calendar');

$itemsCount = count($this->items);
$pagination = &$this->pagination;

$mainframe=JFactory::getApplication();
$startdate=$mainframe->getUserStateFromRequest ('rate.startdate', 'startdate',JFactory::getDate()->format('Y-m-d') );
$enddate=$mainframe->getUserStateFromRequest ('rate.enddate', 'enddate',JFactory::getDate()->add(new DateInterval('P60D'))->format('Y-m-d') );


?>
  <style>
   .example {
    border: dashed 1px #634f36; /* Параметры рамки */
    background: #fffff5; /* Цвет фона */
    font-family: "Courier New", Courier, monospace; /* Шрифт текста */
    padding: 7px; /* Поля вокруг текста */
    margin: 0 0 1em; /* Отступы вокруг */
   }
   .exampleTitle {
    border: 1px solid black; /* Параметры рамки */
    border-bottom: none; /* Убираем линию снизу */
    padding: 3px; /* Поля вокруг текста */
    display: inline; /* Устанавливаем как встроенный элемент */
    background: #efecdf; /* Цвет фона */
    font-weight: bold; /* Жирное начертание */
    font-size: 90%; /* Размер текста */
    margin: 0; /* Убираем отступы вокруг */
    white-space: nowrap; /* Отменяем переносы текста */
   }
  </style>
<script type="text/javascript">       
 Joomla.submitbutton = function(task) {     
      var form = document.adminForm;
      //form.task.value = task;
      
             // var startDate = new Date(form.startdate.value);
        //var endDate = new Date(form.enddate.value);
//alert(task);

        form.submit();       
     
   }
	</script>

	<div class="span8">
	    <p>Маршрут № <?php echo ($this->obj->code) ?></p>
	    


			
		
	    <div>
	        <?php //var_dump ($this->getFullBustripReturn($this->obj->id)); 
	        
	        if (isset($_GET["timeopt"]))
	        {
	            $this->obj->timeopt=$_GET["timeopt"];
	            
	        }
	        else {
	             $this->obj->timeopt=0;
	             //var_dump ($this);
	        }
	        
	        
	        //echo ('111111111111111'.(isset($this->obj)==true));
	        


	        ?>

			
			<?php
			//var_dump ($this);
					$route_arr = explode (",",$this->obj->route);
			$timex_all = $this->getAllTimesInterval($this->obj->id,$route_arr[0],$route_arr[1]);
        	//var_dump($timex_all);	
			
            ?>
            
            
           
	
	        <table >
	        <form action="index.php" method="post" name="adminForm" >
	            
	            <tr>
	                <td>
                        <!--input type="submit" class="input-mini btn btn-success" name="savebtn" value="Сохранить" /-->
	                    <!--input type="submit" class="input-mini btn btn-danger" name="savebtn" value="Удалить" onclick="document.getElementById('maintask').value='deleteonechangeprice'" /-->

        			</td>
	            </tr>

	            <tr>
	                <td>
	                    <label><?php echo JText::_('COM_BOOKPRO_START_DATE_'); ?> 
			</label>
			<?php echo JHtml::calendar($startdate, 'startdate', 'startdate','%Y-%m-%d','readonly="readonly"') ?>

			<label><?php echo JText::_('COM_BOOKPRO_END_DATE_'); ?> 
			</label>
			<?php echo JHtml::calendar($enddate, 'enddate', 'enddate','%Y-%m-%d','readonly="readonly"') ?>
			<br/>
	                    <label><?php echo JText::_('COM_BOOKPRO_WEEK_DAY'); ?> 
			            </label>
			
			            <?php echo $this->getDayWeek('weekday[]', '1,2,3,4,5,6,7') ;?>
			<br/><br/>
	                </td>
	            </tr>
	            <tr>
	        <?php
	        //$route_arr = explode (",",$this->obj->route);
	        $time_to = $this->getFullBustrip($this->obj->id,$route_arr);
	        $route_arr_ret= array_reverse ($route_arr);
	        $time_return = $this->getFullBustripReturn($this->obj->id,$route_arr_ret);
	        //var_dump ($time_to);
	        
	        $temp000 = '';
	        $temp000return = '';
	        //var_dump ($route_arr);
	        
            $icount=0;
            
            
            
            
            ?>		
        	
	        </tr>
	        <?php 
	        foreach ($route_arr as $arr_item){  
        	         $prices=null;
        	    for ($i = 0; $i < $icount; $i++) { 
        	        try {
        	            //var_dump($timex_all);die;
        	            if (count($timex_all)>0){
        	                $prices = $this->getPriceBustrip($this->obj->id,$route_arr[$i],$arr_item, $timex_all[$this->obj->timeopt]->date);
        	            }
        	        }
        	        catch (Exception $e){
        	            
        	        }
        	    
        	    ?>
                    <td style="border: 1px solid black;">	    
        			     <table>
        			         <tr>
        			             <td>
        			                 В:
        			             </td>
        			             <td >
        			                 <input type="text" class="input-mini" name="price[]" value="<?php if($prices!=null){ echo (isset ($prices[0]->adult)?$prices[0]->adult :'');} ?>" />
        			             </td>

        			         </tr>
        			         
        			     </table>
        			 </td>

        			 <input type="hidden" name="idrouteto[]" value="<?php echo ($arr_item)?>" />
        			 <input type="hidden" name="idroutefrom[]" value="<?php echo ($route_arr[$i])?>"  />
            <?php    }   
            ?>
	            
	                <td>
        	            
        				<?php 	echo $this->getDestinationSelectBox($arr_item);	 ?>
        			</td>
        			

        

                                
        				
				    
				
				
				</tr>
	        <?php  $icount=$icount+1; } ?>

        							
        							<input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
        							<input type="hidden" name="route" value="<?php echo ($this->obj->route); ?>" /> 
        							<input type="hidden" name="controller" value="roomrate4" /> 
                                <input type="hidden" name="task" id="maintask" value="addonechangeprice" />
                                <input type="hidden" name="timeopt" value="<?php echo ($this->obj->timeopt)?>" />
                                <input type="hidden" name="idval" value="<?php echo ($this->obj->id)?>" />
	            </form>
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
document.timeform.optvalue[<?php echo($this->obj->timeopt);?>].checked = true;


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
