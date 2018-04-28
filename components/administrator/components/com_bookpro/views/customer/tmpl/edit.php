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

AImporter::helper('date');
?>

<form action="<?php echo JRoute::_ ( 'index.php?option=com_bookpro&layout=edit&id=' . ( int ) $this->item->id );?>" method="post" name="adminForm" id="adminForm" class="form-validate">	
<?php echo JHtml::_('bootstrap.startTabSet', 'myTab',array('active'=>'tab1'));?> 
<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'tab1', JText::_('Общее')); ?> 	
    <div class="form-horizontal">
    	<?php if ($this->item->id) { ?>
    	<?php if ($this->item->user) { ?>
        <div class="control-group">
			<label class="control-label" for="id"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_USER'); ?></label>
			<div class="controls">
				<a href="index.php?option=com_users&task=user.edit&id=<?php echo $this->item->user; ?>" title=""><?php echo $this->item->firstname; ?></a>
			</div>
		</div>			
       	<?php } else { ?>
		
		<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('user'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('user'); ?></div>
		</div>
        <?php } ?>
       	<?php } else { ?>
        
        <div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('user'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('user'); ?></div>
			</div>
        <?php } ?>
		
		<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('firstname'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('firstname'); ?></div>
			</div>	

  <div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('midlename'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('midlename'); ?></div>
			</div>
        
        <div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('lastname'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('lastname'); ?></div>
			</div>
        
        <div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('birthday'); ?></div>
					<div class="controls"><?php 
					
					$this->form->setFieldAttribute('birthday', 'format',DateHelper::getConvertDateFormat('M'), $group = null);
					echo $this->form->getInput('birthday'); ?></div>
			</div>
			
		<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('email'); ?></div>
			</div>
		
		<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('gender'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('gender'); ?></div>
			</div>
		
		<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
	</div>
    	<?php echo JHtml::_('bootstrap.endTab');?> 	
      		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'tab3', JText::_('Контакты')); ?>   
    			<div class="form-horizontal">
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('phone'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('phone'); ?></div>
			</div>
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('address'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('address'); ?></div>
			</div>
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('city'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('city'); ?></div>
			</div>
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('telephone'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('telephone'); ?></div>
			</div>
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('mobile'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('mobile'); ?></div>
			</div>
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('fax'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('fax'); ?></div>
			</div>
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('states'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('states'); ?></div>
			</div>
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('zip'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('zip'); ?></div>
			</div>
			
			<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('country_id'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('country_id'); ?></div>
			</div>
	</div>
    	<?php echo JHtml::_('bootstrap.endTab');?>     	
    	<?php echo JHtml::_('bootstrap.endTabSet');?>   	
		<input type="hidden" name="task" value="save" /> 
	<?php echo JHTML::_('form.token'); ?>
</form>
