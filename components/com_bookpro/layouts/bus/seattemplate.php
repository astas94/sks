<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 81 2012-08-11 01:16:36Z quannv $
 **/

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
JHtml::_ ( 'jquery.framework' );
JHtml::_ ( 'jquery.ui' );	 	
$doc = JFactory::getDocument ();
// $doc->addScript(JURI::root().'components/com_bookpro/assets/js/i18n/jquery.ui.datepicker-'.$local.'.js');
AImporter::model('bustrip');
$model = new BookProModelBusTrip();
$a_row = $model->getObjectFullById($displayData->id);


$doc->addScript (JUri::root().'components/com_bookpro/assets/js/view-bustrips.js' );
$doc->addScript (JUri::root().'components/com_bookpro/assets/js/jquery-create-seat.js' );
$doc->addStyleSheet (JUri::root().'components/com_bookpro/assets/css/jquery-create-seat.css' );

$doc->addStyleSheet (JUri::root().'components/com_bookpro/assets/css/view-bustrips.css' );
AImporter::helper('bus');

$booked_seat_location= BusHelper::getBooked ( $displayData->depart_date, $a_row );

$array_deny_select=null;

 
 $block_layout =json_decode($a_row->block_layout);
  $upper_block_layout =json_decode($a_row->upper_block_layout);
  
 $config=JComponentHelper::getParams('com_bookpro');
 $driver_hand = $config->def('driver_hand',0);
 
//var_dump($block_layout);
 ?>

<div class="listseat">
	<div class="iconclose"></div>
	<!--  
	<div class="selectmsg hidden-phone"><span><?php echo JText::_('COM_BOOKPRO_SEAT_SELECT_TIPS') ?></span></div>
	-->
	<div class="formchooseseat">
		<div class="bus_name"><?php echo $a_row->bus_name ?></div>
		<div class="photoandyoutube">
			
		</div>
		<div class="bodybuyt"  style="width: <?php echo $block_layout->column*30+40 ?>px">
		    <div class="control">
			 <div class="lowerlabel <?php echo $driver_hand == 1 ? "lowerlabel-right":"lowerlabel-left"; ?>"></div>
			 
			</div>
			<div class="seats">
                <div class="block_layout<?php echo $a_row->id ?> <?php echo rand(5, 15); ?>" id="show-block-<?php echo $a_row->id ?>">
             
                </div>
			</div>
		</div>
		<div class="noteseats">
			<ol class="seatsDefn">
				<li class="avaiableseat seat_sleeper"><?php echo JText::_('COM_BOOKPRO_SEAT_AVAILABLE') ?></li>
				<li class="selectedseat seat_sleeper"><?php echo JText::_('COM_BOOKPRO_SEAT_SELECTED') ?></li>
				<li class="bookedseat seat_sleeper"><?php echo JText::_('COM_BOOKPRO_SEAT_BOOKED') ?></li>
			</ol>
			<div class="payout">
				<div class="yourseat_<?php echo $a_row->id?>"><span><?php echo JText::_('COM_BOOKPRO_SEAT_CHOSEN') ?></span><span class="yourseat_<?php echo $a_row->id?>"></span><div class="spanlistseat"></div></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    /*
    $("#show-block.block_layout<?php echo $a_row->block_layout_id ?>").css({
        width:($('#show-block.block_layout<?php echo $a_row->block_layout_id ?> .block_item').width()+10)*<?php echo $block_layout->column ?>,
        display:"lock"
        
        
    });
    */
    $('#show-block-<?php echo $a_row->id ?>').creteseat({
        row:<?php echo $block_layout->row ?>,
       	areturn:<?php echo $displayData->return?1:0?>,
        column:<?php echo $block_layout->column ?>,
        block_type: $.parseJSON('<?php echo json_encode($block_layout->block_type) ?>'),
        seatnumber: $.parseJSON('<?php echo json_encode($block_layout->seatnumber) ?>'),

<?php if($a_row->upper_block_layout){?>
        upper_row:<?php echo $upper_block_layout->row ?>,
        upper_column:<?php echo $upper_block_layout->column ?>,
        upper_block_type: $.parseJSON('<?php echo json_encode($upper_block_layout->block_type) ?>'),
        upper_seatnumber: $.parseJSON('<?php echo json_encode($upper_block_layout->seatnumber) ?>'),
<?php }?>
		  
        
        listselected:$.parseJSON('<?php echo json_encode($booked_seat_location) ?>'),
        hidden_input_submit:"<?php echo $displayData->hidden_input_submit_name ?>",
        show_lable:'span.yourseat_<?php echo $a_row->id?>',
        maxselect:1,
        callbacks:{
        	onclickseat:function(selected,areturn){
           	 
       		 if(areturn == 0){
	                var option = '';
	               
	                 $.each(selected,function(index,value){
	                     
	                     
	                	$('#jform_seat').val(value); 
	                	$('#block_seat').html(value); 
	                	    
	                 });
                }else{
                	var option = '';
	                 $.each(selected,function(index,value){
	                	  
		                	$('#jform_return_seat').val(value); 
		                	$('#return_block_seat').html(value); 
	                 });
                }
                 
            }
        }
    });
    // $('#show-block-<?php echo $a_row->id ?>').creteseat('option','onclickseat');
    /*
    $('#show-block-<?php echo $a_row->block_layout_id ?>').creteseat('option',{
        listselected:[1,3,8]
    });
    
    $('#show-block-<?php echo $a_row->block_layout_id ?>').creteseat('destroy');
    */
});
</script> 
