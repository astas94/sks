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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Baggage' ).': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply('baggage.apply');
JToolBarHelper::save('baggage.save');
if (!$edit) {
	JToolBarHelper::cancel('baggage.cancel');
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'baggage.cancel', 'Close' );
}
?>

<script language="javascript" type="text/javascript">


Joomla.submitbutton = function(task)
{
	if (task == 'baggage.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
}

</script>


	 	<form method="post" action="<?php echo JRoute::_('index.php?option=com_bookpro&layout=edit&id='.(int) $this->item->id);  ?>" id="adminForm" name="adminForm">
		<div class="form-horizontal">
				
				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('id'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('id');  ?>
					</div>
				</div>	
					<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('qty'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('qty');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('weight'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('weight');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('agent_id'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('agent_id');  ?>
					</div>
				</div>		

			

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('price'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('price');  ?>
					</div>
				</div>		
					
					
		
				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('state'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('state');  ?>
					</div>
				</div>		
        

        </div>                   
		<input type="hidden" name="option" value="com_bookpro" />
	    <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="baggage" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>