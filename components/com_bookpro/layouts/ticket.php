<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 23 2012-07-08 02:20:56Z quannv $
 **/


defined ( '_JEXEC' ) or die ( 'Restricted access' );
AImporter::helper('currency');
$passengers=$displayData;
?>
<style>
table {
	width: 375px;
	font-size: 14px;
	font-family: times new roman;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
table .tr1 {
	font-family: arial;
    font-size: 18px;
}
</style>

<?php for ($i = 0; $i < count($passengers); $i++) {
	
	$this->ticket=$passengers[$i];
	//echo ('asdasd\n/n'.count($passengers));
	//var_dump ($this->ticket);
?>
	
	
<table border="1">
	<tbody>
		<tr>
			<th class="tr1" colspan="5"><?php echo $this->ticket->bustrip->brandname ?></th>
		</tr>
		<tr>
			<td class="tr1" align="center" colspan="5"><?php echo JText::sprintf('COM_BOOKPRO_TICKET_NO_TXT',$this->ticket->order_number)?></td>
		</tr>
		<tr>
			<td class="tr1" align="center" colspan="5"><?php echo JText::sprintf('COM_BOOKPRO_PNR_TXT',$this->ticket->pnr)?></td>
		</tr>
		<tr>
			<td align="center" colspan="5"><?php echo JText::_('COM_BOOKPRO_NON_REFUNDABLE') ?></td>
		</tr>
		<tr>
			<th colspan="5"><?php echo JText::_('COM_BOOKPRO_BOOKING_INFORMATION') ?></th>
		</tr>
		<tr>
			<td colspan="5"><?php echo JText::sprintf('COM_BOOKPRO_PASSENGER_NAME_TXT',$this->ticket->firstname); echo (' '.$this->ticket->midlename); echo (' '.$this->ticket->lastname); ?></td>
		</tr>
		<tr>
			<td colspan="5"><b>Из:</b> <?php echo $this->ticket->bustrip->from_title;
			 ?>
			 <?php 
					if (isset($this->ticket->boarding)){
										
										echo JText::sprintf('COM_BOOKPRO_BOARDING_TXT',$this->ticket->boarding->location,$this->ticket->boarding->depart);
									}
								?>
			 
			 </td>
		</tr>
		<tr>
			<td colspan="5"><b>В:</b> <?php echo $this->ticket->bustrip->to_title ?>
			
			<?php 
									if (isset($this->ticket->dropping)){
										
										echo JText::sprintf('COM_BOOKPRO_DROPPING_TXT',$this->ticket->dropping->location,$this->ticket->dropping->depart);
									}
								?>
			</td>
		</tr>
		<tr>
			<td colspan="5"><b><?php echo JText::sprintf('COM_BOOKPRO_BOOKING_TYPE_TXT',$this->ticket->type)?></b></td>
		</tr>
		<tr>
			<td colspan="5"><b><?php echo JText::sprintf('COM_BOOKPRO_PASSENGER_PRICE_TXT', CurrencyHelper::formatprice($this->ticket->price))?>
			</b></td>
		</tr>
		<tr>

			<td align="center"><?php echo JText::_('COM_BOOKPRO_SEAT') ?></td>
			<td align="center"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE') ?></td>
			<td align="center"><?php echo JText::_('COM_BOOKPRO_DATE') ?></td>
			<td align="center"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_START_TIME') ?></td>
<td align="center"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_END_TIME') ?></td>
		</tr>
		<tr>
			<td align="center"><?php echo $this->ticket->aseat ?></td>
			<td align="center"><?php echo $this->ticket->bustrip->code ?></td>
			<td align="center"><?php echo JHtml::date($this->ticket->astart,'d-m-Y') ?></td>
			<td align="center"><?php echo JHtml::date($this->ticket->bustrip->start_time,'H:i') ?></td>
<td align="center"><?php echo JHtml::date($this->ticket->bustrip->end_time,'H:i') ?></td>
			<!--td align="center"><?php echo JHtml::date($this->ticket->astart,'d-m-Y') ?></td-->
			<!--td align="center"><?php echo JHtml::date($this->ticket->astart,'H:i') ?></td-->
		</tr>
		<tr>
			<td align="center" colspan="5"> Оплачено: <?php echo JHtml::_('date',$this->ticket->created) ?>-<?php echo $this->ticket->pay_method ?></td>
		</tr>
		<tr>
			<td align="center" colspan="5"><b><?php echo JText::_('COM_BOOKPRO_TICKET_THANKYOU') ?></b></td>
		</tr>

	</tbody>
</table>

<hr/>


<?php 
}
?>