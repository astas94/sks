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
AImporter::helper('bus');
$passengers = BusHelper::getPassengerForm($displayData['adult'],$displayData['child'],$displayData['senior']);
?>
<h2 class="block_head">
	<span><?php echo JText::_('COM_BOOKPRO_PASSENGER_INFO')?> </span>

</h2>
<div class="form-horizontal">
	
	<table >
				 
				<?php 
					$i = 0;
					foreach ($passengers as $passenger){
    
      ?>
				<tr><td  colspan="3"><strong><?php echo JText::_('COM_BOOKPRO_PASSENGER')?> <?php echo ': '.($i+1) ?></strong></tr>
				<tr class="passenger_title" style="border-top: 1px solid #ccc;">
					 <?php if ($config->get('ps_gender')){?>
					<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER')?><br/>
					<?php echo JHtml::_('select.genericlist',BookProHelper::getGender(), $passenger->fieldname.'[gender]','class="inputbox input-small"','value','text',1) ?>
					</td>				  
				  <?php }?>
				  
				  <td><?php echo JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME')?><br/><input type="text" name="<?php echo $passenger->fieldname.'[firstname]' ?>" required
						class="input-small" /></td>
					
				  <?php if ($config->get('ps_lastname')){?>
				  <td><?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME')?><br/><input type="text" name="<?php echo $passenger->fieldname.'[lastname]' ?>" required
						class="input-small" /></td>
					<?php } ?>

						
				  <?php if ($config->get('ps_email')){?>
				  <td><?php echo JText::_('COM_BOOKPRO_PASSENGER_EMAIL')?><br/><input type="text" name="<?php echo $passenger->fieldname.'[email]' ?>" required
						class="input-small" /></td>
					<?php } ?>
						
				  <?php if ($config->get('ps_notes')){?>
				  <td><?php echo JText::_('COM_BOOKPRO_PASSENGER_NOTES')?><br/><input type="text" name="<?php echo $passenger->fieldname.'[notes]' ?>" required
						class="input-small" /></td>
					<?php } ?>
					
				  <?php if ($config->get('ps_birthday')){?>	
					<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY')?><br/><input type="text" class="input-small birthday" name="<?php echo $passenger->fieldname.'[birthday]' ?>"
						id="<?php echo 'birthday'.$i ?>" />
					</td>
					<?php } ?>

				  <?php if ($config->get('ps_passport')){?>
					<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT')?><br/><input type="text" name="<?php echo $passenger->fieldname.'[passport]' ?>" required class="input-medium" /></td>
					<?php } ?>
				  <?php if ($config->get('ps_ppvalid')){?>
					<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT_EXPIRED')?><br/><?php echo JHtml::_('calendar','', $passenger->fieldname.'[passportValid]', 'pPassportValid'.$i, '%d-%m-%Y' , array('readonly'=>'true','class'=>'date input-mini'));?></td>
					<?php } ?>
				  <?php if ($config->get('ps_country')){?>
					<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_COUNTRY')?><br/><?php echo BookProHelper::getCountryList($passenger->fieldname.'[country_id]', 0,'')?>
					</td>
					<?php } ?>
					<td><?php echo JText::_('COM_BOOKPRO_PASSENGER_AGE')?><br/><?php echo BookProHelper::getGroupList($passenger->fieldname.'[group_id]',$passenger->group_id,'class="input-small"')?></td>
				
				</tr>	
				<tr>
				 
				   <?php if ($config->get('ps_Flightno')){?>
				  <td>
				  <?php echo JText::_('COM_BOOKPRO_PASSENGER_FLIGHTNO')?><br/>
				  <input type="text" name="<?php echo $passenger->fieldname.'[flightno]' ?>" required
						class="input-small" /></td>
					<?php } ?>
				
					
				
				</tr>
				
				<?php 
					$i++;
					} ?>
		
			</table>

	</div>

