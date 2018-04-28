<?php
/**
 * @package   Bookpro
 * @author    Ngo Van Quan
 * @link    http://joombooking.com
 * @copyright   Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version   $Id$
 **/
defined('_JEXEC') or die('Restricted access');
jimport ( 'joomla.filesystem.file' );
AImporter::model('bustrips','bustrip','passengers','order');
JHtml::_('behavior.modal');
AImporter::helper('date','currency','bus','refund');

$order_number = JRequest::getVar('order_number','');
$order = new BookProModelOrder();
$this->order = $order->getByOrderNumber($order_number);
		$endcode = rtrim(strtr(base64_encode($this->order->id), '+/', '-_'), '=');
		
$check_can =(int) RefundHelper::getCheckCancel($this->order->id);


?>
<div class="row-fluid">
	<div class="span12" align="center">
		<div class="invoice_print" align="right">
			<ul class="nav nav-pills pull-right">
				<?php if ($check_can){ ?>
				<li>
					<a href="<?php echo JRoute::_('index.php?option=com_bookpro&view=refund&order_id='.$endcode) ?>"><?php echo JText::_('COM_BOOKPRO_CANCEL') ?></a>
					
				</li>
				<?php } ?>
				<li>
					<a href="#"><?php echo JText::_('COM_BOOKPRO_PRINT') ?></a>
					
				</li>
				<li>
					<a href="#"><?php echo JText::_('COM_BOOKPRO_EMAIL') ?></a>
					
				</li>
			</ul>
		</div>
	</div>
</div>
<?php 
$layout = new JLayoutFile('invoice', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts/bus');
$html = $layout->render($this->order);
echo $html;
?>


