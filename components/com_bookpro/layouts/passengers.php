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
$config = JComponentHelper::getParams('com_bookpro');
AImporter::helper('date');
?>
<h3><?php echo JText::_('COM_BOOKPRO_PASSENGER') ?></h3>
 
<table class="table table-hover" id="passenger" style="border:2px solid #989898;border-collapse:inherit !important;">
	<thead>
		<tr style="background:#D0D0D0  ;font-weight:bold;">
			 
			<?php if ($config->get('ps_firstname')){?>
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME')?>
			</td>
			<?php }?>
<?php if ($config->get('ps_midlename')){?>
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_MIDLENAME')?>
			</td>
			<?php }?>
			 <?php if ($config->get('ps_lastname')){?>
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME')?>
			</td>
			<?php }?>
			  <?php if ($config->get('ps_birthday')){?>	
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY')?>
			</td>
			<?php }?>
			
			 <?php if ($config->get('ps_passport')){?>
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT')?>
			</td>
			<?php }?>
			<?php if ($config->get('ps_ppvalid')){?>
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT_EXPIRED')?>
			</td>
			<?php }?>

			<?php if ($config->get('ps_country')){?>
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_COUNTRY')?>
			</td>
			<?php }?>

<?php if ($config->get('ps_gender')){?>
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER')?>
			</td>
			<?php } ?>

			<?php if ($config->get('ps_group')){?>
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_GROUP')?>
			</td>
			<?php }?>
			
			<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_PRICE')?>
			</td>
			<!-- 
			<th width="10%"><?php echo JText::_('COM_BOOKPRO_PASSENGER_PRINT') ?></td>
			 -->
		</tr>
	</thead>
	<?php
 
	if (count($displayData->passengers)>0){

			foreach ($displayData->passengers as $pass)
			{ 
				if( ( ($displayData->passenger_onward == 1) && ($pass->passenger_status == "CONFIRMED") ) || ( ($displayData->passenger_return == 1) && ($pass->passenger_status_return == "CONFIRMED") ) )
				{

				?>
	<tr>
		
		<?php if ($config->get('ps_firstname')){?>
		<td><?php echo $pass->firstname; ?></td>
		<?php }?>
<?php if (true){?>
		<td><?php echo $pass->midlename; ?></td>
		<?php }?>
		 <?php if ($config->get('ps_lastname')){?>
		<td><?php echo $pass->lastname; ?></td>
		<?php }?>
		
		  <?php if ($config->get('ps_birthday')){?>	
		<td><?php 
		if ($pass->birthday != '0000-00-00 00:00:00') {
			echo DateHelper::toShortDate($pass->birthday);	
		}else{
			echo "N/A";
		}
		 ?></td>
		<?php }?>
 

		 <?php if ($config->get('ps_passport')){?>
		<td><?php echo $pass->passport; ?></td>
		<?php }?>
		<?php if ($config->get('ps_ppvalid')){?>
		<td><?php echo  $pass->ppvalid	; ?></td>
		<?php }?>
		<?php if ($config->get('ps_country')){?>
		<td><?php echo  $pass->country==NULL?$pass->country_id:$pass->country; ?></td>
		<?php }?>

 <?php if ($config->get('ps_gender')){?>
		<td><?php 
			echo BookProHelper::formatGender(strtr($pass->gender,"W","F"));			
		?></td>
		<?php } ?>

		<?php if ($config->get('ps_group')){?>
		<td><?php echo $pass->group_title;?></td>
		<?php }?>
		
		<td>
		<?php

		if($displayData->passenger_onward == 1)
		{
			echo CurrencyHelper::formatPrice($pass->price);
		}
		else if($displayData->passenger_return == 1)
		{
			echo CurrencyHelper::formatPrice($pass->return_price);
		}

		?>
		</td>
		<!-- 
		<td>
			<?php 
			$href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
			$href = "window.open(this.href,'win2','".$href."'); return false;";
			$href = 'href="index.php?option=com_bookpro&view=printticket&tmpl=component&id='.$pass->id.'&print=1" onclick="'.$href.'"';
			
			?>
			<a class="btn-small btn-primary" <?php echo $href ?>>
			<i class="icon-print"></i>
			<?php echo JText::_('COM_BOOKPRO_PASSENGER_PRINT') ?></a>
		</td>
		 -->
	</tr>
	<?php
				}

			}
		}
		?>
</table>
