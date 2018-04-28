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
$ncount1=0;
$ncount2=0;
$ssum1=0;
$rsum1=0;
$ssum2=0;
$rsum2=0;
$tsum1=0;
$tsum2=0;
$temp_sum=0;

?>

<div style="width: 680px;margin:0;">

<table style="text-align: left;width:100%;margin:0;">
	<tr>
		<td style="border: none; width: 30%;">
		    <img src="<?php echo JUri::root().$logo; ?>" style="width: 300px;" >
			</td>
	</tr>

</table>

<hr style="margin:0;" />

<h3 align="center" style="margin: 0;"><?php 
    echo JText::_('COM_BOOKPRO_BUSFILTER2'); 
?></h3>

<table class="table table-striped" >
			<thead>
				
				
				<tr>
					<th><?php echo JText::_("COM_BOOKPRO_AGENT"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_COMPANY"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_TRANZAC"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_AGENT_SUM"); ?></th>
					<th><?php echo JText::_("COM_BOOKPRO_AGENT_REFUND"); ?></th>
					<!--<td>-->
					<?php //$tsum1=$ssum1-$rsum1; echo $tsum1;
					 ?>
					<!--</td>-->
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
				    	 	$checked = JHTML::_('grid.id', $i, $subject->id);
				    	 	$edit = 'index.php?option=com_bookpro&view=passenger&task=passenger.edit&id='.$subject->id;
							
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

				
				if( ($topost1!=0) && ($order->pay_status != "PENDING") && ( (($order->bustrips[0]->agent_id)==($topost2)) || (($topost2)==0) ) )
				{
		    
				?>

				<?php

				if($order->pay_status == "SUCCESS")
				{
					if($order->bustrips[0]->agent_id == 2)
					{
						$ssum1= $ssum1 + $subject->price;
						$ncount1++;
					}
					else if($order->bustrips[0]->agent_id == 3)
					{
						$ssum2= $ssum2 + $subject->price;
						$ncount2++;
					}
				}
				else if($order->pay_status == "REFUND")
				{
					if($order->bustrips[0]->agent_id == 2)
					{
						$rsum1= $rsum1 + $subject->price;
						$ncount1++;
					}
					else if($order->bustrips[0]->agent_id == 3)
					{
						$rsum2= $rsum2 + $subject->price;
						$ncount2++;
					}
				}
			}

			}

			if($topost1!=0)
			{
			if($topost2 == 2)
			{
			?>

				<tr id="agent1">
				<td>
				<?php echo JText::_('COM_BOOKPRO_AGENT1'); ?>
				</td>
				<td>
				<?php echo JText::_("COM_BOOKPRO_AGENT1"); ?>
				</td>
				<td>
				<?php echo $ncount1; ?>
				</td>
				<td>
				<?php echo $ssum1; ?>
				</td>
				<td>
				<?php echo $rsum1; ?>
				</td>
				<!--<td>-->
				<?php //$tsum1=$ssum1-$rsum1; echo $tsum1;
				 ?>
				<!--</td>-->
				</tr>

			<?php
			}
			else if($topost2 == 3)
			{
			?>

				<tr id="agent2">
				<td>
				<?php echo JText::_('COM_BOOKPRO_AGENT1'); ?>
				</td>
				<td>
				<?php echo JText::_("COM_BOOKPRO_AGENT2"); ?>
				</td>
				<td>
				<?php echo $ncount2; ?>
				</td>
				<td>
				<?php echo $ssum2; ?>
				</td>
				<td>
				<?php echo $rsum2; ?>
				</td>
				<!--<td>-->
				<?php //$tsum2=$ssum2-$rsum2; echo $tsum2;
				?>
				<!--</td>-->
				</tr>

			<?php
			}
			else if($topost2 == 0)
			{
			?>
				<tr id="agent1">
				<td>
				<?php echo JText::_('COM_BOOKPRO_AGENT1'); ?>
				</td>
				<td>
				<?php echo JText::_("COM_BOOKPRO_AGENT1"); ?>
				</td>
				<td>
				<?php echo $ncount1; ?>
				</td>
				<td>
				<?php echo $ssum1; ?>
				</td>
				<td>
				<?php echo $rsum1; ?>
				</td>
				<!--<td>-->
				<?php //$tsum1=$ssum1-$rsum1; echo $tsum1;
				 ?>
				<!--</td>-->
				</tr>
				<tr id="agent2">
				<td>
				<?php echo JText::_('COM_BOOKPRO_AGENT1'); ?>
				</td>
				<td>
				<?php echo JText::_("COM_BOOKPRO_AGENT2"); ?>
				</td>
				<td>
				<?php echo $ncount2; ?>
				</td>
				<td>
				<?php echo $ssum2; ?>
				</td>
				<td>
				<?php echo $rsum2; ?>
				</td>
				<!--<td>-->
				<?php //$tsum2=$ssum2-$rsum2; echo $tsum2;
				?>
				<!--</td>-->
				</tr>
			<?php
			}
			}

			
		}
		?>
			</tbody>
		</table>

</div>
