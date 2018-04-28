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
?>
<div class="btn-group pull-right">
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><?php echo JFactory::getUser()->name?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo 'index.php?option=com_bookpro&view=mypage&form=profile'?>">Edit profile</a></li>
                  <li><a href="<?php echo 'index.php?option=com_users&task=user.logout&'.JSession::getFormToken().'=1' ?>">Logout</a></li>
                   <li><a href="<?php echo 'index.php?option=com_bookpro&view=mypage&form=password&Itemid='.JRequest::getVar('Itemid') ?>">Change passord</a></li>
                </ul>
        </div>