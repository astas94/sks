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
JHtmlBehavior::framework();
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

	<div class="span8">
	    <p>Маршрут № <?php echo ($this->obj->code) ?></p>
	    


			
		
	    <div>
	        <?php //var_dump ($this->getFullBustripReturn($this->obj->id)); 
	        
	        if (isset($_GET["timeopt"]))
	        {
	            $int=(int)$_GET["timeopt"];
	            $this->obj->timeopt= $int;
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
			$timex_all = $this->getAllTimesInterval($this->obj->id,$route_arr[0],$route_arr[count($route_arr)-1]);
        	//var_dump($route_arr);	
			
            ?>
            
            
            <table >
                <tr>
                    <td>
	        <form name="timeform" action="index.php">
	            <fieldset style="width: 60%" align=center>
	                <?php
	                    for ($i = 0; $i < count($timex_all); $i++) {
                            echo ('<input name=optvalue value='.$i.' type=radio >' . ' Цены с '. JHTML::_('date', $timex_all[$i]->date, JText::_('DATE_FORMAT_LC')) .' по ' . JHTML::_('date', $timex_all[$i]->date_end, JText::_('DATE_FORMAT_LC'))  .'<br/><br/>');
	                    }
	                    //echo (count($timex_all));
	                ?>

                    <?php if (count($timex_all)>0) { ?> 
                    <p><input type=submit class="input-mini btn btn-success" value="Просмотреть цены за период">
                    <?php } ?> 
                    <p><input type=submit class="input-mini btn btn-success" onclick="document.getElementById('addperiodtask').value='addperiod'" value="Добавить новый период">
                    
                    <input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
        			<input type="hidden" name="route" value="<?php echo ($this->obj->route); ?>" /> 
        			<input type="hidden" name="controller" value="roomrate3" /> 
                    <input type="hidden" id="addperiodtask" name="task" value="getTimePrice" />
                    <input type="hidden" name="idval" value="<?php echo ($this->obj->id)?>" />
                </fieldset>
	        </form>
			</div>
			</td>
	        <td>
	        <?php if (count($timex_all)>0) { ?> 
			<panel>
			    <p class="exampleTitle">Таблица цен</p>
	        <table class="example">
	        <form action="index.php" method="post" name="adminForm" >
	            <input type="hidden" name="option" value="<?php echo OPTION; ?>" /> 
        							<input type="hidden" name="route" value="<?php echo ($this->obj->route); ?>" /> 
        							<input type="hidden" name="controller" value="roomrate3" /> 
                                <input type="hidden" name="task" id="maintask" value="saveonechangeprice" />
                                <input type="hidden" name="timeopt" value="<?php echo ($this->obj->timeopt)?>" />
                                <input type="hidden" name="idval" value="<?php echo ($this->obj->id)?>" />
	            <tr>
	                <td>
	                    <br/>
	                    <input type="submit" class="input-mini btn btn-success" name="savebtn" value="Сохранить" />
	                    <input type="submit" class="input-mini btn btn-danger" name="savebtn" value="Удалить" onclick="document.getElementById('maintask').value='deleteonechangeprice'" />
	                    <br/>
        			</td>
	            </tr>
	            <tr>
	                <td colspan="2">
	                    <?php echo ('Цены с '. JHTML::_('date', $timex_all[$this->obj->timeopt]->date, JText::_('DATE_FORMAT_LC')) .' по ' . JHTML::_('date', $timex_all[$this->obj->timeopt]->date_end, JText::_('DATE_FORMAT_LC'))  .'<br/>');
	            ?>
	            <input type="hidden" name="datestart" value="<?php echo ($timex_all[$this->obj->timeopt]->date)?>" />
	            <input type="hidden" name="dateend" value="<?php echo ($timex_all[$this->obj->timeopt]->date_end)?>" />
	                </td>
	            </tr>
	            <tr>
	                <td colspan="2">
	                    <label><?php echo JText::_('COM_BOOKPRO_WEEK_DAY'); ?> 
			            </label>
			
			            <?php echo $this->getDayWeek('weekday[]', $timex_all[$this->obj->timeopt]->weekdays) ;?>
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
	        <tr style="min-width:100px !important; min-height:120px !important;">
	        <?php 
	        foreach ($route_arr as $arr_item){  
        	         
        	    for ($i = 0; $i < $icount; $i++) { 
        	    $prices = $this->getPriceBustrip($this->obj->id,$route_arr[$i],$arr_item, $timex_all[$this->obj->timeopt]->date);
        	    
        	    ?>
                    <td style="border: 1px solid black;">	    
        			     <table>
        			         <tr>
        			             <td>
        			                 В:
        			             </td>
        			             <td >
        			                 <input type="text" class="input-mini" name="price[]" value="<?php echo (isset ($prices[0]->adult)?$prices[0]->adult :'-'); ?>" />
        			             </td>

        			             <td>
        			                <input type="hidden" class="input-mini" name="priceret[]" value="<?php echo (isset ($prices[0]->adult_roundtrip)? $prices[0]->adult_roundtrip : '-' ); ?>" />
        			             </td>
        			         </tr>

        			     </table>
        			 </td>
        			 <input type="hidden" name="idprice[]" value="<?php echo (isset($prices[0]->id)?$prices[0]->id:0)?>" />
        			 <input type="hidden" name="idpriceret[]" value="<?php echo (isset ($prices[1]->id)?$prices[1]->id:0)?>" />
        			 <input type="hidden" name="idrouteto[]" value="<?php echo ($arr_item)?>" />
        			 <input type="hidden" name="idroutefrom[]" value="<?php echo ($route_arr[$i])?>"  />
            <?php    }   
            ?>
	            
	                <td style="min-width:100px !important;" align="center">
        	            
        			    <p style="min-width:100px !important; min-height:120px !important; display:table-cell; vertical-align: middle !important;">	<?php 	echo $this->getDestinationSelectBox($arr_item);	 ?></p>
         			</td>
        			

        

                                
        				
				    
				
				
				</tr>
	        <?php  $icount=$icount+1; } ?>

        							
        							
	            </form>
	        </table>
	        
	        </panel>
	        <?php } ?> 
	        </td>
	        </tr>
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
