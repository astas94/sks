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
	AImporter::helper('flight','date');
	$passengers = $displayData;
	JArrayHelper::fromObject
?>

<div class="lead">
	<span><?php echo JText::_('COM_BOOKPRO_PASSENGER_INFO')?> </span>
</div>

<div class="accordion" id="accordion2">
<?php 
	$i = 0;
	foreach ($passengers as $passenger){
?>	
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i ?>">
        <?php echo $passenger->firstname.' '.$passenger->lastname.' '.FlightHelper::getHtmlPassengerByGroupid($passenger->group_id); ?>
      </a>
    </div>
    <div id="collapse<?php echo $i ?>" class="accordion-body collapse <?php echo $i == 0 ? "in":"" ?>">
      <div class="accordion-inner">
      	<input type="hidden" name="person[id][]" value="<?php echo $passenger->id; ?>"/>
      	
	 	<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER')?>
			</label>
			<div class="controls">
				<?php echo JHtml::_('select.genericlist',BookProHelper::getGender(), 'person[gender][]','class="inputbox input-small"','value','text',$passenger->gender) ?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME')?>
			</label>
			<div class="controls">
				<input type="text" name="person[firstname][]" value="<?php echo $passenger->firstname; ?>" required class="input-medium" />
			</div>
		</div>

		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME')?>
			</label>
			<div class="controls">
				<input type="text" name="person[lastname][]" value="<?php echo $passenger->lastname; ?>" required class="input-medium" />
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY')?>
			</label>
			<div class="controls">
				<?php echo JHtml::_('calendar',DateHelper::JfactoryGetDateAndFormat($passenger->birthday,'d-m-Y'), 'person[birthday][]', 'birthday'.$i, DateHelper::getConvertDateFormat('M') , array('readonly'=>'true','class'=>'date input-mini'));?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_DOCUMENT_TYPE')?>
			</label>
			<div class="controls">
				<?php echo BookProHelper::getPassengerDocTypes('person[documenttype][]',$passenger->documenttype,'required class="input-medium"') ?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT')?>
			</label>
			<div class="controls">
				<input type="text" name="'person[passport][]" value="<?php echo $passenger->passport; ?>" required class="input-medium"/>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT_EXPIRED')?>
			</label>
			<div class="controls">
				<?php echo JHtml::_('calendar',$passenger->ppvalid, 'person[ppvalid][]', 'pPassportValid'.$i,DateHelper::getConvertDateFormat('M') , array('readonly'=>'true','class'=>'date input-mini'));?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_COUNTRY')?>
			</label>
			<div class="controls">
				<?php echo BookProHelper::getCountryList('person[country_id][]', $passenger->country_id,'')?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label"><?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE') ?></label>
			<div class="controls">
				<?php echo JHtmlSelect::integerlist(0, 5, 1, 'person[bag_qty][]','class="input-mini"',$passenger->bag_qty); ?>
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE_HELP') ?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label"><?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE_RETURN') ?></label>
			<div class="controls">
				<?php echo JHtmlSelect::integerlist(0, 5, 1, 'person[return_bag_qty][]','class="input-mini"',$passenger->return_bag_qty); ?>
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE_RETURN_HELP') ?>
			</div>
		</div>
		
      </div>
    </div>
  </div>
  <?php 
	$i++;
	} ?>
</div>


