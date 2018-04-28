<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
JHtml::_ ( 'behavior.formvalidation' );
JHtml::_ ( 'jquery.framework' );

$document = JFactory::getDocument ();
$document->addScript ( JUri::base () . 'components/com_bookpro/assets/js/bootstrap-timepicker.min.js' );
$document->addStyleSheet ( JUri::base () . 'components/com_bookpro/assets/css/bootstrap-timepicker.min.css' );

?>

<script type="text/javascript">
       

</script>
<form
	action="<?php echo JRoute::_('index.php?option=com_bookpro&layout=edit&id='.(int) $this->item->id);  ?>"
	method="post" name="adminForm" id="adminForm" class="form-validate">

	<div class="form-horizontal">
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_BOOKPRO_BUSTRIP', true)); ?>
			<?php echo $this->form->renderField('code'); ?>
			<?php echo $this->form->renderField('from'); ?>
			<?php echo $this->form->renderField('to'); ?>

			<?php echo $this->form->renderField('bustrip_type'); ?>

			<?php echo $this->form->renderField('bus_id');  ?>
			<?php echo $this->form->renderField('agent_id');  ?>
			
			<?php echo $this->form->renderField('start_time');  ?>
			<?php echo $this->form->renderField('duration');  ?>
			<?php echo $this->form->renderField('end_time');  ?>
			
			<?php echo $this->form->renderField('policy');  ?>
			<?php //echo $this->form->renderField('door');  ?>	
			<?php //echo $this->form->renderField('drop_door');  ?>	
			<?php echo $this->form->renderField('state');  ?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		
				
			
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'busstoptab', JText::_('COM_BOOKPRO_BUSSTOP')); 
			echo $this->loadTemplate ( 'busstop' );
		 	echo JHtml::_ ( 'bootstrap.endTab' );
			?>	
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>

	<input type="hidden" name="task" value="" />
	 <?php echo JHtml::_('form.token'); ?>

</form>
</div>

