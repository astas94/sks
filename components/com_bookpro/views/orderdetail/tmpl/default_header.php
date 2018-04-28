<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
JHTML::_('behavior.modal'); 
 //$export = JUri::root () . 'index.php?option=com_bookpro&controller=order&task=exportpdf&order_id=' . $this->order->id;
 //$print = JUri::root () . 'index.php?option=com_bookpro&controller=order&task=exportpdf&order_id=' . $this->order->id;
 $sendemail= JUri::root () . 'index.php?option=com_bookpro&controller=order&task=sendemail&order_id=' . $this->order->id;
 $order_status=OrderStatus::format($this->order->order_status);
//echo("tttttt");
 $isModal=JFactory::getApplication()->input->getInt('print');
 $receipt="#";
 if( $isModal) {
 	$print="#";
 	echo '<script type="text/javascript">window.onload = function() { window.print(); }</script>';
 	//echo("tttttt");
 } else {
     //echo("tttttt22222");
 	$print = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=800,directories=no,location=no';
 	$print = "window.open(this.href,'win2','".$print."'); return false;";
 	$print = '"index.php?option=com_bookpro&view=orderdetail&tmpl=component&print=1&order_number='.$this->order->order_number.'&email='.$this->customer->email.'" '.$print;
 	
 	$receipt = '"index.php?option=com_bookpro&view=orderdetail&layout=receipt&tmpl=component&print=1&order_number='.$this->order->order_number.'&email='.$this->customer->email.'" '.$print;
 }
 $isconfirmed=false;
if ($this->order->order_status  == 'CONFIRMED'){
 $print_ticket=JUri::root().'index.php?option=com_bookpro&controller=order&tmpl=component&task=print_ticket&order_id='.$this->order->id.$print;
 $isconfirmed=true;
 }
else {
$print_ticket="";
}
?>
<div class="well well-small">
	<div class="well well-small wellwhite">
		<div class="row-fluid">
			<h3>
				<span class="itinerary-number"> <?php echo JText::sprintf('COM_BOOKPRO_VIEW_ORDER_HEADLINE_TXT',$order_status, $this->order->order_number)?></span>
				
			</h3>

		</div>
	</div>
	<?php if(!$isModal){?>
	<div class="row-fluid">
		<div class="span3" style="min-width:0px;">
			<div class="well well-small wellwhite">
				<i class="icon-user icon-fixed-width icon-2x icon-large" style="font-size:24px;"></i>
				<div class="reservation-action-menu-text">
					<span><?php echo JText::_('COM_BOOKPRO_BOOKING')?></span> <a  
						target="_blank" title="Print Reservation" href=<?php echo $print ?>><?php echo JText::_('COM_BOOKPRO_PRINT')?></a>
				</div>
			</div>
		</div>
		<!--div class="span3" style="min-width:0px;">
			<div class="well well-small wellwhite">
				<i class="icon-ok icon-fixed-width icon-2x icon-large" style="font-size:24px;"></i>
				<div class="reservation-action-menu-text">
					<span><?php echo JText::_('COM_BOOKPRO_RECEIPT')?></span> <a id="receipt-print-link" target="_blank"
						title="Print Receipt" href=<?php echo $receipt ?>><?php echo JText::_('COM_BOOKPRO_PRINT')?></a>
				</div>
			</div>
		</div-->
<?php if($isconfirmed){?>
		<div class="span3" style="min-width:0px;">
			<div class="well well-small wellwhite">
				<i class="icon-ok icon-fixed-width icon-2x icon-large" style="font-size:24px;"></i>
				<div class="reservation-action-menu-text">
					<span><?php echo JText::_('COM_BOOKPRO_TICKET')?></span> <a id="receipt-print-link" target="_blank"
						 href=<?php echo $print_ticket ?> ><?php echo JText::_('COM_BOOKPRO_PRINT_TICKET')?></a>
				</div>
			</div>
		</div>
<?php } ?>
		<div class="span3" style="min-width:0px;">
			<div class="well well-small wellwhite">
				<i class="icon-share-alt icon-fixed-width icon-2x icon-large" style="font-size:24px;"></i>
				<div class="reservation-action-menu-text">
					<span><?php echo JText::_('COM_BOOKPRO_SIGNOUT')?></span> <a id="email-itinerary-to-me-link"
						href="<?php echo JRoute::_('index.php?option=com_bookpro&view=orderdetail&reset=1') ?>"><?php echo JText::_('COM_BOOKPRO_SIGNOUT')?></a>
				</div>
			</div>
		</div>
		<!-- 
		<div class="span3">
			<div class="well well-small wellwhite">
				<i class="icon-remove-sign icon-fixed-width icon-2x icon-large"></i>
				<div class="reservation-action-menu-text">

					<a id="cancel-reservation-link"
						href="<?php echo JRoute::_('index.php?option=com_bookpro&view=order&layout=cancel') ?>">Cancel
						your reservation</a>
				</div>
			</div>
		</div>
		 -->
	</div>
	<?php } ?>

</div>