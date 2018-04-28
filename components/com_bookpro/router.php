<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: router.php 53 2012-07-17 14:42:54Z quannv $
 **/
defined ( '_JEXEC' ) or die ();

/**
 * Build the route for the com_bookpro component
 *
 * @param
 *        	array	An array of URL arguments
 * @return array URL arguments to use to assemble the subsequent URL.
 * @since 1.5
 */
function bookproBuildRoute(&$query) {
	$segments = array ();
	
	if (isset ( $query ['view'] )) {
		
		// unset($query['controller']);
		// unset($query['view']);
		if (isset ( $query ['view'] ) == 'bustrips') {
			
			$input = JFactory::getApplication ()->input;
			$from = $input->get ( 'filter_from' );
			$to = $input->get ( 'filter_to' );
			if ($from & $to) {
				$db = JFactory::getDBO ();
				$db->setQuery ('SELECT title FROM #__bookpro_dest WHERE id= '. $from .' UNION SELECT title FROM #__bookpro_dest WHERE id='.$to);
				$result = $db->loadColumn ();
				$str = $result [0] .'-'. $result [1];
				$title = JFilterOutput::stringURLSafe ($str );
				$segments [] = $from . ':' . $to;
				$segments [] = $title;
			}
		}
	}
	return $segments;
	
	
}

/**
 * Parse the segments of a URL.
 *
 * @param
 *        	array	The segments of the URL to parse.
 *        	
 * @return array URL attributes to be used by the application.
 * @since 1.5
 */
function BookproParseRoute($segments) {
	$vars = array ();
	if (count ( $segments ) == 2) {
		//$vars ['view'] = 'bustrips';
		$ids = explode ( ':', $segments [0] );
		$vars ['filter_from'] = ( int ) $ids [0];
		$vars ['filter_to'] = ( int ) $ids [1];
	}
	return $vars;
}

