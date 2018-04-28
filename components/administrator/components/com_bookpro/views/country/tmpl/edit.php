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
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

?>
<form action="<?php echo JRoute::_('index.php?option=com_bookpro&id=' . (int) $this->item->id); ?>" method="post" id="adminForm" name="adminForm" class="form-validate">
	
	
	<div class="row-fluid">
		<div class="span10 form-horizontal">
		<fieldset>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('country_name'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('country_name'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('country_code'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('country_code'); ?></div>
				</div>
				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('flag'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('flag'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('image_map'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('image_map'); ?></div>
				</div>
				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('intro'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('intro'); ?></div>
				</div>
				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('desc'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('desc'); ?></div>
				</div>

				
			</fieldset>	
			</div>
			<?php echo JLayoutHelper::render('joomla.edit.details', $this); ?>
		
	</div>
	
	
	
	<div>
		<input type="hidden" name="task" value="" /> 
		<input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>