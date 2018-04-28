<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/

defined('_JEXEC') or die;
JHtml::_('behavior.formvalidation');
JToolBarHelper::title(JText::_('COM_BOOKPRO_POST_INSTALL'));
JHtml::_('formbehavior.chosen', 'select');
$data_url = 'index.php?option=com_bookpro&task=update.update&installtype=url';
$url = urlencode(JUri::root().'administrator/components/com_bookpro/install/sample.zip');
$data_url .='&install_url='.$url;
?>


<center>
<div style="width:768px;">
<form action="<?php echo JRoute::_('index.php?option=com_bookpro&id=' . (int) $this->item->id); ?>" method="post" id="adminForm" name="adminForm" class="form-validate">
		<div class="row-fluid" >
			<div class="span12" align="center">
				<div class='lead'><?php echo JText::_('COM_BOOKPRO_BUS_UPDATE_INSTALLTION_SUCCESSFULL') ?></div>
				<p><a href="http://joombooking.com/supports/documents/174-extension-installation-guide" target="_blank"><?php echo JText::_('COM_BOOKPRO_UPDATE_INSTALLATION_GUIDE'); ?></a> </p>
				<p><a href="http://joombooking.com/supports/documents/172-bus-booking-component-manual-for-joomla-3" target="_blank"><?php echo JText::_('COM_BOOKPRO_UPDATE_DOCUMENT'); ?></a></p>
				
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<a class="btn btn-large btn-success" href="<?php echo $data_url ?>"><?php echo JText::_('COM_BOOKPRO_UPDATE_SAMPLE_DATA') ?></a>
				<a class="btn btn-large btn-primary" href="index.php?option=com_bookpro"><?php echo JText::_('COM_BOOKPRO_UPDATE_COMPONENT') ?></a>
			</div>
		</div>    
</form>
</div>
</center>