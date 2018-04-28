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


?>



	<div class="form-horizontal">
		
		<div class="control-group">
			<div class="control-label"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE'); ?></div>
			<div class="controls">
				<input type="text" class="required" id="generate_code" name="code" value="<?php echo isset($this->code) == true ? $this->code:""; ?>" placeholder="Обязательное поле" />
				<span id="statusCODE"></span>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo JText::_('COM_BOOKPRO_AGENT'); ?>
			</div>
			<div class="controls">
				<?php echo GenerateHelper::getAgentSelectBox($this->agent_id); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo JText::_('COM_BOOKPRO_BUSTRIP_BUS'); ?>
			</div>
			<div class="controls">
				<?php echo GenerateHelper::getBusSelectBox($this->bus_id); ?>
			</div>
		</div>
		
	<?php if (count($this->dests)>=2) {
	
	for ($i = 0; $i < count($this->dests); $i++) {
		?>
		
		  <div class="control-group dest">
			<div class="control-label">
				<?php echo JText::sprintf('COM_BOOKPRO_GENERATE_DESTINATION_TXT',$i+1); ?>
			</div>
			<div class="controls">
				<div class="form-inline">
				<?php 	echo $this->getDestinationSelectBox($this->dests[$i]);	 ?>
							<div class="input-append bootstrap-timepicker">
							<input type="text" class="input-mini timepicker validate-duration" name="depart[]" value="<?php echo $this->depart[$i]?>" />
							<span class="add-on"><i class="icon-clock"></i></span>
							</div>
				</div>
				</div>
			</div>
		
		
		<?php 
			
		}
	
	
	 } else { ?>
	
	 <div class="control-group dest">
			<div class="control-label">
				<?php echo JText::sprintf('Начальный пункт (время туда и обратно)'); ?>
			</div>
			<div class="controls">
				<div class="form-inline">
				<?php 	echo $this->getDestinationSelectBox(0);	 ?>
							<div class="input-append bootstrap-timepicker">
							<input type="text" class="input-mini timepicker validate-duration" name="depart[]" />
							<span class="add-on"><i class="icon-clock"></i></span>
							</div>
							<div class="input-append bootstrap-timepicker">
							<input type="text" class="input-mini timepicker validate-duration" name="departret[]" />
							<span class="add-on"><i class="icon-clock"></i></span>
							</div>
				</div>
				
				</div>
			</div>
			
			
			 <div class="control-group dest" id="clone">
			<div class="control-label">
				<?php echo JText::sprintf('Конечный  пункт  ( время туда и обратно )'); ?>
			</div>
			<div class="controls">
				<div class="form-inline">
				<?php 	echo $this->getDestinationSelectBox(0);	 ?>
							<div class="input-append bootstrap-timepicker">
							<input type="text" class="input-mini timepicker validate-duration" name="depart[]"  />
							<span class="add-on"><i class="icon-clock"></i></span>
							</div>
							<div class="input-append bootstrap-timepicker">
							<input type="text" class="input-mini timepicker validate-duration" name="departret[]"  />
							<span class="add-on"><i class="icon-clock"></i></span>
							</div>
				</div>
				</div>
			</div>
	
	<?php 
		
		 } ?>
			
		</div>
		
		<div class="row-fluid">
			<!--div class="span12" align="center">
				<button id="addDesination" type="button" class="btn btn-success">
					<?php echo JText::_('COM_BOOKPRO_GENERATE_ADD_DESTINATION') ?>
				</button>
				<!-- 
				<button type="submit" class="btn btn-primary">
					<?php echo JText::_('JAPPLY') ?>
				</button>
				 
			</div>-->
		</div>
		
	

<script type="text/javascript">

jQuery(document).ready(function($) {
	
	$('.timepicker').timepicker({
		 
	    template: 'modal',
	    modalBackdrop:false,
	    appendWidgetTo: 'body',
	    
	    showMeridian: false
	    
	});
	
	
	$("#addDesination").click(function(){

		$( ".dest" ).eq(1).clone().insertAfter("div.dest:last");
		$('.timepicker').on('click', '.timepicker', function(){
		     $(this).timepicker();  
		});
				
	});
	$("#generate_code").keyup(function(){
		var value = $(this).val();
		$.ajax({
			type:"GET",
			url: "index.php?option=com_bookpro&view=generate&task=generate.validate_code&code="+value+"&tmpl=component",
			beforeSend : function() {
				$("#statusCODE")
						.html(
								'<img src="<?php echo JUri::root(); ?>components/com_bookpro/assets/images/loader.gif" />');
			},
			success:function(result){
				
					if(result == 0)
					{ 
						
						jQuery("#statusCODE").html('&nbsp;<img src="<?php echo JUri::root(); ?>components/com_bookpro/assets/images/tick.png" align="absmiddle">');
					}  
					else
					{			
						
						jQuery("#generate_code").addClass("required invalid");
						//jQuery("#generate_code").addClass("invalid");
						jQuery("#generate_code").attr('aria-invalid','true');
						jQuery("#generate_code").attr('aria-required','true');
						jQuery("#generate_code").attr('required','required');
						jQuery("#statusCODE").css('color','red');
						
						
						jQuery("#statusCODE").html('<?php echo JText::_('COM_BOOKPRO_GENERATE_CODE_INVALID') ?>');
					} 
					
				}
			});	
	});
	
	
	
});				 
</script>

