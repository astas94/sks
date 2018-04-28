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

if($this->item->id && count($this->item->busstops)>=1) {

	for ($i = 0; $i < count($this->item->busstops); $i++) {
		
		$stop=$this->item->busstops[$i];
		
?>

<div class="container-fluid" id="busstop" style="margin-top: 10px;">
	<div class="form-inline">
					
			<?php 	echo BusHelper::getBusstopType('busstop[type][]',$stop->type);		?>
								
			<label><?php echo JText::_('COM_BOOKPRO_BUSSTOP_LOCATION') ?></label>
		<input class="input-medium" type="text" name="busstop[location][]" value="<?php echo $stop->location ?>"/> <label><?php echo JText::_('COM_BOOKPRO_BUSSTOP_DEPART'); ?></label>

		<div class="input-append bootstrap-timepicker">
			<input type="text" class="input-mini timepicker"
				name="busstop[depart][]" value="<?php echo $stop->depart ?>" /> <span class="add-on"><i class="icon-clock"></i></span>
		</div>

		<label><?php echo JText::_('COM_BOOKPRO_BUSSTOP_PRICE') ?></label> <input
			class="input-mini" type="text" name="busstop[price][]" value="<?php echo $stop->price ?>" />
			
			<input type="hidden" name="busstop[id][]" value="<?php echo $stop->id ?>" />

	</div>

</div>


<?php 
	}	
}else {
?>



<?php 
}
?>

<div class="container-fluid busstopclone" id="busstop" style="margin-top: 10px;">
	<div class="form-inline">
					
			<?php 	echo BusHelper::getBusstopType('busstop[type][]',0);		?>
								
		<label><?php echo JText::_('COM_BOOKPRO_BUSSTOP_LOCATION') ?></label>
		<input class="input-medium" type="text" name="busstop[location][]" /> <label><?php echo JText::_('COM_BOOKPRO_BUSSTOP_DEPART'); ?></label>

		<div class="input-append bootstrap-timepicker">
			<input type="text" class="input-mini timepicker"
				name="busstop[depart][]" /> <span class="add-on"><i class="icon-clock"></i></span>
		</div>


		<label><?php echo JText::_('COM_BOOKPRO_BUSSTOP_PRICE') ?></label> <input
			class="input-mini" type="text" name="busstop[price][]" />
			
		<input type="hidden" name="busstop[id][]" value="0" />

	</div>

</div>
<hr />
<div class="form-action pull-left">
	<button type="button" id="add_new_stop" class="btn btn-success">
		<icon class="icon-new"></icon>
							<?php echo JText::_('COM_BOOKPRO_ADD')?>
					</button>
</div>

<script type="text/javascript">
				jQuery(document).ready(function($) {

					$('.timepicker').timepicker({
						 
					    template: false,
					    modalBackdrop:false,
					    showMeridian: false
					    
					});
					
					$("#add_new_stop").click(function(){
						
						$( ".busstopclone" ).eq(0).clone().insertAfter("div.busstopclone:last");
						
					});
				
				});

				</script>