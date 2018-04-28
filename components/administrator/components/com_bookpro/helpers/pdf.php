<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');
define ('K_PATH_IMAGES',JPATH_ROOT.'/');
jimport( 'tcpdf.tcpdf' );
class PrintPdfHelper
{
	
	static function printTicket($ticket_html,$order,$layout='P'){
		
		$config=JComponentHelper::getParams('com_bookpro');
		
		$page_ticket=$ticket_html;
		// create new PDF document
		$pdf = new TCPDF($layout, 'mm', 'A4', true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Joombooking');
		$pdf->SetTitle('Travel Ticket '.$order_number);
		$pdf->SetSubject('Travel Ticket');
		$pdf->SetKeywords('TCPDF, PDF, ticket, travel, booking');
		$pdf->setPrintHeader(false);
		// set default header data
		
		//$pdf->SetHeaderData($config->get('company_logo'),50, $config->get('company_name'), "Ticket \n www.");
		// set header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setHeaderMargin(10);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		//$pdf->SetMargins(30, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		
		// ---------------------------------------------------------
		// set font
		$pdf->SetFont('times', '', 11);
		// add a page
		$pdf->AddPage();
		// set JPEG quality
		$pdf->setJPEGQuality(75);
		
		$style['position'] = 'R';
		/*
		 *     $type type of barcode (see tcpdf_barcodes_1d.php for supported formats).
		 *      
		 */
		$pdf->write1DBarcode($order_number, 'C128B','', '', '', 10, 0.4, $style, 'M');
		
		// create some HTML content
		//$pdf->writeHTML($htmlcontent, true, 0, true, 0);
		//$pdf->WriteHTML(file_get_contents('test.html'));
		$pdf->WriteHTML($page_ticket);
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// reset pointer to the last page
		$pdf->lastPage();
		
		// ---------------------------------------------------------
		//Close and output PDF document
		ob_end_clean();
		$pdf->Output($order->order_number.'.pdf', 'I'); //Should use variable to make file name
		ob_end_flush();
	}
	
}

