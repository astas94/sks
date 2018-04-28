<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: form.php 105 2012-08-30 13:20:09Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

JToolBarHelper::title(JText::_('Edit booking'));
JToolBarHelper::save();
JToolBarHelper::apply();
JToolBarHelper::cancel();
JHtml::_('behavior.formvalidation');

?>
<script type="text/javascript">       
 Joomla.submitbutton = function(task) {
      var form = document.adminForm;
      if (task == 'cancel') {
         form.task.value = task;
         form.submit();
         return;
      }
      if (document.formvalidator.isValid(form)) {
         form.task.value = task;
         form.submit();
       }
       else {
         alert('<?php echo JText::_('Fields highlighted in red are compulsory!'); ?>');
         return false;
       }
   }
	</script>
	
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate">
	
    		<div class="form-horizontal">
    			<div class="control-group">
					<label class="control-label" for="order_number"><?php echo JText::_('COM_BOOKPRO_ORDER_NUMBER'); ?>
					</label>
					<div class="controls">
						<input class="text_area required" type="text" name="order_number" id="order_number" size="60"  value="<?php echo $this->obj->order_number; ?>" disabled="disabled" />
					</div>
				</div>
				<!-- 
				<div class="control-group">
					<label class="control-label" for="customers"><?php echo JText::_('COM_BOOKPRO_ORDER_CUSTOMER'); ?>
					</label>
					<div class="controls">
						<?php echo $this->customers ?>
					</div>
				</div>
				 -->
				
				<div class="control-group">
					<label class="control-label" for="paystatus"><?php echo JText::_('COM_BOOKPRO_ORDER_PAYMENT_STATUS'); ?>
					</label>
					<div class="controls">
						<?php echo $this->paystatus ?>
					</div>
				</div>

    			<div class="control-group">
					<label class="control-label" for="paymethod"><?php echo JText::_('COM_BOOKPRO_ORDER_PAYMENT_METHOD'); ?>
					</label>
					<div class="controls">
						<input class="text_area required" type="text" name="pay_method" id="pay_method" size="60"  value="<?php echo $this->obj->pay_method; ?>"  />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="orderstatus"><?php echo JText::_('COM_BOOKPRO_ORDER_STATUS'); ?>
					</label>
					<div class="controls form-inline">
						<?php echo $this->orderstatus ?><label for="notify_customer">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="notify_customer"><?php echo JText::_('COM_BOOKPRO_ORDER_NOTIFY_TO_CUSTOMER'); ?>
					</label>
					<div class="form-inline">
						<?php echo JHtmlSelect::booleanlist('notify_customer') ?>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="total"><?php echo JText::_('COM_BOOKPRO_ORDER_TOTAL'); ?>
					</label>
					<div class="controls">
						<input class="text_area required" type="text" name="total" id="total" size="60" maxlength="255" value="<?php echo $this->obj->total; ?>" />
					</div>
				</div>
    			<!-- 
    			<div class="control-group">
					<label class="control-label" for="subtotal"><?php echo JText::_('COM_BOOKPRO_ORDER_SUB_TOTAL'); ?>
					</label>
					<div class="controls">
						<input class="text_area required" type="text" name="subtotal" id="subtotal" size="60" maxlength="255" value="<?php echo $this->obj->subtotal; ?>" />
					</div>
				</div>
    			
    			<div class="control-group">
					<label class="control-label" for="service_fee"><?php echo JText::_('COM_BOOKPRO_ORDER_SEVICE_FEE'); ?>
					</label>
					<div class="controls">
						<input class="text_area required" type="text" name="service_fee" id="service_fee" size="60" maxlength="255" value="<?php echo $this->obj->service_fee; ?>" />
					</div>
				</div>
				 -->
				
				<div class="control-group">
					<label class="control-label" for="discount"><?php echo JText::_('COM_BOOKPRO_ORDER_DISCOUNT'); ?>
					</label>
					<div class="controls">
						<input class="text_area required" type="text" name="discount" id="discount" size="60" maxlength="255" value="<?php echo $this->obj->discount; ?>" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="tx_id"><?php echo JText::_('COM_BOOKPRO_ORDER_TRANSACTION_ID'); ?>
					</label>
					<div class="controls">
						<input class="text_area" type="text" name="tx_id" id="tx_id" size="60" maxlength="255" value="<?php echo $this->obj->tx_id; ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="tx_operation_id"><?php echo JText::_('COM_BOOKPRO_ORDER_OPERATION_ID'); ?>
					</label>
					<div class="controls">
						<input class="text_area" type="text" name="tx_operation_id" id="tx_operation_id" size="60" maxlength="255" value="<?php echo $this->obj->tx_operation_id; ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="notes"><?php echo JText::_('COM_BOOKPRO_ORDER_NOTES'); ?>
					</label>
					<div class="controls">
						<?php
							$editor =JEditor::getInstance();
							echo $editor->display('notes', $this->obj->notes, '550', '200', '60', '20', false);
						?>
					</div>
				</div>
        
    </div>
   
   	
	<input type="hidden" name="option" value="<?php echo OPTION; ?>"/>
	<input type="hidden" name="controller" value="<?php echo CONTROLLER_ORDER; ?>"/>
	<input type="hidden" name="task" value="save"/>
	<input type="hidden" name="boxchecked" value="1"/>
	<input type="hidden" name="cid[]" value="<?php echo $this->obj->id; ?>"/>
	<!-- Use for display customers reservations -->
	<?php echo JHTML::_('form.token'); ?>
</form>