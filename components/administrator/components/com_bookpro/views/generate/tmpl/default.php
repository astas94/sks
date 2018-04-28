<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/


defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.formvalidation');

JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addScript(JUri::base().'components/com_bookpro/assets/js/bootstrap-timepicker.min.js');
$document->addStyleSheet(JUri::base().'components/com_bookpro/assets/css/bootstrap-timepicker.min.css');
JToolBarHelper::title(JText::_('Добавление нового маршрута'), 'stack');
JToolBarHelper::cancel('generate.cancel');
JToolBarHelper::save('generate.save');




?>
<script type="text/javascript">
 Joomla.submitbutton = function(task) {
	
      var form = document.adminForm;
      if (task == 'generate.cancel') {
         form.task.value = task;
         form.submit();
      }
      if (task == 'generate.create') {
          if(!jQuery("#generate_code").val()){
              
              alert('<?php echo JText::_('COM_BOOKPRO_GENERATE_CODE_VALID') ?>');
              return false;
           }
         
 			
          var continus=true;
          for(i=0;i<jQuery('.destination').length;i++)
          {
        	  thisValue=jQuery('.destination:eq('+i+')').val();
        	  if(thisValue == 0){
        		  continus=false;
        		  break;
              }
        	  for(j=0;j<jQuery('.destination').length;j++)
        	  {
        		  thisValue2=jQuery('.destination:eq('+j+')').val();
            	  if(j!=i)
            	  {
                	  if(thisValue==thisValue2)
                	  {
                		  continus=false;
                		  break;
                	  }
            	  }
        	  }
              
              
          }
         
          if(continus === false)
          {
        	  alert("<?php echo JText::_( 'COM_BOOKPRO_GENERATE_ROUTE', true ); ?>");
              
              return false;
          }
          if(jQuery('#generateagent_id').val() == 0){
        	  alert('<?php echo JText::_('COM_BOOKPRO_GENERATE_AGENT_VALID') ?>');
              return false;
          }
          form.task.value = task;
          form.submit();
       }
      if (document.formvalidator.isValid(form)) {
         form.task.value = task;
         form.submit();
       }
       else {
         alert('<?php echo JText::_('Fields highlighted in red are compulsory or unacceptable!'); ?>');
         return false;
       }
   };

</script>
<form action="<?php echo JRoute::_('index.php?option=com_bookpro&view=generate'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
<div class="generate">
    <div class="row-fluid">
	<input class="input" type="checkbox"  name="roundtrip" checked /> Маршрут туда и обратно 
	
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span7">
			<?php echo $this->loadTemplate('destination')		?>
		</div>
		<div class="span5">
		<?php
			if (!empty($this->bustrips)){
				$layout = new JLayoutFile ( 'generateroute', $basePath = JPATH_ROOT . '/components/com_bookpro/layouts' );
					
				$html = $layout->render ( $this->bustrips );
				echo $html;
			}
			?>
			<?php 
			if (!empty($this->bustrips)){
			?>
			<div class="row-fluid">
				<div class="span12" align="center">
					<button onclick="Joomla.submitbutton('generate.save')" class="btn btn-medium btn-primary">
						<span class="icon-apply icon-white"></span>
						<?php echo JText::_('COM_BOOKPRO_SAVE'); ?>
					</button>
				</div>
			</div>
			<?php } ?>
			
		</div>
	</div>
</div>
	    
	 	<input type="hidden" name="task" id="task" value="" /> 
        <input type="hidden" name="return" value="<?php echo JRequest::getCmd('return'); ?>" />
	<?php echo JHtml::_('form.token'); ?>

</form>

