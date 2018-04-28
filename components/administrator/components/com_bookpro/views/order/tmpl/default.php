<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 23 2012-07-08 02:20:56Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');
//BookProHelper::setSubmenu(4);
AImporter::helper('currency','date');
JToolBarHelper::title('Ticket Number: '.$this->order->order_number);

JToolBarHelper::back();
AImporter::model('bustrips','bustrip');
AImporter::helper('date','currency');

?>
	
	<?php 
		$layout = new JLayoutFile('invoice', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts/bus');
		$html = $layout->render($this->order);
		echo $html;
		
	?>