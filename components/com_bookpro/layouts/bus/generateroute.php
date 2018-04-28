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
JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addScript(JUri::base().'components/com_bookpro/assets/js/bootstrap-timepicker.min.js');
$document->addStyleSheet(JUri::base().'components/com_bookpro/assets/css/bootstrap-timepicker.min.css');
?>
<?php
$i = 0; 
foreach ($this->bustrips as $bustrip){ 
		
?>
<div class="row-fluid">
	<div class="span10 offset1">
		<h3><?php echo JText::sprintf('COM_BOOKPRO_GENERATE_ROUTE_FROM_TO',$bustrip->from_title,$bustrip->to_title); ?></h3>
		<div class="row-fluid">
			<div class="span4">
				<dl>
					<dd><?php echo JText::_('Code') ?></dd>
					<dt><?php  ?></dt>
				</dl>
			</div>
			<div class="span4">
				<div class="form-horizontal">
				
					<div class="control-group">
						<div class="control-label"><?php echo JText::_('Start Location') ?></div>
						<div class="controls">
							<input type="text" name="jform[<?php echo $i ?>][start_loc]" />
						</div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo JText::_('End Location') ?></div>
						<div class="controls">
							<input type="text" name="jform[<?php echo $i ?>][end_loc]" />
						</div>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="form-horizontal">
					<div class="control-group">
						<div class="control-label"><?php echo JText::_('Start Time') ?></div>
						<div class="controls">
							<div class="input-append bootstrap-timepicker input-medium">
							<input type="text" class="input-small timepicker validate-duration" name="dfrom[start_time]" />
							<span class="add-on"><i class="icon-clock"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="form-horizontal">
					<div class="control-group">
						<div class="control-label"><?php echo JText::_('End Time') ?></div>
						<div class="controls">
							<div class="input-append bootstrap-timepicker input-medium">
							<input type="text" class="input-small timepicker validate-duration" name="dfrom[end_time]" />
							<span class="add-on"><i class="icon-clock"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$i++; 
} ?>
<script type="text/javascript">

jQuery(document).ready(function($) {
	
	$('.timepicker').timepicker({
		 
	    template: 'modal',
	    modalBackdrop:false,
	    appendWidgetTo: 'body',
	    
	    showMeridian: false
	    
	});
	$('.timeduration').timepicker({
	    minuteStep: 1,
	    template: 'modal',
	    appendWidgetTo: 'body',
	    showSeconds: true,
	    showMeridian: false,
	    defaultTime: false
	});
	
	
});				 
</script>