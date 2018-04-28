<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: form.php 105 2012-08-30 13:20:09Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.formvalidation');

?>

<form action="<?php echo JRoute::_('index.php?option=com_bookpro&layout=edit&id='.(int)$this->item->id);?>" method="post" name="adminForm" id="adminForm" class="form-validate">	
				
    		<div class="form-horizontal">
	    		<div class="span6">	
	    		
	    		<div class="lead">
					<span><?php echo JText::_('COM_BOOKPRO_ORDER')?> </span>
				</div>

				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('order_number');?></div>
						<div class="controls"><?php echo $this->form->getInput('order_number');?></div>
				</div>				
				
																
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('pay_status');?></div>
						<div class="controls"><?php echo $this->form->getInput('pay_status');?></div>
				</div>				

    			<div class="control-group">
					<label class="control-label" for="paymethod"><?php echo $this->form->getLabel('pay_method');?>
					</label>
					<div class="controls">
						<?php echo $this->form->getInput('pay_method');?>
					</div>
				</div>
				
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('order_status');?></div>
						<div class="controls"><?php echo $this->form->getInput('order_status');?></div>
				</div>	
				
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('notify_customer');?></div>
						<div class="controls"><?php echo $this->form->getInput('notify_customer');?></div>
				</div>	
				
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('total');?></div>
						<div class="controls"><?php echo $this->form->getInput('total');?></div>
				</div>	
				
    			<!-- 
    			<div class="control-group">
					<label class="control-label" for="subtotal"><?php echo JText::_('COM_BOOKPRO_ORDER_SUB_TOTAL'); ?>
					</label>
					<div class="controls">
						<input class="text_area required" type="text" name="subtotal" id="subtotal" size="60" maxlength="255" value="<?php echo $this->obj->subtotal; ?>" />
					</div>
				</div>
    			
    			<div class="control-group">
					<label class="control-label" for="service_fee"><?php echo JText::_('COM_BOOKPRO_ORDER_SEVICE_FEE'); ?>
					</label>
					<div class="controls">
						<input class="text_area required" type="text" name="service_fee" id="service_fee" size="60" maxlength="255" value="<?php echo $this->obj->service_fee; ?>" />
					</div>
				</div>
				 -->
				
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('discount');?></div>
						<div class="controls"><?php echo $this->form->getInput('discount');?></div>
				</div>	
				
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('tx_id');?></div>
						<div class="controls"><?php echo $this->form->getInput('tx_id');?></div>
				</div>	

				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('tx_operation_id');?></div>
						<div class="controls"><?php echo $this->form->getInput('tx_operation_id');?></div>
				</div>	
				
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('notes');?></div>
						<div class="controls"><?php echo $this->form->getInput('notes');?></div>
				</div>		

			</div>	
       		<div class="span6">
				<div class="passenger">
				<h4 style="text-align: left;"><?php echo JText::_('COM_BOOKPRO_ROUTE_DETAIL')?></h4>
					<?php 
						$layout = new JLayoutFile('email_route', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
						echo $layout->render($this->item);
					?>
				<?php 
			
				//$layout = new JLayoutFile('passenger_form_admin', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts/bus');
				//$html = $layout->render($this->item->passengers);
				//echo $html;
				
				
				?>
		<?php /*
				$passengers	=	$this->orderComplex->passengers;
							//get flight information

							$object=FlightHelper::getFlightDetail($passengers[0]->route_id);
							$object->date = $passengers[0]->start;
							$object->pricetype = FlightHelper::getPackageOfPassengerByParamsAndFlightId($passengers[0]->params, $passengers[0]->route_id); 
							
							$flight_info[] = $object;
							if($passengers[0]->return_route_id){
								$return_object			= FlightHelper::getFlightDetail($passengers[0]->return_route_id);
								$return_object->date 	= $passengers[0]->return_start;
								$return_object->pricetype = FlightHelper::getPackageOfPassengerByParamsAndFlightId($passengers[0]->params, $passengers[0]->return_route_id); 
								$flight_info[] 			= $return_object;
							
							}
				?>
					<h4 style="text-align: left;"><?php echo JText::_('COM_BOOKPRO_FLIGHT_DETAIL')?></h4>
					<?php 
						$data->flights=	$flight_info;
						$layout = new JLayoutFile('email_flight', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
						echo $layout->render($data);
					?>
					
					<?php 
						$layout = new JLayoutFile('passenger_form_admin', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
						$html = $layout->render($this->passengers);
						echo $html;
					*/
					?>
				</div>

    		</div> 
    </div>
    
   	
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="1"/>
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id;?>"/>
	
	<!-- Use for display customers reservations -->
	<?php echo JHTML::_('form.token'); ?>

				<div id="passengers_cancel_form">

					<table>

						<tr>

							<th style="width:200px; padding: 5px 5px 5px 5px;">ФИО</td>
							<th style="width:50px; padding: 5px 5px 5px 5px;">Место</td>
							<th style="width:150px; padding: 5px 5px 5px 5px;">Туда</td>
							<th style="width:150px; padding: 5px 5px 5px 5px;">Обратно</td>

						</tr>

						<?php

						$ii=0;

						foreach($this->item->passengers as $passenger)
						{

						?>

							<tr>

								<td style="width:200px; padding: 5px 5px 5px 5px; text-align:center;"><?php echo " ".$passenger->lastname." ".$passenger->firstname." ".$passenger->midlename." "; ?></td>
								<td style="width:50px; padding: 5px 5px 5px 5px; text-align:center;"><?php echo " ".$passenger->seat." "; ?></td>
								<td style="width:150px; padding: 5px 5px 5px 5px; text-align:center;">

								<select name="passenger_status[]">
									<option value="PENDING" <?php if($passenger->passenger_status == "PENDING") echo 'selected="selected"'; ?>>В ожидании</option>
									<option value="CANCELLED" <?php if($passenger->passenger_status == "CANCELLED") echo 'selected="selected"'; ?>>Отменено</option>
									<option value="CONFIRMED" <?php if($passenger->passenger_status == "CONFIRMED") echo 'selected="selected"'; ?>>Подтверждено</option>
									<option value="CANCELLED_L_B_D" <?php if($passenger->passenger_status == "CANCELLED_L_B_D") echo 'selected="selected"'; ?>>Отменён заранее</option>
									<option value="CANCELLED_B_D" <?php if($passenger->passenger_status == "CANCELLED_B_D") echo 'selected="selected"'; ?>>Отменён перед отправлением</option>
									<option value="CANCELLED_A_D" <?php if($passenger->passenger_status == "CANCELLED_A_D") echo 'selected="selected"'; ?>>Отменён после отправления</option>
								</select>

								</td>

								<?php
								
								if($passenger->passenger_status_return != "ABSENT")
								
								{
								
								?>

									<td style="width:150px; padding: 5px 5px 5px 5px; text-align:center;">

									<select name="passenger_status_return[]">
										<option value="PENDING" <?php if($passenger->passenger_status_return == "PENDING") echo 'selected="selected"'; ?>>В ожидании</option>
										<option value="CANCELLED" <?php if($passenger->passenger_status_return == "CANCELLED") echo 'selected="selected"'; ?>>Отменено</option>
										<option value="CONFIRMED" <?php if($passenger->passenger_status_return == "CONFIRMED") echo 'selected="selected"'; ?>>Подтверждено</option>
										<option value="CANCELLED_L_B_D" <?php if($passenger->passenger_status_return == "CANCELLED_L_B_D") echo 'selected="selected"'; ?>>Отменён заранее</option>
										<option value="CANCELLED_B_D" <?php if($passenger->passenger_status_return == "CANCELLED_B_D") echo 'selected="selected"'; ?>>Отменён перед отправлением</option>
										<option value="CANCELLED_A_D" <?php if($passenger->passenger_status_return == "CANCELLED_A_D") echo 'selected="selected"'; ?>>Отменён после отправления</option>
									</select>

									</td>

								<?php
								
								}

								else
								{
								
								?>

									<td style="width:150px; padding: 5px 5px 5px 5px; text-align:center;">
	
									<select name="passenger_status_return[]" selected="selected">
										<option value="ABSENT">Нет</option>
									</select>
	
									</td>

								<?php
								
								}
								
								?>

							</tr>

							<input type="hidden" name="id_passenger[]" value="<?php echo $passenger->id; ?>">
							<input type="hidden" name="price_passenger[]" value="<?php echo $passenger->price; ?>">
							<input type="hidden" name="price_passenger_return[]" value="<?php echo $passenger->return_price; ?>">
							<input type="hidden" name="pay_method_passenger[]" value="<?php echo $passenger->pay_method; ?>">
							<input type="hidden" name="pay_method_passenger_return[]" value="<?php echo $passenger->return_pay_method; ?>">
						<?php

							$ii++;

						}

						?>

					<input type="hidden" name="order_passenger" value="<?php echo (int)$this->item->id; ?>">

					</table>

				</div>

</form>