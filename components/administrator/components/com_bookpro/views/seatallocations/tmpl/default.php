<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 81 2012-08-11 01:16:36Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');
 
JHTML::_('behavior.tooltip');
 
JHtml::_('jquery.framework');
 $document = JFactory::getDocument();
$document->addScript(JURI::root().'components/com_bookpro/assets/js/view-bustrips.js');
$document->addStyleSheet(JURI::root().'components/com_bookpro/assets/css/view-bustrips.css');

$document->addScript(JURI::root().'components/com_bookpro/assets/js/jquery-create-seat.js');
$document->addStyleSheet(JURI::root().'components/com_bookpro/assets/css/jquery-create-seat.css');
$input = JFactory::getApplication()->input;
$route_id = $input->get('route_id',0,'int');

$depart_date = $input->get('depart_date','','string');

AImporter::model('bustrip');
AImporter::helper('bus');
$tripModel = new BookProModelBusTrip();
$item = $tripModel->getComplexItem($route_id,$depart_date);
$block_layout =json_decode($item->block_layout);
$booked_seat_location= BusHelper::getBookedSeat ($depart_date, $item->code );
?>





 <div class="listseat">
	<div class="iconclose"></div>
	<div class="selectmsg hidden-phone"><span><?php echo JText::_('COM_BOOKPRO_SEAT_SELECT_TIPS') ?></span></div>
	<div class="formchooseseat">
 	<div class="bus_name"><?php echo $item->bus_name ?></div>
		<div class="bodybuyt" >
		    <div class="control">
			 <div class="lowerlabel"></div>
			 <div class="door"></div>
			</div>
			<div class="seats">
                <div class="block_layout" id="show-block">
             
                </div>
			</div>
		</div>
		<div class="noteseats">
			<ol class="seatsDefn">
				<li class="avaiableseat seat_seleeper"><?php echo JText::_('COM_BOOKPRO_SEAT_AVAILABLE') ?></li>
				<li class="selectedseat seat_seleeper"><?php echo JText::_('COM_BOOKPRO_SEAT_SELECTED') ?></li>
				<li class="bookedseat seat_seleeper"><?php echo JText::_('COM_BOOKPRO_SEAT_BOOKED') ?></li>
			</ol>
		</div>
 
	</div>
</div>
 
<?php 
// $this->a_row->booked_seat_location=Array("1","2","3","4");
// echo "<pre>";
// 	print_r($this->seatsarr);
// echo "</pre>";
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	
    $('#show-block').creteseat({
    	row:<?php echo $block_layout->row ?>,
    	areturn:0,
    	column:<?php echo $block_layout->column ?>,
        block_type: JSON.parse('<?php echo json_encode($block_layout->block_type) ?>'),
        seatnumber: JSON.parse('<?php echo json_encode($block_layout->seatnumber) ?>'),
        listselected:JSON.parse('<?php echo json_encode(explode(",",$booked_seat_location)) ?>'),
    });
  
});
</script> 
 
 
