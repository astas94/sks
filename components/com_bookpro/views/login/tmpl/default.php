<?php 
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/

defined( '_JEXEC' ) or die( 'Restricted access' );
$doc = JFactory::getDocument();

$action=JURI::base().'index.php?option=com_bookpro&controller=customer&task=bplogin';
?>

<form name="loginform" method="post" action="<?php echo $action?>" class="form-horizontal">
  <fieldset>
    <legend>
		<?php echo JText::_("COM_BOOKPRO_CUSTOMER_LOGIN") ?>
	</legend>

        <div class="login">            
           
            <div class="control-group">
                <label class="control-label"> <?php echo JText::_('COM_BOOKPRO_CUSTOMER_USERNAME'); ?>:</label>
                <div class="controls">
                	<input type="text" class="required" id="username" name="username" value="" size="25" placeholder="<?php echo JText::_('COM_BOOKPRO_CUSTOMER_USERNAME'); ?>" style=" height:25px; margin-bottom:10px;" required/>
            	</div>
            </div>
            <div class="control-group">
                <label class="control-label"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_PASSWORD'); ?>: </label>
                <div class="controls">
                	<input type="password" class="required" id="password" name="password" value="" placeholder="<?php echo JText::_('COM_BOOKPRO_CUSTOMER_PASSWORD'); ?>" style=" height:25px; margin-bottom:10px;" required/>
            	</div>
            </div>    
            <div class="control-group">
            	<div class="controls">
            		<label class="checkbox"> 
            			<input type="checkbox"> <?php echo JText::_('COM_BOOKPRO_CUSTOMER_REMEMBER_ME') ?> 
            		</label>
            	</div>
	            
		        <div class="controls">
	            <label class="checkbox">
	                    <a href="<?php echo JRoute::_(JURI::root().'index.php?option=com_bookpro&view=reset&Itemid='.JRequest::getVar('Itemid')) ?>">
	                        <?php echo JText::_('Forgot your password?'); ?>
	                    </a>
	            </label> 
	            <button type="submit" class="btn btn-medium btn-primary" style="float: left; margin-left: 85px;" type="submit"> <?php echo JText::_('COM_BOOKPRO_CUSTOMER_LOGIN'); ?> </button>   
	            </div> 
            </div>                                                                                              
                
        </div>

	<input type="hidden" name="return" value="<?php echo JRequest::getVar('return',0) ;?>" />
    <input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid') ;?>" />
    
	<?php echo JHtml::_('form.token'); ?>
 </fieldset>    
</form>


