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
AImporter::helper('bookpro','bus');
$order = $displayData;
if ($order->refund_date != '0000-00-00 00:00:00') {
	$now = new JDate(JHtml::date($order->refund_date,'d-m-Y H:i:s'));
}else{
	$now = new JDate(JHtml::date('now','d-m-Y H:i:s'));
}


$start = new JDate($order->orderinfo[0]->depart_date);

$days = $start->diff($now);
$hour = $days->days*24+$days->h;
$check = BusHelper::getCheckRefund($hour);
?>
<div class="container-fluid">
				
				
				<div class="row-fluid ">
					<div class="span6">
					<h4>
						<?php echo JText::_('COM_BOOKPRO_ORDER_SUMARY'); ?>
					</h4>
						  <table class="table table-hover" style="border:2px solid #989898;">
						  
							<tr>
								<th align="left" width="40%" style="background:#D0D0D0 ;"><?php echo JText::_('COM_BOOKPRO_TICKER_NUMBER'); ?>:
								</th>
								<td><label class="label label-info"><?php echo $order->order_number; ?></label></td>
							</tr>
							
							<tr>
									<th align="left" style="background:#D0D0D0 ;"><?php echo JText::_('COM_BOOKPRO_ORDER_PAYMENT_STATUS'); ?>:
									</th>
									<td>
										<?php 
											echo BookProHelper::displayPaymentStatus($order->pay_status);
										?>
									</td>
							</tr>
								<?php if($order->order_status== "CANCELLED"){
									?>
									<tr>
										<th align="left" style="background:#D0D0D0 ;"><?php echo JText::_('COM_BOOKPRO_ORDER_ORDER_STATUS'); ?>:
										</th>
										<td>
										<?php 
										 	echo BookProHelper::displayOrderStatus($order->order_status);
										?>
										</td>
									</tr>
								<?php 	 
								} ?>
								<tr>
									<th align="left" style="background:#D0D0D0 ;"><?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL'); ?>:
									</th>
									<td><?php echo CurrencyHelper::formatPrice($order->total); ?>
									  <?php 
									    if($order->order_status == "CANCELLED" && $check){ ?>
									    	<?php echo JText::sprintf('COM_BOOKPRO_ORDER_CANCEL_REFUND_AMOUNT',CurrencyHelper::displayPrice($order->refund_amount)) ?>
									    <?php } ?>	
									</td>
								</tr>
							
							
						</table>
						
					</div>
					<div class="span6">
					<h4>
					<?php echo JText::_('COM_BOOKPRO_BUYER'); ?>
				</h4>
						  <table class="table table-hover" style="border:2px solid #989898;">
								
								<tr>
								<th width="40%" align="left" style="background:#D0D0D0; border:none;"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_NAME'); ?>:
								</th>
								<td><?php echo $order->firstname.' '.$order->lastname; ?></td>
							</tr>
							<tr>
								<th align="left" style="background:#D0D0D0 ;"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_EMAIL'); ?>:
								</th>
								<td><?php echo $order->email	?></td>
							</tr>
							<tr>
								<th align="left" style="background:#D0D0D0 ;"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_PHONE'); ?>:
								</th>
								<td><?php   echo $order->mobile;
											?></td>
							</tr>
							<?php if($order->notes){?>
							<tr>
								<th align="left" style="background:#D0D0D0;"><?php echo JText::_('COM_BOOKPRO_ORDER_NOTE'); ?>:
								</th>
								<td><?php   echo $order->notes;
											?></td>
							</tr>
							<?php } ?>
								<tr>
									<th align="left" style="background:#D0D0D0 ;"><?php echo JText::_('COM_BOOKPRO_ORDER_ORDER_TIME'); ?>:
									</th>
									<td><?php echo  DateHelper::toNormalDate($order->created); ?></td>
								</tr>
							</table>
						</div>
				</div>
				</div>