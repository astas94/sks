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

<?php

//echo "<pre>";print_r($_POST);echo "</pre>";

if($_POST["cancel"])
{
	$cancel_value = $_POST["cancel"];
	
	$db = JFactory::getDbo();
	$query = $db->getQuery ( true );
	$query->select('id,order_number,total');
	$query->from('#__bookpro_orders');
	$query->where('id='.$cancel_value);
	$db->setQuery($query);
	$order=$db->loadAssoc();
	
//echo "<pre>";print_r($order);echo "</pre>";
	
	$db = JFactory::getDbo();
	$query2 = $db->getQuery ( true );
	$query2->select('id,firstname,midlename,lastname,order_id,seat,return_seat,route_id,return_route_id,price,return_price,start,return_start,passenger_status,passenger_status_return,route_cancelled,return_route_cancelled');
	$query2->from('#__bookpro_passenger');
	$query2->where('order_id='.$cancel_value);
	$db->setQuery($query2);
	$passengers=$db->loadAssocList();
	
//echo "<pre>";print_r($passengers);echo "</pre>";
	
	?>
	
	<form name="cancelOrder" action="index.php?option=com_bookpro&view=mypage" method="POST">

		<?php

		$dat_today = date("Y-m-d H:i:s");	
		$expired_data1= $passengers[0]["start"];
		$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -30 minutes" ));

		if($dat_today <= $expired_data2)
		{

		?>
	
			<button onclick="this.cancelOrder.submit();" name="full_cancel" value="<?php echo $cancel_value; ?>" class="btn btn-success">
				полный возврат
			</button>

		<?php

		}

		?>
	
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>ФИО</th>
					<th>Место туда</th>
					<th>Цена туда</th>
					<th>Отменить туда</th>
					<th>Место обратно</th>
					<th>Цена обратно</th>
					<th>Отменить обратно</th>
					<th>Отменить в обе стороны</th>
				</tr>
			</thead>
			<tbody>
	
				<?php
	
				foreach ($passengers as $passenger)
				{

					if( ($passenger["passenger_status"] != "CONFIRMED") && ($passenger["passenger_status_return"] != "CONFIRMED") ) continue;

					$part_cancel_onward_value = $passenger["id"];
					$part_cancel_return_value = $passenger["id"];
					$part_cancel_all_value = $passenger["id"];
	
					?>
		
					<tr>
						<td>
							<?php echo $passenger["firstname"]; ?><br><?php echo $passenger["midlename"]; ?><br><?php echo $passenger["lastname"]; ?>
						</td>
						<td>
							<?php echo $passenger["seat"]; ?>
						</td>
						<td>
							<?php echo $passenger["price"]; ?>
						</td>
						<td>

							<?php

							$dat_today = date("Y-m-d H:i:s");	
							$expired_data1= $passenger["start"];
							$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -30 minutes" ));

							if( ($passenger["passenger_status"] == "CONFIRMED") && ($dat_today <= $expired_data2) )
							{

							?>

								<button onclick="this.cancelOrder.submit();" name="part_cancel_onward" value="<?php echo $cancel_value.'_'.$part_cancel_onward_value; ?>" class="btn btn-success">
									возврат
								</button>

							<?php

							}

							?>

						</td>
						<td>
							<?php echo $passenger["return_seat"]; ?>
						</td>
						<td>
							<?php echo $passenger["return_price"]; ?>
						</td>
						<td>

							<?php

							$dat_today = date("Y-m-d H:i:s");	
							$expired_data1= $passenger["return_start"];
							$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -30 minutes" ));

							if( ($passenger["passenger_status_return"] == "CONFIRMED") && ($dat_today <= $expired_data2) )
							{

							?>

								<button onclick="this.cancelOrder.submit();" name="part_cancel_return" value="<?php echo $cancel_value.'_'.$part_cancel_return_value; ?>" class="btn btn-success">
									возврат
								</button>

							<?php

							}

							?>

						</td>
						<td>

							<?php

							$dat_today = date("Y-m-d H:i:s");	
							$expired_data1= $passenger["start"];
							$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -30 minutes" ));

							if( ($passenger["passenger_status"] == "CONFIRMED") && ($passenger["passenger_status_return"] == "CONFIRMED") && ($dat_today <= $expired_data2) )
							{

							?>


							<button onclick="this.cancelOrder.submit();" name="part_cancel_all" value="<?php echo $cancel_value.'_'.$part_cancel_all_value; ?>" class="btn btn-success">
								возврат
							</button>

							<?php

							}

							?>

						</td>
					</tr>
		
					<?php
	
				}
	
				?>
	
			</tbody>
		</table>
	
	</form>

	<?php

}
else if( ($_POST["full_cancel"]) || ($_POST["part_cancel_onward"]) || ($_POST["part_cancel_return"]) || ($_POST["part_cancel_all"]) )
{

//echo "<pre>";print_r($_POST);echo "</pre>";

	if($_POST["full_cancel"])
	{
		$cancel_value = $_POST["full_cancel"];

		$amount = 0;
		$subtraction_amount = 0;

		$db = JFactory::getDbo();
		$query = $db->getQuery ( true );
		$query->select('id,order_number,order_status,total,tx_id,tx_operation_id,pay_method');
		$query->from('#__bookpro_orders');
		$query->where('id='.$cancel_value);
		$db->setQuery($query);
		$order=$db->loadAssoc();

//echo "<pre>";print_r($order);echo "</pre>";

		$db = JFactory::getDbo();
		$query2 = $db->getQuery ( true );
		$query2->select('id,pay_method,return_pay_method,order_id,seat,return_seat,route_id,return_route_id,price,return_price,start,return_start,passenger_status,passenger_status_return,route_cancelled,return_route_cancelled');
		$query2->from('#__bookpro_passenger');
		$query2->where('order_id='.$cancel_value);
		$db->setQuery($query2);
		$passengers=$db->loadAssocList();

//echo "<pre>";print_r($passengers);echo "</pre>";

		foreach($passengers as $passenger)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,parent_id,associated_parent_id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$passenger["route_id"]);
			$db->setQuery($query);
			$data2=$db->loadAssoc();
		
			if($data2["associated_parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["associated_parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];
			}
			else if($data2["parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,parent_id,associated_parent_id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];			
			}
			else 
			{
				$bustrip_type=$data2["bustrip_type"];
			}

			$price_passenger = $passenger["price"];

			$dat_today = date("Y-m-d H:i:s");	
			$expired_data1= $passenger["start"];
			$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -120 minutes" ));
			$expired_data3=date( "Y-m-d H:i:s", strtotime($expired_data1." +180 minutes" ));
			$expired_data4=date( "Y-m-d H:i:s", strtotime($expired_data1." -1440 minutes" ));

			if($bustrip_type == 0)
			{
				if($dat_today < $expired_data2)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data2 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 85);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data1 <= $dat_today)&&($dat_today < $expired_data3))
				{
					$amount = $amount + ( ($price_passenger / 100) * 75);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_A_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data3 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}
			else if($bustrip_type == 1)
			{
				if($dat_today < $expired_data4)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data4 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 50);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data1 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}

//echo "<pre>";print_r($amount);echo "</pre>";

//echo "<pre>";print_r($subtraction_amount);echo "</pre>";

			if($passenger["return_route_id"] == 0) continue;

			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,parent_id,associated_parent_id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$passenger["return_route_id"]);
			$db->setQuery($query);
			$data2=$db->loadAssoc();
		
			if($data2["associated_parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["associated_parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];
			}
			else if($data2["parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,parent_id,associated_parent_id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];			
			}
			else 
			{
				$bustrip_type=$data2["bustrip_type"];
			}

			$price_passenger = $passenger["return_price"];

			$dat_today = date("Y-m-d H:i:s");	
			$expired_data1= $passenger["return_start"];
			$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -120 minutes" ));
			$expired_data3=date( "Y-m-d H:i:s", strtotime($expired_data1." +180 minutes" ));
			$expired_data4=date( "Y-m-d H:i:s", strtotime($expired_data1." -1440 minutes" ));

			if($bustrip_type == 0)
			{
				if($dat_today < $expired_data2)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data2 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 85);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data1 <= $dat_today)&&($dat_today < $expired_data3))
				{
					$amount = $amount + ( ($price_passenger / 100) * 75);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_A_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data3 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}
			else if($bustrip_type == 1)
			{
				if($dat_today < $expired_data4)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data4 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 50);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data1 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}

//echo "<pre>";print_r($amount);echo "</pre>";

//echo "<pre>";print_r($subtraction_amount);echo "</pre>";

		}
	}
	else if($_POST["part_cancel_onward"])
	{
		$massiv	= explode("_",$_POST["part_cancel_onward"]);
		$cancel_value = $massiv[0];

		$amount = 0;

		$db = JFactory::getDbo();
		$query = $db->getQuery ( true );
		$query->select('id,order_number,order_status,total,tx_id,tx_operation_id,pay_method');
		$query->from('#__bookpro_orders');
		$query->where('id='.$cancel_value);
		$db->setQuery($query);
		$order=$db->loadAssoc();

//echo "<pre>";print_r($order);echo "</pre>";

		$db = JFactory::getDbo();
		$query2 = $db->getQuery ( true );
		$query2->select('id,pay_method,return_pay_method,order_id,seat,return_seat,route_id,return_route_id,price,return_price,start,return_start,passenger_status,passenger_status_return,route_cancelled,return_route_cancelled');
		$query2->from('#__bookpro_passenger');
		$query2->where('id='.$massiv[1]);
		$db->setQuery($query2);
		$passengers=$db->loadAssocList();

//echo "<pre>";print_r($passengers);echo "</pre>";

		foreach($passengers as $passenger)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,parent_id,associated_parent_id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$passenger["route_id"]);
			$db->setQuery($query);
			$data2=$db->loadAssoc();
		
			if($data2["associated_parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["associated_parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];
			}
			else if($data2["parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,parent_id,associated_parent_id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];			
			}
			else 
			{
				$bustrip_type=$data2["bustrip_type"];
			}

			$price_passenger = $passenger["price"];

			$dat_today = date("Y-m-d H:i:s");	
			$expired_data1= $passenger["start"];
			$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -120 minutes" ));
			$expired_data3=date( "Y-m-d H:i:s", strtotime($expired_data1." +180 minutes" ));
			$expired_data4=date( "Y-m-d H:i:s", strtotime($expired_data1." -1440 minutes" ));

			if($bustrip_type == 0)
			{
				if($dat_today < $expired_data2)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data2 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 85);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data1 <= $dat_today)&&($dat_today < $expired_data3))
				{
					$amount = $amount + ( ($price_passenger / 100) * 75);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_A_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data3 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}
			else if($bustrip_type == 1)
			{
				if($dat_today < $expired_data4)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data4 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 50);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data1 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}

//echo "<pre>";print_r($amount);echo "</pre>";

//echo "<pre>";print_r($subtraction_amount);echo "</pre>";

		}

	}
	else if($_POST["part_cancel_return"])
	{
		$massiv	= explode("_",$_POST["part_cancel_return"]);
		$cancel_value = $massiv[0];

		$amount = 0;

		$db = JFactory::getDbo();
		$query = $db->getQuery ( true );
		$query->select('id,order_number,order_status,total,tx_id,tx_operation_id,pay_method');
		$query->from('#__bookpro_orders');
		$query->where('id='.$cancel_value);
		$db->setQuery($query);
		$order=$db->loadAssoc();

//echo "<pre>";print_r($order);echo "</pre>";

		$db = JFactory::getDbo();
		$query2 = $db->getQuery ( true );
		$query2->select('id,pay_method,return_pay_method,order_id,seat,return_seat,route_id,return_route_id,price,return_price,start,return_start,passenger_status,passenger_status_return,route_cancelled,return_route_cancelled');
		$query2->from('#__bookpro_passenger');
		$query2->where('id='.$massiv[1]);
		$db->setQuery($query2);
		$passengers=$db->loadAssocList();

//echo "<pre>";print_r($passengers);echo "</pre>";

		foreach($passengers as $passenger)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,parent_id,associated_parent_id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$passenger["return_route_id"]);
			$db->setQuery($query);
			$data2=$db->loadAssoc();
		
			if($data2["associated_parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["associated_parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];
			}
			else if($data2["parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,parent_id,associated_parent_id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];			
			}
			else 
			{
				$bustrip_type=$data2["bustrip_type"];
			}

			$price_passenger = $passenger["return_price"];

			$dat_today = date("Y-m-d H:i:s");	
			$expired_data1= $passenger["return_start"];
			$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -120 minutes" ));
			$expired_data3=date( "Y-m-d H:i:s", strtotime($expired_data1." +180 minutes" ));
			$expired_data4=date( "Y-m-d H:i:s", strtotime($expired_data1." -1440 minutes" ));

			if($bustrip_type == 0)
			{
				if($dat_today < $expired_data2)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data2 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 85);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data1 <= $dat_today)&&($dat_today < $expired_data3))
				{
					$amount = $amount + ( ($price_passenger / 100) * 75);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_A_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data3 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}
			else if($bustrip_type == 1)
			{
				if($dat_today < $expired_data4)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data4 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 50);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data1 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}

//echo "<pre>";print_r($amount);echo "</pre>";

//echo "<pre>";print_r($subtraction_amount);echo "</pre>";
		}
	}
	else if($_POST["part_cancel_all"])
	{
		$massiv	= explode("_",$_POST["part_cancel_all"]);
		$cancel_value = $massiv[0];

		$amount = 0;

		$db = JFactory::getDbo();
		$query = $db->getQuery ( true );
		$query->select('id,order_number,order_status,total,tx_id,tx_operation_id,pay_method');
		$query->from('#__bookpro_orders');
		$query->where('id='.$cancel_value);
		$db->setQuery($query);
		$order=$db->loadAssoc();

//echo "<pre>";print_r($order);echo "</pre>";

		$db = JFactory::getDbo();
		$query2 = $db->getQuery ( true );
		$query2->select('id,pay_method,return_pay_method,order_id,seat,return_seat,route_id,return_route_id,price,return_price,start,return_start,passenger_status,passenger_status_return,route_cancelled,return_route_cancelled');
		$query2->from('#__bookpro_passenger');
		$query2->where('id='.$massiv[1]);
		$db->setQuery($query2);
		$passengers=$db->loadAssocList();

//echo "<pre>";print_r($passengers);echo "</pre>";

		foreach($passengers as $passenger)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,parent_id,associated_parent_id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$passenger["route_id"]);
			$db->setQuery($query);
			$data2=$db->loadAssoc();
		
			if($data2["associated_parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["associated_parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];
			}
			else if($data2["parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,parent_id,associated_parent_id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];			
			}
			else 
			{
				$bustrip_type=$data2["bustrip_type"];
			}

			$price_passenger = $passenger["price"];

			$dat_today = date("Y-m-d H:i:s");	
			$expired_data1= $passenger["start"];
			$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -120 minutes" ));
			$expired_data3=date( "Y-m-d H:i:s", strtotime($expired_data1." +180 minutes" ));
			$expired_data4=date( "Y-m-d H:i:s", strtotime($expired_data1." -1440 minutes" ));

			if($bustrip_type == 0)
			{
				if($dat_today < $expired_data2)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data2 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 85);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data1 <= $dat_today)&&($dat_today < $expired_data3))
				{
					$amount = $amount + ( ($price_passenger / 100) * 75);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_A_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data3 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}
			else if($bustrip_type == 1)
			{
				if($dat_today < $expired_data4)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data4 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 50);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data1 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}

//echo "<pre>";print_r($amount);echo "</pre>";

//echo "<pre>";print_r($subtraction_amount);echo "</pre>";

			$db = JFactory::getDbo();
			$query = $db->getQuery ( true );
			$query->select('id,parent_id,associated_parent_id,bustrip_type');
			$query->from('#__bookpro_bustrip');
			$query->where('id='.$passenger["return_route_id"]);
			$db->setQuery($query);
			$data2=$db->loadAssoc();
		
			if($data2["associated_parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["associated_parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];
			}
			else if($data2["parent_id"] != 0)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery ( true );
				$query->select('id,parent_id,associated_parent_id,bustrip_type');
				$query->from('#__bookpro_bustrip');
				$query->where('id='.$data2["parent_id"]);
				$db->setQuery($query);
				$data3=$db->loadAssoc();
				$bustrip_type=$data3["bustrip_type"];			
			}
			else 
			{
				$bustrip_type=$data2["bustrip_type"];
			}

			$price_passenger = $passenger["return_price"];

			$dat_today = date("Y-m-d H:i:s");	
			$expired_data1= $passenger["return_start"];
			$expired_data2=date( "Y-m-d H:i:s", strtotime($expired_data1." -120 minutes" ));
			$expired_data3=date( "Y-m-d H:i:s", strtotime($expired_data1." +180 minutes" ));
			$expired_data4=date( "Y-m-d H:i:s", strtotime($expired_data1." -1440 minutes" ));

			if($bustrip_type == 0)
			{
				if($dat_today < $expired_data2)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data2 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 85);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data1 <= $dat_today)&&($dat_today < $expired_data3))
				{
					$amount = $amount + ( ($price_passenger / 100) * 75);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_A_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data3 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}
			else if($bustrip_type == 1)
			{
				if($dat_today < $expired_data4)
				{
					$amount = $amount + ( ($price_passenger / 100) * 95);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_L_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if(($expired_data4 <= $dat_today)&&($dat_today < $expired_data1))
				{
					$amount = $amount + ( ($price_passenger / 100) * 50);
					$subtraction_amount = $subtraction_amount + $price_passenger;

					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->update('#__bookpro_passenger');
					$query->set('passenger_status_return = "CANCELLED_B_D"');
					$query->where(' id = '.$passenger["id"]);
					$db->setQuery($query);
					$querry_result =  $db->loadObjectList();
				}
				else if($expired_data1 <= $dat_today)
				{
					$amount = $amount + $price_passenger;
					$subtraction_amount = $subtraction_amount + $price_passenger;
				}
			}

//echo "<pre>";print_r($amount);echo "</pre>";

//echo "<pre>";print_r($subtraction_amount);echo "</pre>";
		}
	}

	$new_total = $order["total"] - $subtraction_amount;

//echo "<pre>";print_r($new_total);echo "</pre>";

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->update('#__bookpro_orders');
	$query->set('total = '.$new_total);
	if($new_total == 0) $query->set('pay_status = "REFUND"');
	if($new_total == 0) $query->set('order_status = "CANCELLED"');
	$query->where(' id = '.$cancel_value);
	$db->setQuery($query);
	$querry_result =  $db->loadObjectList();

//echo "<pre>";print_r($order["pay_method"]);echo "</pre>";

	if($order["pay_method"] == "PayAnyWay")
	{
		$amount = $amount*100;

		$url = "https://demo.moneta.ru/services";
		
		$postdata = array
		(
			"Envelope" => array
			(
				"Body"	=> array
				(
					"RefundRequest" => array
					(
						"amount" => $amount,
						"transactionId" => $order["tx_operation_id"],
						"paymentPassword" => "123456",
					),
				),
				"Header" => array
				(
					"Security" => array
					(
						"UsernameToken" => array
						(
							"Username" => "art@sks-auto.ru",
							"Password" => "123456789",
						),
					),
				),
			),
		);

		$postdata = json_encode($postdata);

$sfile = '/home/c/chartfbt/skstest4/public_html/logs/refund/refund_log.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent."-----------------------------------------------------------"."\n".$dat_today."\n"."-----------------------------------------------------------"."\n"."\n"."Тип оплаты: ".$order["pay_method"]."\n"."\n"."Входные данные"."\n"."\n".$postdata."\n"."\n";
file_put_contents($sfile, $scurrent);
	
		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_URL,            $url );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST,           1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $postdata );
		curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json;charset=UTF-8')); 
		
		$postresult = curl_exec($ch);
	
		curl_close($ch);

$sfile = '/home/c/chartfbt/skstest4/public_html/logs/refund/refund_log.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent."Ответные данные"."\n"."\n".$postresult."\n"."\n";
file_put_contents($sfile, $scurrent);
		
		$postresult = json_decode($postresult);

		if($postresult->Envelope->Body->fault)
		{
			JFactory::getApplication ()->enqueueMessage ( 'Невозможно произвести возврат денег. '.$postresult->Envelope->Body->fault->faultstring, 'message');
			$check_status = 0;
		}
		else
		{
			JFactory::getApplication ()->enqueueMessage ( 'Возврат средств в размере '.$amount.' рублей успешно завершен', 'message');
			$check_status = 1;
		}

	}

	else if($order["pay_method"] == "Sberbank")
	{
		$amount_sberbank = $amount*100;

		$url = "https://3dsec.sberbank.ru/payment/rest/refund.do";
		
		$postdata = array
		(
			'userName' => "sks-auto-api",
			'password' => "sks-auto",
			'orderId' => $order["tx_id"],
			'amount' => $amount_sberbank,
		);

		$postdata = http_build_query($postdata);

$sfile = '/home/c/chartfbt/skstest4/public_html/logs/refund/refund_log.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent."-----------------------------------------------------------"."\n".$dat_today."\n"."-----------------------------------------------------------"."\n"."\n"."Тип оплаты: ".$order["pay_method"]."\n"."\n"."Входные данные"."\n"."\n".$postdata."\n"."\n";
file_put_contents($sfile, $scurrent);
	
		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_URL,            $url );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST,           1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $postdata );
		//curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json;charset=UTF-8')); 
		
		$postresult = curl_exec($ch);
		
		curl_close($ch);

$sfile = '/home/c/chartfbt/skstest4/public_html/logs/refund/refund_log.txt';
$scurrent = file_get_contents($sfile);
$scurrent = $scurrent."Ответные данные"."\n"."\n".$postresult."\n"."\n";
file_put_contents($sfile, $scurrent);
		
		$postresult = json_decode($postresult, true);

		if($postresult["errorCode"]!=0)
		{
			JFactory::getApplication ()->enqueueMessage ( 'Невозможно произвести возврат денег. '.$postresult["errorMessage"], 'message');
			$check_status = 0;
		}
		else
		{
			JFactory::getApplication ()->enqueueMessage ( 'Возврат средств в размере '.$amount.' рублей успешно завершен', 'message');
			$check_status = 1;
		}
	}

}

?>