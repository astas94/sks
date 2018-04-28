
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
	AImporter::css('jbbus');
	AImporter::helper('currency');
?>
<table width="100%" class="table">
	
	
	<?php
	$bustrips = $displayData->bustrips;
	
	
	for($i = 0; $i < (count ( $bustrips )); $i ++) :
		
		?>
	
	<tr>

		<td>
		<div>
			<?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DEPART_FROM',$bustrips[$i]->from_name) ?>
		</div>
		<div>
			<?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_ARRIVAL_TO',$bustrips[$i]->to_name) ?>
		</div>
		
		<?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_CODE_TXT',$bustrips[$i]->code)?>
				<div><?php echo $bustrips[$i]->brandname;  ?></div>
		<div>
			<?php echo JText::sprintf('COM_BOOKPRO_BOOKED_SEAT_TXT',$bustrips[$i]->booked_seat); ?>
		</div>		
		</td>

		<td valign="top"><label>	
			<div class="date-time">
				<?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DERPART_ARRIVAL_TXT',JFactory::getDate($bustrips[$i]->start_time)->format('H:i'),JFactory::getDate($bustrips[$i]->end_time)->format('H:i')); ?>
			</div>
			
			<div id="journey_sum">
				<?php 
			
				echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DURATION_TXT',$bustrips[$i]->duration); ?>
			</div>
			</td>
		<td valign="top">
						
				<?php echo 'Дата: '.substr($bustrips[$i]->depart_date,0,10) ;
				//JText::sprintf('COM_BOOKPRO_BUSTRIP_DEPART_DATE_TXT',JHtml::_('date',$bustrips[$i]->depart_date))
				?>
				<?php if (isset($bustrips[$i]->boarding)){ ?>
				<div>
				<?php 
				if (isset($bustrips[$i]->boarding->price) && $bustrips[$i]->boarding->price){
					echo JText::sprintf('COM_BOOKPRO_BUSTRIP_BOARDING_PRICE_TXT',$bustrips[$i]->boarding->location,$bustrips[$i]->boarding->depart,CurrencyHelper::displayPrice($bustrips[$i]->boarding->price));
				}else{
					if (isset($bustrips[$i]->boarding)){
						echo JText::sprintf('COM_BOOKPRO_BUSTRIP_BOARDING_TXT',$bustrips[$i]->boarding->location,$bustrips[$i]->boarding->depart);
					}
					
					
					
				}
				 ?>
				</div>	
				<div>
				<?php 
				if (isset($bustrips[$i]->dropping->price) && $bustrips[$i]->dropping->price){
					echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DROPPING_PRICE_TXT',$bustrips[$i]->dropping->location,$bustrips[$i]->dropping->depart,CurrencyHelper::displayPrice($bustrips[$i]->dropping->price));
				}else{
					if (isset($bustrips[$i]->dropping)){
						echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DROPPING_TXT',$bustrips[$i]->dropping->location,$bustrips[$i]->dropping->depart);
					}
					
					
					
				}
				 ?>
				</div>			
				<?php } ?>
			</td>

	</tr>
		<?php endfor;?>
</table>


