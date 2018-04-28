<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );


AImporter::helper ( 'currency', 'bookpro', 'date' );
AImporter::model ( 'order' );
$itemsCount = count ( $this->items );
$date = $this->state->get ( 'filter.depart_date' );
$route_id = $this->state->get ( 'filter.route_id' );

$params = JComponentHelper::getParams ( 'com_bookpro' );
$input = JFactory::getApplication ()->input;
$company_name = $params->get ( 'company_name' );
$logo = $params->get ( 'company_logo' );
$address = $params->get ( 'company_address' );
if($route_id){
AImporter::model ( 'bustrip' );
$model = new BookProModelBusTrip ();
$this->route = $model->getComplexItem ( $route_id );
echo '<script type="text/javascript">window.onload = function() { window.print(); }</script>';
}else 
	
{
	echo "Must select route";
	return;
}

?>
<div style="width: 680px;">
<table style="text-align: left;width:100%;">
	<tr>
		<td style="border: none; width: 30%;"><img
			src="<?php echo JUri::root().$logo; ?>" style="width: 150px;"></td>
		<td style="border: none; width: 20%;"><?php echo $company_name; ?><br />
			<?php echo $address; ?>
			</td>
		<td style="border: none; width: 50%; text-align: right;"><strong><?php echo $this->route->title ?></strong><br />
			<?php echo JText::sprintf('COM_BOOKPRO_PASSENGER_DEPART_DATE',JFactory::getDate($date)->format('d-m-Y'))?><br />
			<?php echo JText::sprintf('COM_BOOKPRO_ROUTE_DEPART_TIME_TXT',JHTML::date($this->route->start_time,"g:i a",null ))?><br />
			<?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE').':'.$this->route->code;?><br />
			<?php echo JText::_('COM_BOOKPRO_BUS').':'.$this->route->bus_name;?>
			
			</td>
	</tr>

</table>

<hr />

<h2><?php echo JText::_('COM_BOOKPRO_PASSENGERS') ?></h2>


<table class="table table-bordered" cellpadding="5" border="1">
	<thead>
		<tr>
			     <th width="1%">
				    <?php echo JText::_('#');?>
					</th>
			       <th>
				        <?php echo  JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME') ?>
					</th>

			      <th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_MIDLENAME'); ?>
					</th>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME'); ?>
					</th>
					<?php if($params->get('ps_gender')){?>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER')?>
					</th>
					<?php } ?>
					<?php if($params->get('ps_birthday')){?>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY'); ?>
					</th>
					<?php } ?>
					
					<?php if($params->get('ps_passport')){?>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT'); ?>
					</th>
					<?php } ?>
					
					<?php if($params->get('ps_flightno')){?>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_FLIGHTNO'); ?>
					</th>
					<?php } ?>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_GROUP'); ?>
					</th>
					<th><?php echo JText::_('COM_BOOKPRO_PASSENGER_SEAT') ?></th>
					<th>
						<?php echo JText::_('COM_BOOKPRO_ORDER_NUMBER')?>
					</th>
					<td>
						<?php echo JText::_('COM_BOOKPRO_BOARDING')?>
					</td>
					<td>
						<?php echo JText::_('COM_BOOKPRO_DROPPING')?>
					</td>
					<th>
						<?php echo JText::_('COM_BOOKPRO_PASSENGER_NOTES'); ?>
					</th>

		</tr>
	</thead>

	<tbody>
				<?php
				
				for($i = 0; $i < $itemsCount; $i ++) {
					$subject = &$this->items [$i];
					//JTable::addIncludePath( JPATH_ADMINISTRATOR.'/components/com_bookpro/tables' );
                	//$order = JTable::getInstance('Orders', 'Table');
                	//$order->load(array('order_number'=>(int)$subject->order_id));
					$orderModel = new BookProModelOrder ();
				    $order = $orderModel->getComplexItem ( $subject->order_id);
					//var_dump($subject);
					for($jj = 0; $jj < count($order->bustrips); $jj++) {
					    if ($order->bustrips[$jj]->code==$subject->tripcode){
					        $bustripfrom=$order->bustrips[$jj]->from_name;
					        $bustripto=$order->bustrips[$jj]->to_name;
					    }
					}
					//var_dump($bustripfrom);
					?>
				    	<tr>
			<td width="2%">
				    		<?php echo $i+1;?>
				    		</td>
			<td>
				    			<?php echo $subject->firstname; ?>
				    			
							</td>
							<td>
				    			<?php echo $subject->midlename; ?>
				    			
							</td>
			<td>
					    		<?php  echo $subject->lastname;?>
				    		</td>
				    		<?php if($params->get('ps_gender')){?>
				    		<td><?php echo BookProHelper::formatGender($subject->gender) ?></td>
							<?php }?>
							<?php if($params->get('ps_birthday')){?>
				    		<td>
					    		<?php 	echo DateHelper::formatSqlDate($subject->birthday,'d-m-Y');?>
					    		
				    		</td>
				    		<?php } ?>
				    		
				    		<?php if($params->get('ps_passport')){?>
				    		<td>
					    		<?php echo $subject->passport; ?>
					    		
				    		</td>
				    		<?php } ?>
				    		
				    		<?php if($params->get('ps_flightno')){?>
				    		<td>
					    		
					    	<?php echo $subject->flightno; ?>
				    		</td>
				    		<?php } ?>
				    		
				    		<td>
				    			<?php echo $subject->group_title;?>
				    		</td>
			<td>
						        <?php  echo $subject->aseat;?>
				    		</td>
			
							<td>
								
								<?php echo $subject->order_number; ?><br>

							</td>
							
							<td>
								<?php 
							        echo $bustripfrom;
									if (isset($subject->boarding)){
										
										echo JText::sprintf('COM_BOOKPRO_BOARDING_TXT',$subject->boarding->location,$subject->boarding->depart);
									}
								?>
							</td>
							
							<td>
								<?php 
								    echo $bustripto;
									if (isset($subject->dropping)){
										
										echo JText::sprintf('COM_BOOKPRO_DROPPING_TXT',$subject->dropping->location,$subject->dropping->depart);
									}
								?>
							</td>
							
			<td><?php echo $subject->notes; ?></td>

		</tr>
				    <?php
				}
				
				?>
			</tbody>
</table>
</div>
