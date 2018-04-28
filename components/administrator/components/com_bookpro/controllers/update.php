<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: airport.php 66 2012-07-31 23:46:01Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// import needed JoomLIB helpers
jimport ( 'joomla.application.component.controller' );
jimport ( 'joomla.filesystem.file' );
jimport ( 'joomla.filesystem.folder' );
jimport ( 'joomla.filesystem.archive' );
jimport ( 'joomla.filesystem.path' );
class BookProControllerUpdate extends JControllerLegacy {
	function copyFiles($startdir, $subdir = "") {
		if ($subdir != "" && ! file_exists ( JPATH_ROOT . $subdir )) {
			@mkdir ( JPATH_ROOT . $subdir, 0755 );
		}
		
		$files = JFolder::files ( $startdir . $subdir, '', false, false, array (), array () );
		foreach ( $files as $file ) {
			if ($subdir == "" && ($file == "sample.sql" || $file == "update.php" || $file == "checkupdate.php")) {
				continue;
			}
			
			if (@copy ( $startdir . $subdir . "/" . $file, JPATH_ROOT . $subdir . "/" . $file )) {
				// JError::raiseWarning( 500, "Copy file: ".$subdir."/".$file." OK");
			} else {
				JError::raiseWarning ( "", "Copy file: " . $subdir . "/" . $file . " ERROR" );
				saveToLog ( "error.log", "Update - Copy file: " . $subdir . "/" . $file . " ERROR" );
			}
		}
		
		$folders = JFolder::folders ( $startdir . $subdir, '' );
		foreach ( $folders as $folder ) {
			$dir = $subdir . "/" . $folder;
			$this->copyFiles ( $startdir, $dir );
		}
	}
	function update() {
		jimport ( 'joomla.installer.helper' );
		JLog::addLogger ( array (
				'text_file' => 'update.txt',
				'text_file_path' => 'logs' 
		), JLog::ALL );
		$input = JFactory::getApplication ()->input;
		$installtype = $input->get ( 'installtype', '', 'string' );
		if (! extension_loaded ( 'zlib' )) {
			JError::raiseWarning ( 'SOME_ERROR_CODE', JText::_ ( 'COM_INSTALLER_MSG_INSTALL_WARNINSTALLZLIB' ) );
			$this->setRedirect ( "index.php?option=com_bookpro&view=update" );
			return false;
		}
		if ($installtype == 'package') {
			$userfile = $input->get ( 'install_package', null, 'files', 'array' );
			if (! ( bool ) ini_get ( 'file_uploads' )) {
				JError::raiseWarning ( 'SOME_ERROR_CODE', JText::_ ( 'COM_INSTALLER_MSG_INSTALL_WARNINSTALLFILE' ) );
				$this->setRedirect ( "index.php?option=com_bookpro&view=update" );
				return false;
			}
			if (! is_array ( $userfile )) {
				JError::raiseWarning ( 'SOME_ERROR_CODE', JText::_ ( 'No file selected' ) );
				$this->setRedirect ( "index.php?option=com_bookpro&view=update" );
				return false;
			}
			if ($userfile ['error'] || $userfile ['size'] < 1) {
				JError::raiseWarning ( 'SOME_ERROR_CODE', JText::_ ( 'COM_INSTALLER_MSG_INSTALL_WARNINSTALLUPLOADERROR' ) );
				$this->setRedirect ( "index.php?option=com_bookpro&view=update" );
				return false;
			}
			$config = JFactory::getConfig ();
			$tmp_dest = $config->get ( 'tmp_path' ) . '/' . $userfile ['name'];
			$tmp_src = $userfile ['tmp_name'];
			jimport ( 'joomla.filesystem.file' );
			$uploaded = JFile::upload ( $tmp_src, $tmp_dest );
			$archivename = $tmp_dest;
			$tmpdir = uniqid ( 'install_' );
			$extractdir = JPath::clean ( dirname ( $archivename ) . '/' . $tmpdir );
			$archivename = JPath::clean ( $archivename );
		} else {
			jimport ( 'joomla.installer.helper' );
			$url = urldecode($input->get ( 'install_url', '', 'url' ));
		
			if (! $url) {
				JError::raiseWarning ( '', JText::_ ( 'COM_INSTALLER_MSG_INSTALL_ENTER_A_URL' ) );
				$this->setRedirect ( "index.php?option=com_bookpro&view=update" );
				return false;
			}
			$p_file = JInstallerHelper::downloadPackage ( $url );
			
			if (! $p_file) {
				JError::raiseWarning ( '', JText::_ ( 'COM_INSTALLER_MSG_INSTALL_INVALID_URL' ) );
				$this->setRedirect ( "index.php?option=com_bookpro&view=update" );
				return false;
			}
			$config = JFactory::getConfig ();
			$tmp_dest = $config->get ( 'tmp_path' );
			$tmpdir = uniqid ( 'install_' );
			$extractdir = JPath::clean ( dirname ( JPATH_BASE ) . '/tmp/' . $tmpdir );
			$archivename = JPath::clean ( $tmp_dest . '/' . $p_file );
		}
		$ext = JFile::getExt ( strtolower ( $archivename ) );
		
		$result = JArchive::extract ( $archivename, $extractdir );
		
		$mainframe = &JFactory::getApplication ();
		if ($result === false) {
			if (JFile::exists ( $archivename )) {
				$db = JFactory::getDBO ();
				try {
					
					$lines = file ( $url );
				
					$fullline = implode ( " ", $lines );
					$queryes = $db->splitSql ( $fullline );
					$db->transactionStart();
					foreach ( $queryes as $query ) {
						if (trim ( $query ) != '') {
							$db->setQuery ( $query );
							$db->query ();
							if ($db->getErrorNum ()) {
								JError::raiseWarning ( 500, $db->stderr () );
								
								JLog::add ( JText::_ ( 'Update:' ) . $db->stderr (), JLog::DEBUG );
							}
						}
					}
					$db->transactionCommit();
					$mainframe->enqueueMessage ( 'Saved successful' );
					
				} catch ( Exception $e ) {
					$db->transactionRollback();
					JErrorPage::render($e);
					$mainframe->enqueueMessage ( $e->getMessage () );
				}
			}
		}
		
		$this->copyFiles ( $extractdir );
		
		if (file_exists ( $extractdir . "/sample.sql" )) {
			
			$db = JFactory::getDBO ();
			try {
				$db->transactionStart();
				$lines = file ( $extractdir . "/sample.sql" );
				
				
				$fullline = implode ( "", $lines );
				$fullline = implode ( " ", $lines );
				//$db->setQuery($fullline);
				$queryes = $db->splitSql ( $fullline );
				
				
				foreach ( $queryes as $query ) {
					
					if (trim ( $query ) != '') {
						$db->setQuery ( $query );
						
						if ($db->getErrorNum ()) {
							JError::raiseWarning ( 500, $db->stderr () );
						}
					}
				}
				$db->execute();
				$db->transactionCommit();
				$mainframe->enqueueMessage ( 'Saved successful' );
			}catch (Exception $e){
				$db->transactionRollback();
				JErrorPage::render($e);
				$mainframe->enqueueMessage ( $e->getMessage () );
			}
			
		}
		
		JFolder::delete ( $extractdir );
		$this->setRedirect ( 'index.php?option=com_bookpro' );
	}
}

?>