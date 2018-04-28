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

defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.modal','a.amodal');
AImporter::helper('form','currency');
AImporter::css('jbbus');

$siteError = JFactory::getApplication()->input->getString('errorCode');
$sberError = JRequest::getVar('orderId');
if(isset($siteError)){
	$errorCode = JFactory::getApplication()->input->getString('errorCode');
	$errorMessage = JFactory::getApplication()->input->getString('errorMessage');
	$warning = 'Ошибка '.$errorCode.': '.$errorMessage;
	JError::raiseWarning( 100, $warning );
}/*elseif(JRequest::getVar('errorCode')){
	$errorCode = JRequest::getVar('errorCode');
	$errorMessage = JRequest::getVar('errorMessage');
	$warning = 'Ошибка '.$errorCode.': '.$errorMessage;
	JError::raiseWarning( 100, $warning );
}*/
elseif(isset($sberError)){
	$errorCode = 2;
	$errorMessage = 'Платеж отклонен';
	$warning = 'Ошибка '.$errorCode.': '.$errorMessage;
	JError::raiseWarning( 100, $warning );
}
?>
<form name="frontForm" method="post" action="index.php" id="paymentForm">

	<div class="row-fluid">
		<?php echo $this->loadTemplate('cart')?>
	</div>
	<div class="row-fluid">
		<h2 class="block_head">
			<span> <?php echo JText::_('COM_BOOKPRO_PAYMENT_SELECT')?>
			</span>

		</h2>

		<div class="">

			<?php
			if ($this->plugins)
			{
				foreach ($this->plugins as $plugin)
				{
					?>
			<input value="<?php echo $plugin->element; ?>" class="payment_plugin" onclick="getPaymentForm('<?php echo $plugin->element; ?>', 'payment_form_div');"
				name="payment_plugin" type="radio"	<?php echo (/*!empty($plugin->checked)*/$plugin->name == 'Payment sberbank') ? "checked" : ""; ?>
				/>

			<?php
			$params= new JRegistry;
			$params->loadString($plugin->params);
			$title = $params->get('display_name', '');
			if(!empty($title)) {
				echo $title;
			} else {
				echo JText::_($plugin->name );
			}
			?>
			<br />
			<?php
				}
			}
			?>
			<div id='payment_form_div' style="padding-top: 10px;">
				<?php
				if (!empty($this->payment_form_div))
				{
					echo $this->payment_form_div;
				}
				?>

			</div>

		</div>

		<div class="form-inline">
			<input type="checkbox" value="30" name="license_confirm"
				checked="checked" id='license_confirm' class="controls"> <label
				class="controls" for="term_condition"> 
                <!--<a href="index.php?option=com_content&id=<?php echo $this->config->get('term_content_id') ?>&view=article&tmpl=component&task=preview" -->
				<a href="/images/ticket_sale_rules.pdf"
                class='amodal' rel="{handler: 'iframe', size: {x: 800, y: 470}}"><?php echo JText::_("COM_BOOKPRO_ACCEPT_TERM")?>
			</a>
			</label>
		</div>
		<br />

		<div class="center-button">
			<input class="btn btn-primary" type="submit"
				value="<?php echo JText::_('COM_BOOKPRO_PAYNOW')?>" name="btnSubmit"
				id="submitpayment" />
		</div>
		<?php
			$uri = &JFactory::getURI();
		        $url = $uri->toString(array('scheme', 'host', 'path', 'query', 'fragment'));
			$url = explode('&errorCode' , $url);
			$url = $url[0];
			$url = explode('&orderId' , $url);
			$url = $url[0];
			echo FormHelper::bookproHiddenField(array('controller'=>'payment','task'=>'process','Itemid'=>JRequest::getVar('Itemid'),'order_id'=>$this->order->id, 'failUrl'=>$url));
		?>

	</div>
	<div class="clear"></div>
</form>

<script type="text/javascript">

function getPaymentForm(element,container){
	
	jQuery(document).ready(function($) {
	container = '#'+container;
	$.ajax({
		url : siteURL + 'index.php?option=com_bookpro&controller=payment&task=getPaymentForm&format=raw&payment_element='+ element,
		type : 'post',
		cache: false,
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        beforeSend: function() {
           	 
             },
        complete: function() {
        	 
         },
        success: function(json) {
        	$(container).html(json.msg);
			return true;
		}
	});
	});
	}
				
jQuery(document).ready(function($) {

	
	

	 $("#submitpayment").click(function() {

		if(jQuery("input:radio[name='payment_plugin']").is(":checked")==false)
		{
			alert("<?php echo JText::_('COM_BOOKPRO_SELECT_PAYMENT_METHOD_WARN') ?>");
   	 		return false; 
		}
		if(jQuery('#license_confirm').is(':checked')==false){
    		alert("<?php echo JText::_('COM_BOOKPRO_ACCEPT_TERM_WARN') ?>");
   	 		return false;      
    	}
		$("#paymentForm").submit();
	});

	 $("#couponbt").click(function() {

			if($("input:text[name=coupon]").val()){
				$("input:hidden[name=controller]").val('order');
		    	$("input:hidden[name=task]").val('applycoupon');
		    	$("#paymentForm").submit();
				}
			else {
				alert('Пустой номер купона');
				return false;
			}

		    });
	
});
	
	
</script>

