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
	AImporter::helper('bus','date');
	$passengers = $displayData;
?>

<div class="lead">
	<span><?php echo JText::_('COM_BOOKPRO_PASSENGER_INFO')?> </span>
</div>

<div class="accordion" id="accordion2">
<?php 
	$i = 0;
	foreach ($passengers as $passenger){
		$filedname = 'person['.$i.']';
?>	
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i ?>">
        <?php echo $passenger->firstname.' '.$passenger->lastname.' '.BusHelper::getHtmlPassengerByGroupid($passenger->group_id); ?>
      </a>
    </div>
    <div id="collapse<?php echo $i ?>" class="accordion-body collapse <?php echo $i == 0 ? "in":"" ?>">
      <div class="accordion-inner">
      	<input type="hidden" name="<?php echo $filedname.'[id]' ?>" value="<?php echo $passenger->id; ?>"/>
      	
	 	<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER')?>
			</label>
			<div class="controls">
				<?php echo JHtml::_('select.genericlist',BookProHelper::getGender(), $filedname.'[gender]','class="inputbox input-small"','value','text',$passenger->gender) ?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME')?>
			</label>
			<div class="controls">
				<input type="text" name="<?php echo $filedname.'[firstname]' ?>" value="<?php echo $passenger->firstname; ?>" required class="input-medium" />
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME')?>
			</label>
			<div class="controls">
				<input type="text" name="<?php echo $filedname.'[lastname]'; ?>" value="<?php echo $passenger->lastname; ?>" required class="input-medium" />
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY')?>
			</label>
			<div class="controls">
				<?php echo JHtml::_('calendar',DateHelper::JfactoryGetDateAndFormat($passenger->birthday,'d-m-Y'), $filedname.'[birthday]', 'birthday'.$i, DateHelper::getConvertDateFormat('M')  , array('readonly'=>'true','class'=>'date input-mini'));?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_DOCUMENT_TYPE')?>
			</label>
			<div class="controls">
				<?php echo BookProHelper::getPassengerDocTypes($filedname.'[documenttype]',$passenger->documenttype,'required class="input-medium"') ?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT')?>
			</label>
			<div class="controls">
				<input type="text" name="<?php echo $filedname.'[passport]'; ?>" value="<?php echo $passenger->passport; ?>" required class="input-medium"/>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT_EXPIRED')?>
			</label>
			<div class="controls">
				<?php echo JHtml::_('calendar',DateHelper::JfactoryGetDateAndFormat($passenger->ppvalid,'d-m-Y'), $filedname.'[ppvalid]', 'pPassportValid'.$i, DateHelper::getConvertDateFormat('M')  , array('readonly'=>'true','class'=>'date input-mini'));?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_COUNTRY')?>
			</label>
			<div class="controls">
				<?php echo BookProHelper::getCountryList($filedname.'[country_id]', $passenger->country_id,'')?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label"><?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE') ?></label>
			<div class="controls">
				<?php echo JHtmlSelect::integerlist(0, 5, 1, $filedname.'[bag_qty]','class="input-mini"',$passenger->bag_qty); ?>
				<?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE_HELP') ?>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label"><?php echo JText::_('COM_BOOKPRO_PASSENGER_BAGGAGE_RETURN') ?></label>
			<div class="controls">
				<?php echo JHtmlSelect::integerlist(0, 5, 1, $filedname.'[return_bag_qty]','class="input-mini"',$passenger->return_bag_qty); ?>
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


