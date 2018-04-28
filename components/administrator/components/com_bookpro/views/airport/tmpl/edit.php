<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/

defined('_JEXEC') or die;
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
	
?>
<form action="<?php echo JRoute::_('index.php?option=com_bookpro&id=' . (int) $this->item->id); ?>" method="post" id="adminForm" name="adminForm" class="form-validate">


    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('title'); ?></div>
                </div>

                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
                </div>

                <div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('parent_id'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('parent_id'); ?>
					</div>
				</div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('image'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('image'); ?></div>
                </div>
                
                <!-- 
                 <div class="control-group">
                    <div class="control-label"><?php //echo $this->form->getLabel('value'); ?></div>
                    <div class="controls"><?php //echo $this->form->getInput('value'); ?></div>
                </div>
                 -->
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('code'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('code'); ?></div>
                </div>
                
                 <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('location'); ?></div>
                    <div class="controls"><?php 
                    
                    $this->form->setFieldAttribute('location', 'latitude', $this->item->latitude, $group = null);
                    $this->form->setFieldAttribute('location', 'longitude', $this->item->longitude, $group = null);
                    
                    echo $this->form->getInput('location'); ?>
                   <?php 
                   //$this->latitude=$this->item->latitude;
                   //$this->longitude=$this->item->longitude;
                                  
                   JFormHelper::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/elements');
                   $locationfield = JFormHelper::loadFieldType('location', false);
                                                     
                   $location=$locationfield->getMap();
                   echo $location;
                   
                   ?>
                   </div>
                </div>
                
                 <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('country_id'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('country_id'); ?></div>
                </div>
                
                
                
                 <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('intro'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('intro'); ?></div>
                </div>
                
               
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('state'); ?></div>
                </div>







            </fieldset>	
        </div>
<?php echo JLayoutHelper::render('joomla.edit.details', $this); ?>

    </div>



    <div>
        <input type="hidden" name="task" value="" /> 
        <input type="hidden" name="return" value="<?php echo JRequest::getCmd('return'); ?>" />
<?php echo JHtml::_('form.token'); ?>
    </div>
</form>