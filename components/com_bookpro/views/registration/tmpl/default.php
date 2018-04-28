<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;
$config=JComponentHelper::getParams('com_bookpro');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

$user=JFactory::getUser();



?>

<div class="registration<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		</div>
	<?php endif; ?>

	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_bookpro&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
				
		
		<?php echo $this->form->renderField('username') ?>
		<?php echo $this->form->renderField('password') ?>
		<?php echo $this->form->renderField('email') ?>
		<?php echo $this->form->renderField('firstname') ?>

<?php 
		if($config->get('rs_midlename'))
		echo $this->form->renderField('midlename') ?>
		
		<?php 
		if($config->get('rs_lastname'))
		echo $this->form->renderField('lastname') ?>
		<?php 
		if($config->get('rs_address'))
		 echo $this->form->renderField('address') ?>
		 
		<?php 
		if($config->get('rs_telephone'))
		 echo $this->form->renderField('telephone') ?>
		
		<?php 
		if($config->get('rs_mobile'))
		 echo $this->form->renderField('mobile') ?>
		<?php 
		if($config->get('rs_gender'))
		 echo $this->form->renderField('gender') ?>
		 
		 <?php 
		if($config->get('rs_birthday'))
		 echo $this->form->renderField('birthday') ?>
		 
		 <?php 
		if($config->get('rs_city'))
		 echo $this->form->renderField('city') ?>
		 <?php 
		if($config->get('rs_state'))
		 echo $this->form->renderField('state') ?>
		 
		 <?php 
		if($config->get('rs_country'))
		 echo $this->form->renderField('country_id') ?>
		
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER');?></button>
				<a class="btn" href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
				<input type="hidden" name="option" value="com_bookpro" />
				<input type="hidden" name="task" value="registration.register" />
				
				<input type="hidden" name="new_usertype" value="<?php echo $this->new_usertype ?>" />
			</div>
		</div>
		<?php echo JHtml::_('form.token');?>
	</form>
</div>
