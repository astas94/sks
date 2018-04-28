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

?>
 
      

<div class="row-fluid" >
  <div class="profile-edit">
		<form action="<?php echo  JRoute::_('index.php'); ?>" method="post"
			name="registerform">
		 
			<?php echo $this->loadTemplate('customer');  ?>
			
			<div class="center">
			<input
				type="submit" class="btn btn-primary" name="submit" id="submit"	value="<?php echo JText::_('COM_BOOKPRO_SAVE_CHANGE');?>" onclick="return validation()"
				/>
			</div>
			 
			<input type="hidden" name="option" value="com_bookpro" /> <input
				type="hidden" name="user_id" value="<?php echo $user_id->id;?>" /> <input
				type="hidden" name="return" value="<?php echo $this->return?>" /> <input
				type="hidden" name="controller" value="customer" /> <input
				type="hidden" name="task" value="save" />
		
			<?php echo JHTML::_( 'form.token'); ?>
			
			
			
			
		
		</form>
		</div>
		<!--div class="span6">
		
		<form action="<?php echo  JRoute::_('index.php'); ?>" method="post" name="registerform" class="form-validate">
	
	  	<div class="form-horizontal">
		<fieldset>
		<legend> <?php echo JText::_('COM_BOOKPRO_PASSWORD')?></legend>	  	
		  	<div class="control-group">
				<label class="control-label" for="username"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_USERNAME' ); ?>
				</label>
				<div class="controls">
					
					<input class="inputbox required" type="password" name="password" id="pass" size="30" maxlength="50" value="" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_USERNAME' ); ?>" />
		      
				</div>
			</div>
		    
		    <div class="control-group">
				<label class="control-label" for="password"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_PASSWORD' ); ?>
				</label>
		    	
				<div class="controls">
					<input class="inputbox required" type="password" name="password" id="pass" size="30" maxlength="50" value="" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_PASSWORD' ); ?>" />
				</div>
		    </div>
		    
			<div class="control-group">
				<label class="control-label" for="password2"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_CONFIRM_PASSWORD' ); ?>
				</label>
		    	<div class="controls">
					<input class="inputbox" type="password" name="password2" id="pass2" size="30" maxlength="50" value="" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_CONFIRM_PASSWORD' ); ?>" />
				</div>
		    </div>
		    <div class="control-group">
		    <div class="controls">
		    	<input type="submit" class="btn btn-primary" name="submit" value="<?php echo JText::_('COM_BOOKPRO_SAVE_CHANGE');?>" />
		    </div>
		    </div>
	    </fieldset>
	    </div>
	
	
	  <input type="hidden" name="option" value="com_bookpro" />
	   
	  <input type="hidden" name="controller" value="customer"/>
	
	  <input type="hidden" name="task" value="changepassword" />
	
	  <?php echo JHTML::_( 'form.token' ); ?>
	
	</form>
		
		</div-->
		
	</div>	
