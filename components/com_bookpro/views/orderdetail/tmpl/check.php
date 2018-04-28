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
$doc = JFactory::getDocument();
JHtml::_('jquery.framework');
//$doc->addScript(Juri::root() . '/components/com_bookpro/assets/js/jquery.maskedinput-1.3.1.min');
$doc->addScript('http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js');
$doc->addScript('http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.min.js');

?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#itineray-form").validate({
			rules: {
				
			}
		});
		
	});
 </script>
 <div class="container" style="max-width: 90%;">
		 <div class="well well-small" >
		 	<h1 class="page-content-header round-box">
                <i class="icon-user icon-large"></i>
                <span><?php echo JText::_('COM_BOOKPRO_VIEW_ORDER_HEADLINE')?></span></h1>
		 </div>
		 
		 <div class="well">
                <div class="well well-small wellwhite">
                        <h4><?php echo JText::_('COM_BOOKPRO_VIEW_ORDER_SUBHEADLINE')?></h4>
                        <form id="itineray-form" class="form-inline" action="<?php echo JRoute::_('index.php?option=com_bookpro&view=orderdetail')?>" method="post">
                                    <label class="control-label"><?php echo JText::_('COM_BOOKPRO_ORDER_NUMBER')?></label>
                                    <input type="text"  name="order_number" required class="input">
                                    <br/>
                                    <br/>
                                    <label class="control-label"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_EMAIL')?></label>
                                    <input type="email"  name="email" class="input" required>
                                    <br/>
                                    <br/>
                                    <input type="submit"  value="Поиск" class="btn btn-primary"/>
                        </form>
                       
                    </div>
                </div>
                
             </div>   
