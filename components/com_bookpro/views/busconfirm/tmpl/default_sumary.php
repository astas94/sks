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

?>
<div class="well well-small" style="background-color: white;">
	<div class="head-box"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_INFO')?> </div>
	<div class="row-fluid">
		<strong><?php echo BusHelper::getPassengerCountText($this->adult,$this->child,$this->senior);?>
		</strong>
	</div>
				
			<?php
			$testvalue = 0;
			if (count ( $this->bustrips ) > 0) {
				foreach ( $this->bustrips as $bustrip ) {
				    $testvalue++;
					?>
	                 <label> <i><?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DEPART_TXT',DateHelper::toLongDate(($testvalue<2)?$this->start:$this->end));/*var_dump($this->end);*/ ?></i>	</label>
	<table class="table">
		<tr>
			<td valign="top">
					<?php echo $bustrip->from_name;	?>
			</td>

			<td>
					<?php echo $bustrip->to_name; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo JFactory::getDate($bustrip->start_time)->format('H:i'); ?>
			</td>
			<td>
				<?php echo JFactory::getDate($bustrip->end_time)->format('H:i'); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div>
							<?php
					
					if (isset ( $bustrip->boarding )) {
						
							echo JText::sprintf ( 'COM_BOOKPRO_BUSTRIP_BOARDING_TXT', $bustrip->boarding['location'], $bustrip->boarding['depart'] );
					}
					
					?>
							
				</div>
				<div>
								<?php
					if (isset ( $bustrip->dropping )) {
					
							echo JText::sprintf ( 'COM_BOOKPRO_BUSTRIP_DROPPING_TXT', $bustrip->dropping['location'], $bustrip->dropping['depart'] );
					}
					
					?>
							</div>
				
				<?php if(!$this->config->get('non_seat')){ ?>
							<div>
								<?php echo JText::sprintf('COM_BOOKPRO_BOOKED_SEAT_TXT',$bustrip->booked_seat); ?>
							</div>
						<?php } ?>
			</td>

		</tr>
	</table>
					<?php
				}
			}
			?>
	<div class="well">
	<div class="head-box"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_INFO')?> </div>
	<?php if($this->chargeInfo['sum']['fee']){?>
	<?php echo JText::sprintf('COM_BOOKPRO_ORDER_SUBTOTAL_TXT', CurrencyHelper::displayPrice($this->chargeInfo['sum']['subtotal'])) ?><br/>
	<?php echo JText::sprintf('COM_BOOKPRO_ORDER_TAX_TXT', CurrencyHelper::displayPrice($this->chargeInfo['sum']['fee'])) ?><br/>
	<?php } ?>
	<?php echo JText::sprintf('COM_BOOKPRO_TOTAL_TXT', CurrencyHelper::displayPrice($this->chargeInfo['sum']['total'])) ?>
	
	</div>
</div>