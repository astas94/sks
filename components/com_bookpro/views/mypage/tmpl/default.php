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
jimport( 'joomla.html.html' );
AImporter::helper('date','bookpro','currency');

?>

<div class="row-fluid">

	<!--div class="span6 pull-right">
	
		<?php 
		//$layout = new JLayoutFile('mypage_menu', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
		//$html = $layout->render(null);
		//echo $html;
		?>
	</div-->

	<!--div class="span6 pull-left">
		
	</div-->


</div>

<div class="order">

<?php
if( (!$_POST["cancel"]) && (!$_POST["full_cancel"]) && (!$_POST["part_cancel_onward"]) && (!$_POST["part_cancel_return"]) && (!$_POST["part_cancel_all"]) )
{
	echo $this->loadTemplate(JRequest::getVar('form','order'));
}
else
{
	echo $this->loadTemplate(JRequest::getVar('form','order_cancel'));
}
?>

</div>
