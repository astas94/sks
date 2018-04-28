<?php 
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 23 2012-07-08 02:20:56Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$isroot = $user->authorise('core.admin');
if(!$user->id)
{
    //echo('Restricted access!');
}
$config=JComponentHelper::getParams('com_bookpro');
AImporter::model('bustrips','bustrip','customer');
AImporter::css('invoice');
AImporter::helper('date','currency','refund');
$order = $displayData;
$customerModel=new BookProModelCustomer();
$customer=$customerModel->getComplexItem($order->user_id);
if($user->id!=$customer->user && !$isroot)
{
    //echo('Restricted access');
}
//var_dump($order->user_id.'------'.JFactory::getUser()->id);
$isModal = JRequest::getVar( 'print' ) == 1;
$config=JComponentHelper::getParams('com_bookpro');
$discount_site = $config->def('discount_site',0);
//echo ("sdfdsfdsf");

$isModal=JFactory::getApplication()->input->getInt('print');
 $receipt="#";
 if( $isModal) {
 	$print="#";
 	echo '<script type="text/javascript">window.onload = function() { window.print(); }</script>';
 	//echo("tttttt");
 }
 $model = new BookProModelBusTrip ();
 //var_dump ($order->passengers[0]);
$this->route = $model->getComplexItem ( $order->passengers[0]->route_id );
?>

<?php foreach ($order->passengers as $pass){ ?>

<div style="width: 768px;border: 1px solid #ddd;">
			<div style="margin: 20px;">
				<div style="padding-bottom: 20px;border-bottom: 1px solid #ddd;">
					<div>
						<div style="width: 680px;margin:0;">
<table style="text-align: left;width:100%;margin:0;">
	<tr>
		<td style="border: none; width: 30%;">
		    <img src="<?php echo JUri::root().$config->get('company_logo'); ?>" style="width: 300px;" >
			<h3 align="center">ООО "СКСавто"</h3>
			</td>
        <td style="border: none; width: 20%;"></td>
        
        <?php if (count($order->bustrips)<2) { ?>
		<td style="border: none; width: 50%; text-align: left;"><strong><?php echo $this->route->title ?><br />
			<?php echo "Отправление: ".DateHelper::toShortDate($order->bustrips[0]->depart_date) ?>
			<?php echo JHTML::date($this->route->start_time,"H:i",null )?><br />
			<?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE').':'.$this->route->code;?><br />
			<?php echo JText::_('COM_BOOKPRO_BUS').':'.(substr($this->route->bus_name,0,strpos($this->route->bus_name,'178')-10));?>
			</strong>
		</td>
		<?php } else { ?>
		<td style="border: none; width: 50%; text-align: left;">
		    <strong><?php echo $this->route->title ?>
			<?php echo "Отправление туда: ".DateHelper::toShortDate($order->bustrips[0]->depart_date) ?>
			<?php echo JHTML::date($this->route->start_time,"H:i",null )?><br />
			<?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE').' туда: '.$this->route->code;?><br />
			<?php echo JText::_('COM_BOOKPRO_BUS').' туда: '.(substr($this->route->bus_name,0,strpos($this->route->bus_name,'178')-10));?>
			<hr style="margin:2px;" />
			<?php $this->route = $model->getComplexItem ( $order->passengers[0]->return_route_id );echo $this->route->title; ?>
			<?php echo "Отправление обратно: ".DateHelper::toShortDate($order->bustrips[1]->depart_date);   ?>
			<?php echo JHTML::date($this->route->start_time,"H:i",null )?><br />
			<?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE').' обратно: '.$this->route->code;?><br />
			<?php echo JText::_('COM_BOOKPRO_BUS').' обратно: '.(substr($this->route->bus_name,0,strpos($this->route->bus_name,'178')-10));?>
			<hr style="margin:2px;" />
			</strong>
		</td>
		
		<?php } ?>
	</tr>

</table>
						
							<p class="invoice-title" style="font-size:22px;font-weight: bold;text-transform: uppercase;text-align: center;"><?php echo JText::_('ЭЛЕКТРОННЫЙ БИЛЕТ НА АВТОБУС') ?></p>
						<hr />
						<div style="clear:both;"></div>
					</div>
				</div>
				<div style="margin-top: 20px;">
					<div>
						<div style="float: left;width:60%;">
							<label style="text-align: left;font-weight: bold;">
								<?php echo JText::sprintf('COM_BOOKPRO_INVOICE_BUYER',$order->customer->firstname.' '.$order->customer->midlename.' '.$order->customer->lastname) ?>
							</label>
							<label style="text-align: left;font-weight: bold;">
								<?php echo JText::sprintf('COM_BOOKPRO_INVOICE_BUYER_PHONE',$order->customer->mobile); ?>
							</label>
							<label style="text-align: left;font-weight: bold;">
								<?php echo JText::sprintf('COM_BOOKPRO_INVOICE_BUYER_EMAIL',$order->customer->email); ?>
							</label>
						</div>
						<div style="width: 39%;float:right;">
							<label style="text-align: left;font-weight: bold;"><?php echo JText::sprintf('COM_BOOKPRO_INVOICE_ORDER_NUMBER',$order->order_number); ?></label>
							<br/>
							<label style="text-align: left;font-weight: bold;">
							<?php 
    							//$timezone = new DateTimeZone( JFactory::getUser()->getParam('timezone') );
    							$date000 = JFactory::getDate($order->created);
    							$date000->add(new DateInterval('PT3H'));
    							//$date->setTimezone($timezone);
    							echo JText::sprintf('COM_BOOKPRO_INVOICE_ORDER_DATE',$date000->format('d.m.Y H:i')); 
							?></label>
						</div>
						<div style="clear: both;"></div>
					</div>
				</div>
				
				<h3 style="text-align: left;"><?php echo JText::_('COM_BOOKPRO_INVOICE_BUS_INFOMATION') ?></h3>
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<th style="border-top:1px solid #ddd;padding:4px 5px;" align="left">
							<?php echo JText::_('COM_BOOKPRO_BUSTRIP_FROM') ?>
						</th>
						<th style="border-top:1px solid #ddd;padding:4px 5px;" align="left">
						
							<?php echo JText::_('COM_BOOKPRO_BUSTRIP_TO') ?>
						</th>
						
						<th style="border-top:1px solid #ddd;padding:4px 5px;" align="left">
							<?php echo JText::_('COM_BOOKPRO_DEPART_DATE') ?>
						</th>
						<th style="border-top:1px solid #ddd;padding:4px 5px;" align="left">
							<?php echo JText::_('COM_BOOKPRO_COMPANY') ?>
						</th>
					</tr>
					<?php foreach ($order->bustrips as $subject){ ?>
					<tr>
						<td style="border-top:1px solid #ddd;padding:4px 5px;">
							
							<?php 
//if ($subject->boarding){
if (property_exists($subject,'boarding')){
echo JText::sprintf('COM_BOOKPRO_BUSTRIP_FROM_TXT2',$subject->from_name,$subject->boarding->location,JFactory::getDate($subject->boarding->depart)->format('H:i')); 
} else{
echo JText::sprintf('COM_BOOKPRO_BUSTRIP_FROM_TXT',$subject->from_name,JFactory::getDate($subject->start_time)->format('H:i'),''); 
}
?></td>
						
						<td style="border-top:1px solid #ddd;padding:4px 5px;">

<?php 
if (property_exists($subject,'dropping')){
echo JText::sprintf('COM_BOOKPRO_BUSTRIP_FROM_TXT2',$subject->to_name,$subject->dropping->location,JFactory::getDate($subject->dropping->depart)->format('H:i')); 
} else{
echo JText::sprintf('COM_BOOKPRO_BUSTRIP_FROM_TXT',$subject->to_name,JFactory::getDate($subject->end_time)->format('H:i'),''); 
}
?>



						 	<!--?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_FROM_TXT',$subject->to_name,JFactory::getDate($subject->end_time)->format('H:i'),$subject->dropping->location); ?--></td>
						<td style="border-top:1px solid #ddd;padding:4px 5px;">
						
							<?php echo DateHelper::toShortDate($subject->depart_date) ?>
						</td>
						<td style="border-top:1px solid #ddd;padding:4px 5px;">
							<?php echo $subject->company; ?>
						</td>
					</tr>
					<?php } ?>
				</table>
				<div>
					<h3 style="text-align: left;"><?php echo JText::_('COM_BOOKPRO_INVOICE_PASSENGER_INFOMATION') ?></h3>
					<table class="table table-condensed" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
							<?php echo JText::_('No')?>
							</th>
							 <?php if ($config->get('ps_gender')){?>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER')?>
							</th>
							<?php } ?>
							
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_NAME')?>
							</th>
								
							
							  <?php if ($config->get('ps_birthday')){?>	
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY')?>
							</th>
							<?php }?>
							
				 
						
							 <?php if ($config->get('ps_passport')){?>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT')?>
							</th>
							<?php }?>
							<?php if ($config->get('ps_ppvalid')){?>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT_EXPIRED')?>
							</th>
							<?php }?>
				
							<?php if ($config->get('ps_country')){?>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_COUNTRY')?>
							</th>
							<?php }?>
				
							<?php if ($config->get('ps_group')){?>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_GROUP')?>
							</th>
							<?php }?>
							<?php if ($order->return_seat){?>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_SEAT2')?>
							</th>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_RETURNSEAT')?>
							</th>
							<?php } else {?>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_SEAT')?>
							</th>
							<?php } ?>
							
							 <?php if($config->get('ps_bag')){ ?>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE')?>
							</th>
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE_RETURN')?>
							</th>
							<?php } ?>
														
							<th style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo JText::_('COM_BOOKPRO_PASSENGER_PRICE')?>
							</th>
							
						</tr>

						<tr>
								
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo '#'.$order->order_number.'-'.$pass->id ?>
								</td>
								 <?php if ($config->get('ps_gender')){?>
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo BookProHelper::formatGender($pass->gender) ?>
								</td>
								<?php } ?>
								
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo $pass->firstname.' '.$pass->midlename.' '.$pass->lastname; ?>
								</td>
								
								 <?php if ($config->get('ps_birthday')){?>	
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php 
								if ($pass->birthday != '0000-00-00 00:00:00') {
									echo DateHelper::toShortDate($pass->birthday);	
								}else{
									echo "N/A";
								}
								 ?></td>
								<?php }?>
						 
						
								 <?php if ($config->get('ps_passport')){?>
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo $pass->passport; ?></td>
								<?php }?>
								<?php if ($config->get('ps_ppvalid')){?>
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									
									<?php echo  $pass->ppvalid	; ?>
								</td>
								<?php }?>
								<?php if ($config->get('ps_country')){?>
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo  $pass->country; ?>
								</td>
								<?php }?>
								<?php if ($config->get('ps_group')){?>
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo $pass->group_title;?></td>
								<?php }?>
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo $pass->seat;?>
									
								</td>
								
								<?php if ($order->return_seat){?>
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo $pass->return_seat;?>
									
								</td>
								<?php } ?>
								 <?php if($config->get('ps_bag')){ ?>
									<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php 
									echo $pass->bag_qty ? $pass->bag_qty:JText::_('COM_BOOKPRO_BAGGAGE_FREE');
									?>
								</td>
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
									<?php echo $pass->return_bag_qty ? $pass->return_bag_qty:JText::_('COM_BOOKPRO_BAGGAGE_FREE'); ?>
								</td>
								<?php } ?>
																
								<td style="border-top:1px solid #ddd;padding:4px 5px;">
								<?php echo CurrencyHelper::formatPrice($pass->price+$pass->return_price+ $pass->price_bag + $pass->return_price_bag);	
										?>
								</td>
								
							</tr>

					</table>
				</div>
				
				<div>
					<div style="float: right;width:55%;">
						 <?php if($order->tax){?>
						<div>
							<label style="font-weight: bold;">
								<span style="float:left;width:250px;">
									<?php echo JText::_('COM_BOOKPRO_ORDER_SUBTOTAL') ?>
								</span>
								<span style="float: left;">
									<?php echo CurrencyHelper::displayPrice((int) $order->subtotal); ?>
								</span>
								<span style="clear: both;"></span>
							</label>
						</div>
						<?php } ?>
						
						<?php if($order->tax){?>
						<div>
							<label style="font-weight: bold;">
								<span style="float:left;width:250px;">
									<?php echo JText::_('COM_BOOKPRO_INVOICE_TOTAL_GST') ?>
								</span>
								<span style="float: left;">
									<?php echo CurrencyHelper::displayPrice((int) $order->tax); ?>
								</span>
								<span style="clear: both;"></span>
							</label>
						</div>
						<?php } ?>
						
						<div>
<?php /*
							<label style="font-weight: bold;">
								<span style="float:left;width:250px;">
									<?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL_ORIGINAL') ?>
								</span>
								<span style="float: left;"><?php echo CurrencyHelper::displayPrice($order->subtotal); ?></span>
								<span style="clear: both;"></span>
							</label>
*/ ?>
						    <?php if($order->discount> 0){?>
						    <label style="font-weight: bold;">
								<span style="float:left;width:250px;">
									<?php echo JText::_('COM_BOOKPRO_ORDER_DISCOUNT') ?>
								</span>
								<span style="float: left;"><?php echo CurrencyHelper::displayPrice($order->discount); ?></span>
								<span style="clear: both;"></span>
							</label>
						    <?php } ?>
						    <?php if($discount_site>0){?>
						    <label style="font-weight: bold;">
								<span style="float:left;width:250px;">
									<?php echo JText::_('Скидка за заказ через сайт')?>
								</span>
								<span style="float: left;"><?php echo ($order->discount==0)?CurrencyHelper::formatprice(($order->subtotal)*($discount_site)/100 ):'использован купон'  ?></span>
								<span style="clear: both;"></span>
							</label>
						    <?php } ?>
<?php /*
							<label style="font-weight: bold;">
								<span style="float:left;width:250px;">
									<?php echo JText::_('COM_BOOKPRO_INVOICE_TOTAL_FARES') ?>
								</span>
								<span style="float: left;"><?php echo CurrencyHelper::displayPrice($order->total); ?></span>
								<span style="clear: both;"></span>
							</label>
*/ ?>
							
						</div>
					</div>
					<div style="clear: both;"></div>
				</div>
				
				
				
				<?php if ($isModal) {
					
				 ?>
				<div>
					<?php echo $config->invoice_footer; ?>
				</div>
				<?php } ?>
				 <form action="index.php" method="post" name="adminForm" id="adminForm">
					<input type="hidden" name="controller" value="order"/>
					 <?php echo JHTML::_('form.token'); ?>
				  </form>	
			</div>
			
		</div>

<?php } ?>