<?php
/**
 * @version     1.0.0
 * @package     com_bookpro
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ngo <quannv@gmail.com> - http://joombooking.com
 */
// no direct access
defined ( '_JEXEC' ) or die ();

JHtml::addIncludePath ( JPATH_COMPONENT . '/helpers/html' );
JHtml::_ ( 'behavior.tooltip' );
JHtml::_ ( 'behavior.formvalidation' );
JHtml::_ ( 'formbehavior.chosen', 'select' );
JHtml::_ ( 'behavior.keepalive' );

// Import CSS
$document = JFactory::getDocument ();
$document->addStyleSheet ( 'components/com_bookpro/assets/css/bookpro.css' );
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
	js('input:hidden.agent_id').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('agent_idhidden')){
			js('#jform_agent_id option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_agent_id").trigger("liszt:updated");
	js('input:hidden.seattemplate_id').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('seattemplate_idhidden')){
			js('#jform_seattemplate_id option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_seattemplate_id").trigger("liszt:updated");
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'bus.cancel') {
            Joomla.submitform(task, document.getElementById('bus-form'));
        }
        else {
            
            if (task != 'bus.cancel' && document.formvalidator.isValid(document.id('bus-form'))) {
                
                Joomla.submitform(task, document.getElementById('bus-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_bookpro&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm"
	id="bus-form" class="form-validate">

	<div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_BOOKPRO_TITLE_BUS', true)); ?>
        <div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
					</div>
					
					<?php foreach ($this->form->getGroup('params') as $field) : ?>
						<?php echo $field->getControlGroup(); ?>
					<?php endforeach; ?>
					<!-- 
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('seat'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('seat'); ?></div>
					</div>
					 -->
					
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('upperseattemplate_id'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('upperseattemplate_id'); ?></div>
					</div>
										
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('seattemplate_id'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('seattemplate_id'); ?></div>
					</div>
					
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('agent_id'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('agent_id'); ?></div>
					</div>

			<?php
			foreach ( ( array ) $this->item->agent_id as $value ) :
				if (! is_array ( $value )) :
					echo '<input type="hidden" class="agent_id" name="jform[agent_idhidden][' . $value . ']" value="' . $value . '" />';
				
					endif;
			endforeach
			;
			?>			

					<input type="hidden" name="jform[bus_type]"
						value="<?php echo $this->item->bus_type; ?>" />
					

			<?php
			foreach ( ( array ) $this->item->seattemplate_id as $value ) :
				if (! is_array ( $value )) :
					echo '<input type="hidden" class="seattemplate_id" name="jform[seattemplate_idhidden][' . $value . ']" value="' . $value . '" />';
				
					endif;
			endforeach
			;
			?>				<input type="hidden" name="jform[seat_number]"
						value="<?php echo $this->item->seat_number; ?>" />
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('desc'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('desc'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
					</div>
					<input type="hidden" name="jform[image]"
						value="<?php echo $this->item->image; ?>" />
					
					<input type="hidden" name="jform[child_price]"
						value="<?php echo $this->item->child_price; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]"
						value="<?php echo JFactory::getUser()->id; ?>" />

				<?php
				
} else {
					?>
					<input type="hidden" name="jform[created_by]"
						value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>				<input type="hidden" name="jform[modified_by]"
						value="<?php echo $this->item->modified_by; ?>" /> <input
						type="hidden" name="jform[ordering]"
						value="<?php echo $this->item->ordering; ?>" /> <input
						type="hidden" name="jform[checked_out]"
						value="<?php echo $this->item->checked_out; ?>" /> <input
						type="hidden" name="jform[checked_out_time]"
						value="<?php echo $this->item->checked_out_time; ?>" />


				</fieldset>
			</div>
		</div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>