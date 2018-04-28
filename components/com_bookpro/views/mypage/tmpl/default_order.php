<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
AImporter::helper ( 'bus', 'html' );

$auth_user = JFactory::getUser();

?>
<script>
function getChangeOrderStatus(_this){
	document.getElementById("order_status").value = _this.value;
}
function getChangePayStatus(_this){
	document.getElementById("pay_status").value = _this.value;
}
function getSubmit(obj){
	document.getElementById("order_id").value = obj;
	document.getElementById('task').value = 'updateorderstatus';
	document.agentOrder.submit();
}
function getPayStatus(obj){
	document.getElementById("order_id").value = obj;
	document.getElementById('task').value = 'updatepaystatus';
	document.agentOrder.submit();
}
function getDeleteOrder(obj){
	document.getElementById("order_id").value = obj;
	document.getElementById('task').value = 'deleteorder';
	document.agentOrder.submit();
}
</script>
<fieldset>

	<legend>
		<?php echo JText::_('COM_BOOKPRO_ORDERS')?>
	</legend>

	<form name="agentOrder"
		action="index.php?option=com_bookpro&view=mypage" method="POST">
		<div class="well well-small">
			<div class="row-fluid">
				<div class="row-fluid form-inline">
							<?php echo JHtmlSelect::booleanlist('filter_date_type','class="btn-group"',$this->state->get('filter.date_type'),'Дата бронирования','ДАТА отправления')?>
							<?php echo $this->ranges?>
							<?php echo JHtml::calendar($this->state->get('filter.from_date'), 'filter_from_date','filter_from_date',DateHelper::getConvertDateFormat('M'),'placeholder="С" style="width: 100px;"')?>
							<?php echo JHtml::calendar($this->state->get('filter.to_date'), 'filter_to_date','filter_to_date',DateHelper::getConvertDateFormat('M'),'placeholder="По" style="width: 100px;"')?>
												
							<span>
								<?php echo $this->orderstatus?>
							</span> <span>
								<?php echo $this->paystatus?>
							</span>
					<button onclick="this.agentOrder.submit();" class="btn btn-success">
								<?php echo JText::_('COM_BOOKPRO_SEARCH'); ?>
							</button>

				</div>
			</div>





		</div>
		<table class="table table-stripped">
			<thead>
				<tr>
					<th><?php echo JText::_('COM_BOOKPRO_ORDER_NUMBER'); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_BUSTRIP"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_DEPART_DATE"); ?></th>

					<th><?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL'); ?></th>

					<th><?php echo JText::_('COM_BOOKPRO_ORDER_ORDER_STATUS'); ?></th>
					<th><?php echo JText::_('Статус оплаты'); ?></th>
					<th><?php echo JText::_('COM_BOOKPRO_ORDER_ORDER_TIME'); ?></th>

					<?php

					if($auth_user->id == 62)
					{

					?>

					<th>Отмена заказа</th>

					<?php

					}

					?>

				</tr>
			</thead>
			<tbody>
				<?php
				if (count ( $this->orders ) > 0) {

					foreach ( $this->orders as $order ) {

						$orderlink = BookProHelper::getOrderLink ( $order->order_number, $order->email );
						
						?>
				<tr>
					<td>
					
					<?php
						
						echo JHtml::link ( $orderlink, $order->order_number, 'class="cancelbt"' );
						?>
					</td>
					<td>
						<?php
							echo BusHelper::getRouteFromParams ( (json_decode ( $order->params, true )) );
						?>
					</td>
					<td><?php echo JFactory::getDate($order->depart)->format('d-m-Y') ?></td>

					<td align="right"><?php echo CurrencyHelper::formatprice($order->total)?>
					<br />
					<?php echo $order->pay_method; ?>
					</td>

					<td><?php
						echo JText::_ ( 'COM_BOOKPRO_ORDER_STATUS_' . $order->order_status );
						?>
					
					</td>
					<td>
					<?php
						echo JText::_ ( 'COM_BOOKPRO_PAYMENT_STATUS_' . $order->pay_status );
						?>
						
					</td>
					<td><?php 
    							//$timezone = new DateTimeZone( JFactory::getUser()->getParam('timezone') );
    							$date000 = JFactory::getDate($order->created);
    							$date000->add(new DateInterval('PT3H'));
    							//$date->setTimezone($timezone);
    							echo JText::sprintf($date000->format('d.m.Y H:i')); 
							?>
					</td>
					<td>

						<?php

						if( ($order->order_status == "CONFIRMED") && ($auth_user->id == 62) )
						{

						?>

							<button onclick="this.agentOrder.submit();" class="btn btn-success" name="cancel" value="<?php echo $order->id; ?>">
								Отменить
							</button>

						<?php

						}

						?>

					</td>
				</tr>
				<?php
					
}
				} else {
					?>
				<tr>
					<td colspan="7"><?php echo JText::_('COM_BOOKPRO_ORDER_UNAVAILABLE')?>
					</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>

	</form>

</fieldset>
