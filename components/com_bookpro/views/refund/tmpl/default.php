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

$input = JFactory::getApplication ()->input;
$order_id = $input->get ( 'order_id', '', 'string' );
$order_id = base64_decode ( str_pad ( strtr ( $order_id, '-_', '+/' ), strlen ( $order_id ) % 4, '=', STR_PAD_RIGHT ) );

AImporter::css ( 'refund' );
AImporter::model ( 'refunds', 'order','passengers' );
AImporter::helper ( 'refund', 'currency', 'date' );
$model = new BookProModelRefunds ();
$refunds = $model->getItems ();
$orderModel = new BookProModelOrder ();
$item = $orderModel->getItem ( $order_id );

$pmodel = new BookproModelpassengers();
$state = $pmodel->getState();
$state->set('filter.order_id',$order_id);
$pass = $pmodel->getItems();

$can_amount = RefundHelper::refundPrice ( $item->orderinfo [0], $item );
$amount = RefundHelper::refundAmount( $item->orderinfo [0], $item );

AImporter::helper('orderstatus');
OrderStatus::init();
if ($item->order_status == OrderStatus::$CANCELLED->getValue()){
	echo JText::_('COM_BOOKPRO_REFUND_CANCELLED');
}else{
?>
<form action="index.php">
	<div class="row-fluid">
		<div class="refund-center">
			<div class="row-fluid">
				
					<label class="refund-label"><?php echo JText::_('COM_BOOKPRO_REFUND_CANCEL_TXT') ?></label>
					<div class="row-fluid">
						<div class="span12">
							<table class="table table-bordered">
										<?php foreach ($refunds as $refund){ ?>
										<tr>

									<td><?php echo JText::sprintf('COM_BOOKPRO_REFUND_AMOUND_TXT',$refund->amount.'%',DateHelper::convertHourToDay($refund->number_hour)); ?></td>

								</tr>
										<?php } ?>
							</table>
							<table class="table table-bordered">
								<tr>
									<td>
										<?php echo JText::sprintf('COM_BOOKPRO_REFUND_CANCEL_BOOKING_AMOUNT_TXT',CurrencyHelper::displayPrice($item->total)); ?>
										
									</td>
									<td>
											
											<?php 
											if ($amount){
												echo JText::sprintf('COM_BOOKPRO_REFUND_CANCEL_AMOUNR_TXT1',CurrencyHelper::displayPrice($item->total - $can_amount),$amount);
											}else{
												echo JText::sprintf('COM_BOOKPRO_REFUND_CANCEL_AMOUNR_TXT2',CurrencyHelper::displayPrice($item->total - $can_amount));
											}
											 ?>
												
									</td>
								</tr>
								<tr>
									<td>
										<?php echo JText::sprintf('COM_BOOKPRO_REFUND_DEPART_DATE_TXT',DateHelper::toShortDate($pass[0]->start)) ?>
										
										<div>
										<?php echo JText::sprintf('COM_BOOKPRO_REFUND_DEPART_TIME_TXT',JFactory::getDate($pass[0]->start)->format('H:i')) ?></div>	
									</td>
									<td>
										<?php echo JText::sprintf('COM_BOOKPRO_REFUND_TIME_CANCEL',DateHelper::toNormalDate('now')) ?>		
									</td>
								</tr>
							</table>
							
							
							<button class="btn btn-primary btn-large" type="submit"><?php echo JText::_('COM_BOOKPRO_CONFIRM'); ?></button>
						</div>
					</div>


			</div>
		</div>

	</div>
	<input type="hidden" name="option" value="com_bookpro" /> <input
		type="hidden" name="controller" value="order" /> <input type="hidden"
		name="task" value="cancelorder" /> <input type="hidden"
		name="order_id" value="<?php echo $order_id; ?>" />

</form>
<?php } ?>