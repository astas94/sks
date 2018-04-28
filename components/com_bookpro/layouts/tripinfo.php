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
$order=$displayData;

?>

<h3 style="text-align: left;"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_INFO') ?></h3>
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
<td style="border-top:1px solid #ddd;padding:4px 5px;font-weight:bold;" align="left">
							<?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE') ?>
						</td>
						<td style="border-top:1px solid #ddd;padding:4px 5px;font-weight:bold;" align="left">
							<?php echo JText::_('COM_BOOKPRO_BUSTRIP_FROM') ?>
						</td>
						<td style="border-top:1px solid #ddd;padding:4px 5px;font-weight:bold;" align="left">
						
							<?php echo JText::_('COM_BOOKPRO_BUSTRIP_TO') ?>
						</td>

						
						<td style="border-top:1px solid #ddd;padding:4px 5px;font-weight:bold;" align="left">
							<?php echo JText::_('COM_BOOKPRO_DEPART_DATE') ?>
						</td>

<td style="border-top:1px solid #ddd;padding:4px 5px;font-weight:bold;" align="left">
							<?php echo JText::_('COM_BOOKPRO_BUSTRIP_START_TIME') ?>
						</td>

<td style="border-top:1px solid #ddd;padding:4px 5px;font-weight:bold;" align="left">
							<?php echo JText::_('COM_BOOKPRO_BUSTRIP_END_TIME') ?>
						</td>

						<td style="border-top:1px solid #ddd;padding:4px 5px;font-weight:bold;" aligh="left">
							<?php echo JText::_('COM_BOOKPRO_COMPANY') ?>
						</td>
					</tr>
					<?php

					$ii=0;

					foreach ($order->bustrips as $subject){ 

						if( ( ($order->passenger_onward == 1) && ($ii == 0) ) || ( ($order->passenger_return == 1) && ($ii == 1) ) )
						{

					?>
					<tr>
<td style="border-top:1px solid #ddd;padding:4px 5px;">
						
							<?php echo ($subject->code) ?>
						</td>
						<td style="border-top:1px solid #ddd;padding:4px 5px;">
							
							<?php echo $subject->from_name ?>
							<br/>
							 <?php 
									if (isset($subject->boarding)){
										
										echo JText::sprintf('COM_BOOKPRO_BOARDING_TXT',$subject->boarding->location,$subject->boarding->depart);
									}
								?>
								</td>
						
						<td style="border-top:1px solid #ddd;padding:4px 5px;">
						 	<?php echo $subject->to_name?>
						 	<br/>
						 	<?php 
									if (isset($subject->dropping)){
										
										echo JText::sprintf('COM_BOOKPRO_DROPPING_TXT',$subject->dropping->location,$subject->dropping->depart);
									}
								?>
						 	
						 	</td>
<td style="border-top:1px solid #ddd;padding:4px 5px;">
						
							<?php echo DateHelper::toLongDate(strtr($subject->depart_date,".","-")) ?>
						</td>


						<td style="border-top:1px solid #ddd;padding:4px 5px;">
						
							<?php echo substr($subject->start_time,0,5)
							//echo DateHelper::toShortTime($subject->depart_date).var_dump($subject->start_time) 
							?>
						</td>
<td style="border-top:1px solid #ddd;padding:4px 5px;">
						
							
<?php echo (substr($subject->end_time,0,-3)) ?>
						</td>



						<td style="border-top:1px solid #ddd;padding:4px 5px;">
							<?php echo $subject->company; ?>
						</td>
					</tr>
					<?php

						}

						$ii++;

					}

					?>
				</table>