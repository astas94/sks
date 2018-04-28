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

$block_layout =json_decode($this->a_row->block_layout);

//echo $block_layout->column*30+40;
 ?>

<div class="listseat">
	<div class="iconclose"></div>
	<div class="selectmsg hidden-phone"><span><?php echo JText::_('COM_BOOKPRO_SEAT_SELECT_TIPS') ?></span></div>
	<div class="formchooseseat">
 	<div class="bus_name"><?php echo $this->a_row->title_bus ?></div>
		<div class="bodybuyt" >
		    <div class="control">
			 <div class="lowerlabel"></div>
			 <div class="door"></div>
			</div>
			<div class="seats" >
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
	$("#fromcar").css("display","block");
    $('#show-block').creteseat({
    	row:<?php echo $block_layout->row ?>,
    	areturn:<?php echo $this->return?1:0?>,
    	column:<?php echo $block_layout->column ?>,
        block_type: JSON.parse('<?php echo json_encode($block_layout->block_type) ?>'),
        seatnumber: JSON.parse('<?php echo json_encode($block_layout->seatnumber) ?>'),
        listselected:JSON.parse('<?php echo json_encode($this->seatsarr) ?>'),
    });
  
});
</script> 
