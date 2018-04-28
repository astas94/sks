<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php  23-06-2012 23:33:14
 **/
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
$config=JComponentHelper::getParams('com_bookpro');
AImporter::helper ( 'form' );
JHtml::_ ( 'jquery.framework' );
JHtml::_ ( 'jquery.ui' );
AImporter::js('view-bustrips','jquery-create-seat','jquery.session','jquery.tablesorter.min','jquery.tablesorter.widgets.min');
AImporter::css ( 'bus', 'jbbus','jquery-create-seat','view-bustrips','theme.bootstrap');
$user=JFactory::getUser();
 
$lang = JFactory::getLanguage ();
$local = substr ( $lang->getTag (), 0, 2 );
$doc = JFactory::getDocument ();

$doc->addScriptDeclaration ( '
		var adult=' . ($this->adult+$this->senior+$this->child) . ';
		var msg_select_again="' . JText::sprintf ( "COM_BOOKPRO_SELECT_AGAIN", $this->adult ) . '";
		' );

$today = JFactory::getDate ()->getTimestamp ();
$from_title = $this->from_to [0]->title;
$to_title = $this->from_to [1]->title;
//var_dump($this);

?>

<div class="bustrip_form">
	<form name="bustrip_form" id="bustrip_form" method="post"
		action='<?php echo JRoute::_('index.php?option=com_bookpro&view=busconfirm')?> '
		onsubmit="return submitForm()">
		<div class="well well-small" style="text-align: center;">
				<span><?php echo JText::sprintf('COM_BOOKPRO_BUS_FROM_TO',$from_title,$to_title)?></span><br/>
				<?php echo JFactory::getDate($this->start)->format('d.m.Y'); ?>
		</div>

		<div id="tabs">
			<!-- Display oneway trip -->
			<?php
			echo JLayoutHelper::render('depart2',$this->going_trips,$basePath = JPATH_ROOT . '/components/com_bookpro/layouts/bus');
			?>
		</div>
		<?php 
		
		?>
		<p></p>

		<?php 
		
		if ($this->roundtrip==1) {?>
		<div class="well well-small" style="text-align: center;">
				<span><?php echo JText::sprintf('COM_BOOKPRO_BUS_FROM_TO',$to_title,$from_title)?>
				</span> <br/>
			<?php echo JFactory::getDate($this->end)->format('d.m.Y'); ?>
		</div>

		<div id="tabs_return">
			<!-- Display return trip -->
			
			<?php echo JLayoutHelper::render('return2',$this->return_trips,$basePath = JPATH_ROOT . '/components/com_bookpro/layouts/bus');
			
			?>
		</div>
		<?php } ?>
		
		<input type="hidden" name="seat" value="" id="order_seat" />
		<input type="hidden" name="return_seat" id="order_return_seat" value="" />
		<input type="hidden" name= 'Itemid' value="<?php echo JRequest::getVar('Itemid')?>"/>
	</form>
</div>
<script type="text/javascript">


function getValidateSeat(pSeat,j){
	var check = true;
	
	for(var i = 0;i < pSeat.length;i++){
		
		if(i != j){
			
			if(parseInt(pSeat[j].value) == parseInt(pSeat[i].value)){
				
				check = false;
			}
		}
	}
	return check;
}	

function submitForm(){
	
	
	var form= document.bustrip_form;
	if(jQuery("input:radio[name='bustrip_id']").is(":checked")==false)
	{
		alert("<?php echo JText::_('COM_BOOKPRO_SELECT_BUSTRIPS_WARN')?>");
	 		return false; 
	}
	if(jQuery("input:radio[name='return_bustrip_id']").is("*")){
		if(jQuery("input:radio[name='return_bustrip_id']").is(":checked")==false)
		{
			alert("<?php echo JText::_('COM_BOOKPRO_SELECT_BUSTRIPS_WARN')?>");
		 		return false; 
		}
	}
	var stop=0;
	jQuery("input:radio[name='bustrip_id'],input:radio[name='return_bustrip_id']").each(function () {
		
		if(jQuery(this).is(":checked"))
		{
			var tr_viewseat=jQuery(this).closest('.busitem').next('.tr_viewseat');
			if(tr_viewseat.find('.bodybuyt .choose').length<adult)
			{
				alert('<?php echo JText::_('COM_BOOKPRO_SELECT_SEAT_WARN') ?>');
				stop=1;
				tr_viewseat.find('.bodybuyt').focus();
				return false;
				
			}
		}
	});
	
	
	if(stop==1)
	{
		return false;
	}	
	form.submit();
}
</script>

