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
		<div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('number_hour'); ?></div>
             <div class="controls"><?php echo $this->form->getInput('number_hour'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('amount'); ?></div>
             <div class="controls"><?php echo $this->form->getInput('amount'); ?></div>
        </div>
	</div>
	<?php echo JLayoutHelper::render('joomla.edit.details', $this); ?>	
	</div>
	<input type="hidden" name="option" value="<?php echo OPTION; ?>"/>
	<input type="hidden" name="controller" value="<?php echo CONTROLLER_REFUND; ?>"/>
	<input type="hidden" name="task" value="save"/>
	
	
	<!-- Use for display customers reservations -->
	
	<?php echo JHTML::_('form.token'); ?>
</form>