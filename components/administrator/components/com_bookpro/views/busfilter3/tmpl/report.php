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

function cmp($a, $b)
{
    return strcmp($a->name, $b->name);
};

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

echo '<script type="text/javascript">window.onload = function() { window.print(); }</script>';

?>

<?php

$ssum=0;
$rsum=0;
$isum=0;
$ncount = $itemsCount;
$ncount_s = 0;
$ncount_r = 0;
$nnumber=1;

?>

<div style="width: 680px;margin:0;">

<table style="text-align: left;width:100%;margin:0;">
	<tr>
		<td style="border: none; width: 30%;">
		    <img src="<?php echo JUri::root().$logo; ?>" style="width: 300px;" >
			<!--<h3 align="center">ООО "СКСавто"</h3>-->
			</td>
        <td style="border: none; width: 20%;"></td>
	</tr>
</table>

<hr style="margin:0;" />

<h3 align="center" style="margin: 0;"><?php 
    echo JText::_('COM_BOOKPRO_BUSFILTER3'); 
?></h3>

		<table class="table table-striped" >
			<thead>
				
				
				<tr>
					<th width="3%">#</th>
					<th><?php echo JText::_("COM_BOOKPRO_AGENT"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_COMPANY"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_BUSTRIP"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_TICKER_NUMBER"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_TICKER_SERIAL_NUMBER"); ?></th>
					<th><?php echo JText::_('COM_BOOKPRO_DEPART_DATE')?>
					</th>
					<th><?php echo JText::_('COM_BOOKPRO_ORDER_CREATED')?>
					</th>
					<th><?php echo JText::_('COM_BOOKPRO_ORDER_TYPE')?>
					</th>
					<th>
						<?php echo JText::_('COM_BOOKPRO_BOARDING')?>
					</th>
					<th>
						<?php echo JText::_('COM_BOOKPRO_DROPPING')?>
					</th>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME'); ?>
					</th>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME'); ?>
					</th>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_MIDLENAME'); ?>
					</th>
					<th>
				        <?php echo JText::_('COM_BOOKPRO_PASSENGER_GROUP'); ?>
					</th>
					<!-- 
					<th><?php echo JText::_('COM_BOOKPRO_PASSENGER_PRICE')?>
					</th>
					 -->
					<th>
						<?php echo JText::_('COM_BOOKPRO_SUBTOTAL')?>
					</th>
					
					
				</tr>
			</thead>
		
			<tbody>
				<?php 
				//var_dump ($this->items);
				//echo("----------------");
				//return (0);
				
				if (! is_array($this->items)) { ?>
					<tr><td colspan="10" class="emptyListInfo"><?php echo JText::_('No items found.'); ?></td></tr>
				<?php 
				
					} else {
						 for ($i = 0; $i < $itemsCount; $i++) { 
				    	 	$subject = &$this->items[$i]; 
					    
							//	var_dump($subject->order_id);
							//	return 0;
							
							$orderModel = new BookProModelOrder ();
        				    $order = $orderModel->getComplexItem ( $subject->order_id);
        					//var_dump($order);
        					for($jj = 0; $jj < count($order->bustrips); $jj++) {
        					    if ($order->bustrips[$jj]->code==$subject->tripcode){
        					        $bustripfrom=$order->bustrips[$jj]->from_name;
        					        $bustripto=$order->bustrips[$jj]->to_name;
        					    }
        					}
							//var_dump($order);

					?>

		
				<?php

$topost1 = JFactory::getApplication ()->getUserStateFromRequest ( 'topost_1' );
$topost2 = JFactory::getApplication ()->getUserStateFromRequest ( 'topost_2' );
$topost3 = JFactory::getApplication ()->getUserStateFromRequest ( 'topost_3' );
				
				if( ($topost1!=0) && ($order->pay_status != "PENDING") && ( (($order->bustrips[0]->agent_id)==($topost2)) || ($topost2==0) ) && ( ($topost3==0) || (($topost3==1) && ($order->pay_status == "SUCCESS")) || (($topost3==2) && ($order->pay_status == "REFUND")) ) )
				{
		    
				?>

					<tr>
				    		<td  style="text-align: left; white-space: nowrap;">
						<?php echo $nnumber; $nnumber++; ?>
						</td>
						<td>
						<?php echo JText::_('COM_BOOKPRO_AGENT1'); ?>
						</td>
				    		<td>
				    		<?php echo $order->bustrips[0]->company; ?>
				    		</td>
				    		<td>
				    		<?php echo $subject->tripcode; ?>
				    		</td>
				    		<td>
				    		<?php echo $order->order_number; ?>
				    		</td>
				    		<td>
				    		<?php echo "AAA";?>
						</td>
				    		<td>
				    		<?php echo DateHelper::toShortDate($subject->start_date); ?>
				    		</td>
						<td>
				    		<?php echo $order->created; ?>
				    		</td>
				    		<td>
				    		<?php if($order->pay_status == "SUCCESS") {echo JText::_('COM_BOOKPRO_REPORT_TOUR'); } else if($order->pay_status == "REFUND") {echo JText::_('COM_BOOKPRO_PAYMENT_STATUS_REFUND'); } ?>
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
						<td>
					    	<?php  echo $subject->lastname;?>
				    		</td>
				    		<td>
				    		<?php echo $subject->firstname; ?>
				    		</a>
						</td>
						<td>
					    	<?php  echo $subject->midlename;?>
				    		</td>
				    		<td>
				    			<?php echo $subject->group_title;?>
				    		</td>
				    		<td>
				    			<?php echo $subject->price;?>
				    		</td>
				    	</tr>

				<?php

				if($order->pay_status == "SUCCESS") {$ssum= $ssum + $subject->price; $ncount_s++;}
				else if($order->pay_status == "REFUND") {$rsum= $rsum + $subject->price; $ncount_r++;}

				}

			else {$ncount--;}
			}
			
		}
		?>
			</tbody>
		</table>
<?php
echo JText::sprintf('COM_BOOKPRO_NTRANZAC',$ncount);echo JText::sprintf('COM_BOOKPRO_ITOG_S',$ncount_s);echo JText::sprintf('COM_BOOKPRO_ITOG_R',$ncount_r).'<br><br>';
echo JText::sprintf('COM_BOOKPRO_AGENT_NSUM',$ssum).'<br>';
echo JText::sprintf('COM_BOOKPRO_AGENT_NREFUND',$rsum).'<br>';
$isum= $ssum - $rsum;
//echo JText::sprintf('COM_BOOKPRO_TOTAL_TXT',$isum).'<br>';
?>
</div>