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
$ThatTime ="23:59:00";
//$ThatTime2 ="23:00:00";
//if (strtotime($ThatTime2) >= strtotime($ThatTime)) {
//  echo "ok";
//}
//echo ('ttttttttttttttt'.uniqid());

?>
<script lang="text/javascript">
	jQuery(document).ready(function($) {

		//$("[name='roundtrip']").bootstrapSwitch();

		$('input[id="routedir1"]').on('click', function() {
			  //console.log(state);
			//	if(state) {
			//		$("[name='filter_roundtrip']").attr('value','1');
			//		$("#busFrm #returnDate").show();
			//	}
			//		else {
						$("[name='filter_roundtrip']").attr('value','0');
						$("#busFrm #returnDate").hide();
						$('input[name="roundtrip2"]').checked = false;
			//		}
			  
			});
			
		$('input[id="routedir2"]').on('click', function() {
			  //console.log(state);
			//	if(state) {
					$("[name='filter_roundtrip']").attr('value','1');
					$("#busFrm #returnDate").show();
					$('input[name="roundtrip1"]').checked = false;
			//	}
			//		else {
			//		$("[name='filter_roundtrip']").attr('value','0');
			//			$("#busFrm #returnDate").hide();
			//		}
			  
			});

		$('.input-append.date').datepicker({
			format: "<?php echo $js_format ?>",
		    autoclose: true,
		    startDate: 
		    <?php 
		        if (time() >= strtotime($ThatTime)) {
                  echo '"+0d"';
                }
                else {
                    echo '"+0d"';
                }
		    ?>
		    ,
		    endDate: "+1m",
language: "ru"
		});


   
  });
  </script>
<form name="busSearchForm" method="post" action="<?php echo JRoute::_('index.php?option=com_bookpro&view=bustrips') ?> " id="busFrm"
	onsubmit="return validateBusSearch();">
	<div class="container-fluid">
	
	
	<div class="row-fluid">
	<br />
	<div class="radio">
      <label><input type="radio"  name="roundtrip" id="routedir1" checked><?php echo JText::_('MOD_JBBUS_BUS_ONEWAY') ?></label>
    </div>
    <div class="radio">
      <label><input type="radio" name="roundtrip" id="routedir2" <?php if($roundtrip) echo 'checked' ?>><?php echo JText::_('MOD_JBBUS_BUS_ROUNDTRIP') ?></label>
    </div>
	</div>
	<br/>
	<div class="input-prepend">
  	<span class="add-on" style="min-width: 50px;"><?php  echo JText::_('MOD_JBBUS_BUS_FROM') ?></span>
 		 <?php echo $from_select ?>
 	 </div>
 	 <br/>
 	 <div class="input-prepend">
  	<span class="add-on" style="min-width: 50px;"><?php  echo JText::_('MOD_JBBUS_BUS_TO') ?></span>
 		 <?php echo $desto ?>
 	 </div>
	<br/>
				
	<div class="input-prepend input-append date">
			<span class="add-on"><?php  echo JText::_('MOD_JBBUS_BUS_DEPART') ?></span>
 					  <input type="text" class="input-small" name="filter_start" id="start" value="<?php echo $start  ?>"><span class="add-on"><i class="icon-calendar"></i></span>
	 		 </div>
				
				
					<div class="input-prepend input-append date" id="returnDate">
					 <span class="add-on"><?php  echo JText::_('MOD_JBBUS_BUS_RETURN') ?></span>
 					  <input type="text" class="input-small" name="filter_end" id="end" value="<?php echo $end	?>"><span class="add-on"><i class="icon-calendar"></i></span>
					  </div>
					  
					<div class="row-fluid">
						<div class="span4">
						<?php echo JText::_('MOD_JBBUS_BUS_ADULT') ?><br/>
						<?php echo JHtmlSelect::integerlist(0, 20, 1, 'filter_adult','class="input-mini" id="search_adult"',$adult)?>
						</div>
						
						<div class="span4">
						<?php 
						if($params->get('child')){

							echo JText::_('MOD_JBBUS_BUS_CHILD')."<br/>" ;
							echo JHtmlSelect::integerlist(0, 10, 1, 'filter_child','class="input-mini" id="search_child"',$child);
						}
						?>
						</div>
						<div class="span4">
						<?php 						
						if($params->get('senior')){

							echo JText::_('MOD_JBBUS_BUS_SENIOR')."<br/>" ;
							echo JHtmlSelect::integerlist(0, 10, 1, 'filter_senior','class="input-mini" id="search_senior"',$senior);
						}
						?>
						</div>
					</div>
				
				<div class="row-fluid text-center">
				<input name="btnSubmit"
				value="<?php echo JText::_('MOD_JBBUS_BUS_SEARCH')?>" type="submit"
					class="btn btn-primary" />
					</div>
	
	</div>
	
	<input type="hidden" name="Itemid"	value="<?php echo $Itemid ?>" />
	<input type="hidden" name="filter_roundtrip" value="<?php echo $roundtrip ?>" />
	<?php echo JHtml::_('form.token')?>
</form>
<script type="text/javascript">

 jQuery(document).ready(function($) {
		 <?php if($roundtrip) {?>
			 $("#busFrm #returnDate").show();
		<?php } else {?>
			$("#busFrm #returnDate").hide();
		<?php } ?>

		$("#busFrm input:radio[name=filter_roundtrip]").change(function(){
			if($("#busFrm input:radio[name=filter_roundtrip]:checked").val()==0)
				$("#busFrm #returnDate").hide();
			if($("#busFrm input:radio[name=filter_roundtrip]:checked").val()==1) 
				$("#busFrm #returnDate").show();
		});

				

	$("#busFrm #filter_from").change(function(){
			$.ajax({
				type:"GET",
				url: "index.php?option=com_bookpro&controller=bus&task=findDestination&format=raw",
				data:"desfrom="+jQuery(this).val(),
				beforeSend : function() {
					$("#busFrm select#filter_to")
							.html('<option><?php echo JText::_('MOD_BOOKPRO_LOADING') ?></option>');
				},
				success:function(result){
						$("#busFrm select#filter_to").html(result);
					}
				});
		});
	
});

function validateBusSearch(){	
	var form= document.busSearchForm;
	var end= form.end;

	
	if(!form.filter_from.value){
		alert('<?php echo JText::_('MOD_JBBUS_BUS_SELECT_DEPARTURE_WARN')?>');
		form.filter_from.focus();
		return false ;
	}
	if(!form.filter_to.value){
		alert('<?php echo JText::_('MOD_JBBUS_BUS_SELECT_RETURN_WARN')?>');
		form.filter_to.focus();
		return false;
	
	}
	if(form.filter_start.value==""){
		alert('<?php echo JText::_('MOD_JBBUS_BUS_DEPART_DATE_WARN')?>');
		return false;
	}
	if(form.filter_end.value==""){
		alert('<?php echo JText::_('MOD_JBBUS_BUS_RETURN_DATE_WARN')?>');
		return false;
	}
	var total=jQuery('#search_adult').val()+jQuery('#search_child').val()+jQuery('#search_senior').val();
	if(total==0){

		alert('<?php echo JText::_('MOD_JBBUS_BUS_SELECT_PASSENGER_WARN')?>');
		return false;
	}
	
	form.submit();
}


</script>
