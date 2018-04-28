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
//BookProHelper::setSubmenu(4);
AImporter::helper('currency','date');
//JToolBarHelper::custom('saveorderinfo','save.png');
//JToolBarHelper::cancel();
AImporter::css('customer','bus');
AImporter::model('bustrips','bustrip','orderinfos','busstations');
JHtmlBehavior::modal();
AImporter::helper('date','currency');
?>
	
	<div class="admin-order" style="float: left;width: 80%; ">
	
		<div class="container-fluid">
			
			<div class="row-fluid">
				<?php echo $config->invoice_header; ?>
			</div>
			<h2>
				<?php echo JText::_('COM_BOOKPRO_ORDER_SUMARY'); ?>
			</h2>
			<div class="row-fluid ">
				<div class="span6">
					<table class="order_sum">
						<tr>
							<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_NUMBER'); ?>:
							</th>
							<td><label class="label label-info"><?php echo $this->order->order_number; ?></label></td>
						</tr>
						<tr>
							<th align="left"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_NAME'); ?>:
							</th>
							<td><?php echo $this->order->firstname. ' '.$this->order->lastname; ?></td>
						</tr>
						<tr>
							<th align="left"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_EMAIL'); ?>:
							</th>
							<td><?php echo $this->order->email	?></td>
						</tr>
						<tr>
							<th align="left"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_PHONE'); ?>:
							</th>
							<td><?php   echo $this->order->mobile;
										?></td>
						</tr>
						<tr>
							<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_NOTE'); ?>:
							</th>
							<td><?php   echo $this->order->notes;
										?></td>
						</tr>
					</table>
					
				</div>
				<div class="span6">
						<table class="order_sum">
							<tr>
								<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_ORDER_STATUS'); ?>:
								</th>
								<td>
								
								<?php 
								echo '<label class="label label-info">'.$this->order->pay_status.'</label>';
							
								if($this->order->pay_status=='SUCCESS' && $this->order->order_status=='FINISHED' ) {
									 echo '<span>'.$this->order->order_status.'</span>'; 
								}
								?>
								
								</td>
							</tr>
							
							<tr>
								<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL'); ?>:
								</th>
								<td><?php echo CurrencyHelper::formatprice($this->order->total); ?></td>
							</tr>
							
							<tr>
								<th align="left"><?php echo JText::_('COM_BOOKPRO_ORDER_ORDER_TIME'); ?>:
								</th>
								<td><?php echo  JHtml::_('date',$this->order->created,'d/m/Y H:i:s'); ?></td>
							</tr>
						</table>
					</div>
			</div>
			<?php //echo $this->loadTemplate(strtolower($this->order->type))?>
			<div class="row-fluid">
	
				<table class="adminlist table-condensed">
					<thead>
						<tr>
							<th><?php echo JText::_('COM_BOOKPRO_BUSTRIP_ROUTE')?></th>
							<th><?php echo JText::_('COM_BOOKPRO_BUSTRIP_DATE_TIME'); ?></th>
							<th><?php echo JText::_('COM_BOOKPRO_BUSTRIP_PRICE')?></th>
						</tr>
					</thead>
					<?php
					if (count($this->orderinfo)>0){
						foreach ($this->orderinfo as $subject)
						{
							$fmodel=new BookProModelBusTrip();
							$obj=$fmodel->getObjectByID($subject->obj_id);
							$depart_date=JFactory::getDate($subject->start);
							$depart=$obj->from_name;
							$arrival=$obj->to_name;
							$slists=array('bustrip_id'=>$obj->id,'order'=>'ordering');
							$bmodel = new BookProModelBusstations();
							$bmodel->init($slists);
							$stations = $bmodel->getData();
							$first=reset($stations);
							$last=end($stations);
							$can_sms=$today > JFactory::getDate($subject->start)?true:false;
						?>
					<tr>
						<td valign="top">
							<div id="journey">
								<span class="depart">
								<?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DEPART_FROM',$obj->from_name) ?>
								</span> 
								<span class="arrival"><?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_ARRIVAL_TO',$obj->to_name) ?>
								</span>
								<span><?php echo $obj->brandname; ?></span>
							</div></td>
						<td><div id="journey_sum">
										<span class="date"> <?php echo  JText::sprintf('COM_BOOKPRO_BUSTRIP_DEPART_DATE',JHtml::_('date',$depart_date)) ?>
										</span> <span class="dep"> <?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DEP',$first->depart_time,$first->title) ?>
										</span> <span class="arr"> <?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_ARR',$last->depart_time,$last->title) ?>
										</span>
										<span class="duration"><?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DURATION_TEXT',$obj->duration) ?></span>
									</div>
								</td>
						<td>
									<span class="seat"><?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_SEAT_TEXT',$subject->adult + $subject->child).JText::sprintf('COM_BOOKPRO_BUSTRIP_LOCATION',$subject->location); ?>
									</span>
									<span class="price">
										<?php echo CurrencyHelper::formatprice($subject->price); ?>
									</span>
									</td>
					</tr>
					<?php
						}
					} else {
						echo "<tr><td colspan=3>".JText::_("COM_BOOKPRO_UNAVAILABLE")."</td></tr>";
					}
					?>
				</table>
			</div>
			<div class="row-fluid">
				<?php echo $this->loadTemplate('passenger'); ?>
			</div>
			<ul class="actions">
			<li class="print-icon">
			
				<a href="javascript:window.print();return false;" class="btn btn-primary">
				<?php echo JText::_('COM_BOOKPRO_PRINT_TICKET') ?></a>
			</li>
		</ul>
		</div>
		
		
	
	
 	 </div>
	
