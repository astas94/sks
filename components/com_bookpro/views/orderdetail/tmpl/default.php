<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );

?>

<div class="container" style="max-width: 90%;">
	<div >
	<?php echo $this->loadTemplate('header')?>
	<?php echo $this->loadTemplate(strtolower($this->order->type))?>
</div>
</div>