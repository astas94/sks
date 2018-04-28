<?php 

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
$config=JComponentHelper::getParams('com_bookpro');
?>
<!--h3><?php echo JText::_('COM_BOOKPRO_PASSENGER') ?></h3-->


<table  class="table table-condensed" cellpadding="0" cellspacing="0" width="100%">
	<thead>
		<tr style="background:#D0D0D0  ;">
			 
			<?php if ($config->get('ps_firstname')){?>
			<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME')?>
			</td>
			<?php }?>
<?php if ($config->get('ps_midlename')){?>
			<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_MIDLENAME')?>
			</td>
			<?php }?>
			 <?php if ($config->get('ps_lastname')){?>
			<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME')?>
			</td>
			<?php }?>
			  <?php if ($config->get('ps_birthday')){?>	
			<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY')?>
			</td>
			<?php }?>
			
			 <?php if ($config->get('ps_passport')){?>
			<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT')?>
			</td>
			<?php }?>
			<?php if ($config->get('ps_ppvalid')){?>
			<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT_EXPIRED')?>
			</td>
			<?php }?>

			<?php if ($config->get('ps_country')){?>
			<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_COUNTRY')?>
			</td>
			<?php }?>

<?php if ($config->get('ps_gender')){?>
			<td style="border:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER')?>
			</td>
			<?php } ?>

			<?php if ($config->get('ps_group')){?>
			<td style="border:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_GROUP')?>
			</td>
			<?php }?>
			
			<td style="border:1px solid #ddd;padding:4px 5px;"><?php echo JText::_('COM_BOOKPRO_PASSENGER_PRICE')?>
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
				?>
	<tr>
		
		<?php if ($config->get('ps_firstname')){?>
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo $pass->firstname; ?></td>
		<?php }?>
<?php if (true){?>
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo $pass->midlename; ?></td>
		<?php }?>
		 <?php if ($config->get('ps_lastname')){?>
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo $pass->lastname; ?></td>
		<?php }?>
		
		  <?php if ($config->get('ps_birthday')){?>	
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php 
		if ($pass->birthday != '0000-00-00 00:00:00') {
			echo DateHelper::toShortDate($pass->birthday);	
		}else{
			echo "N/A";
		}
		 ?></td>
		<?php }?>
 

		 <?php if ($config->get('ps_passport')){?>
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo $pass->passport; ?></td>
		<?php }?>
		<?php if ($config->get('ps_ppvalid')){?>
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo  $pass->ppvalid	; ?></td>
		<?php }?>
		<?php if ($config->get('ps_country')){?>
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo  $pass->country; ?></td>
		<?php }?>

 <?php if ($config->get('ps_gender')){?>
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php 
			echo BookProHelper::formatGender($pass->gender);			
		?></td>
		<?php } ?>

		<?php if ($config->get('ps_group')){?>
		<td style="border-top:1px solid #ddd;padding:4px 5px;"><?php echo $pass->group_title;?></td>
		<?php }?>
		
		<td style="border-top:1px solid #ddd;padding:4px 5px;">
		<?php 	echo CurrencyHelper::formatPrice($pass->price+$pass->return_price);
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
		?>
</table>
