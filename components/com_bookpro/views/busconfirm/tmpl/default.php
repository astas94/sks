<?php
/**
 * @package     Bookpro
 * @author         Ngo Van Quan
 * @link         http://joombooking.com
 * @copyright     Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version     $Id: default.php  23-06-2012 23:33:14
 **/
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
AImporter::helper ( 'date', 'form', 'currency', 'bookpro' );
AImporter::css ( 'customer', 'jbbus' );

// JHtml::_('behavior.formvalidation');

JHtml::_ ( 'jquery.framework' );
// JHtml::_('jquery.ui');

$lang = JFactory::getLanguage ();
$local = substr ( $lang->getTag (), 0, 2 );

$document = JFactory::getDocument ();
$document->addScript ( JURI::root () . 'components/com_bookpro/assets/js/bootstrap-datepicker.js' );
if ($local != "en") {
	$document->addScript ( JURI::root () . 'components/com_bookpro/assets/js/locales/bootstrap-datepicker.' . $local . '.js' );
}
$document->addStyleSheet ( JURI::root () . 'components/com_bookpro/assets/css/datepicker.css' );

// $document->addScript("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js");

if ($local == 'pt') {
	$local = pt_PT;
}
if ($local != "en") {
	// $document->addScript(JURI::root().'components/com_bookpro/assets/js/validatei18n/messages_'.$local.'.js');
}

$js_format = DateHelper::getConvertDateFormat ( 'B' );
$date_format = DateHelper::getConvertDateFormat ( 'P' );

?>


<script lang="text/javascript">
	jQuery(document).ready(function($) {
		
		$('.birthday').datepicker({
			format: "<?php echo $js_format ?>",
		    autoclose: true,
		    endDate: "-3m",
language:"ru"
		});

		$('.expired').datepicker({
			format: "<?php echo $js_format ?>",
		    autoclose: true,
		    endDate: "-3m"
		});
   
  });
  </script>


<form name="frontBusForm" action="<?php echo JRoute::_('index.php')?>"
	method="post" id="frontBusForm">
	<div class="well well-small">
		<div class="row-fluid">
			<div class="span4">
				<!-- Summary -->
			<?php echo $this->loadTemplate('sumary')?>
		    </div>
			<div class="span8">
				<div class="passenger well" style="background-color: white;">
			<?php
			
		$client = JFactory::getApplication ()->client;
			
			if ($client->mobile) {
				$layout = new JLayoutFile ( 'passenger_form_mob', $basePath = JPATH_ROOT . '/components/com_bookpro/layouts' );
			} else
				$layout = new JLayoutFile ( 'passenger_form_mob', $basePath = JPATH_ROOT . '/components/com_bookpro/layouts' );
			$html = $layout->render ( $this->passengers );
			echo $html;
			?>
		    </div>
		
		<?php
		$user = JFactory::getUser ();
		//if ($user->guest) {
		if (true) {
		    //echo("test");
			echo BookProHelper::renderLayout ( 'customer', null );
		} else {
			$account = JBFactory::getAccount ();
			if($account->id){

				if ($account->isAgent) {

				}

			}else{
				$user->firstname=$user->name;
				echo BookProHelper::renderLayout ( 'customer', $user );
			}
			
		}
		
		?>
		
		<div style="text-align: center;">
					<p>Нажимая кнопку "Дальше" вы подтверждаете свое согласие с <a href="/index.php/info/terms" target="_blank">Пользовательским соглашением</a>, <a href="/index.php/info/privacy-policy" target="_blank">Политикой конфиденциальности </a> и <a href="/images/ticket_sale_rules.pdf" target="_blank">Правилами продажи билетов</a></p>
					<button type="submit" class="btn btn-primary"><?php echo JText::_('COM_BOOKPRO_CONTINUE')?></button>
				</div>
			</div>
		</div>

	</div>
	<?php
	$hidden = array (
			'controller' => 'bus',
			'task' => 'confirm',
			"Itemid" => JRequest::getVar ( 'Itemid' ) 
	);
	echo FormHelper::bookproHiddenField ( $hidden );
	
	?>
</form>

