<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 81 2012-08-11 01:16:36Z quannv $
 **/

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
$input = JFactory::getApplication()->input;
$jform = $input->get('jform',array(),'array');
AImporter::model('pmibustrips');
$data = json_decode(json_encode($jform),false);

$layout = new JLayoutFile('seattemplate', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts/bus');
$html = $layout->render($data);

echo $html;
?>