<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class BookProHelper {
	
	/**
	 * Helper to render layout
	 * 
	 * @param unknown $name        	
	 * @param unknown $data        	
	 * @param string $path        	
	 * @return string
	 */
	static function getOrderLink($order_number,$email){
		return JURI::root () . 'index.php?option=com_bookpro&view=orderdetail&email='.$email.'&order_number=' . $order_number;
	}
	static function renderLayout($name, $data, $path = '/components/com_bookpro/layouts') {
		$path = JPATH_ROOT . $path;
		return JLayoutHelper::render ( $name, $data, $path );
	}
	static function isAgent() {
		$checked = false;
		$user = JFactory::getUser ();
		if (JComponentHelper::getParams ( 'com_bookpro' )->get ( 'agent_usergroup' ) && $user->groups) {
			if (in_array ( JComponentHelper::getParams ( 'com_bookpro' )->get ( 'agent_usergroup' ), $user->groups )) {
				$checked = true;
			}
		}
		
		return $checked;
	}
	static function getCustomerGroupSelect($selected) {
		$config = JComponentHelper::getParams ( 'com_bookpro' );
		$agent_group = $config->get ( 'agent_usergroup' );
		$option [] = JHtml::_ ( 'select.option', 0, JText::_ ( "COM_BOOKPRO_SELECT_CUSTOMER_GROUP" ) );
		$option [] = JHtml::_ ( 'select.option', $agent_group, JText::_ ( "COM_BOOKPRO_AGENT" ) );
		$option [] = JHtml::_ ( 'select.option', - 1, JText::_ ( "COM_BOOKPRO_GUEST" ) );
		
		return JHtml::_ ( 'select.genericlist', $option, 'filter_group_id', 'class="input input-medium" id="filter_group_id"', 'value', 'text', $selected );
	}
	static function getRangeSelect($selected) {
		$option [] = JHtml::_ ( 'select.option', 0, JText::_ ( "COM_BOOKPRO_QUICK_FILTER_DATE" ) );
		$option [] = JHtml::_ ( 'select.option', 'today', JText::_ ( "COM_BOOKPRO_TODAY" ) );
		$option [] = JHtml::_ ( 'select.option', 'past_week', JText::_ ( "COM_BOOKPRO_LAST_WEEK" ) );
		$option [] = JHtml::_ ( 'select.option', 'past_1month', JText::_ ( "COM_BOOKPRO_LAST_MONTH" ) );
		return JHtml::_ ( 'select.genericlist', $option, 'filter_range', 'class="input input-medium"', 'value', 'text', $selected );
	}
	static function setSubmenu($set= null) {
		AImporter::helper ('adminui');
		AdminUIHelper::startAdminArea ($set);
		
	}
	static function getCountrySelect($select) {
		$model = new BookProModelCountries ();
		$state = $model->getState ();
		$state->set ( 'list.start', 0 );
		$state->set ( 'list.limit', 0 );
		$fullList = $model->getItems ();
		return AHtml::getFilterSelect ( 'country_id', JText::_ ( 'COM_BOOKPRO_SELECT_COUNTRY' ), $fullList, $select, true, '', 'id', 'country_name' );
	}
	static function formatAge($age) {
		switch ($age) {
			case 1 :
				return JText::_ ( 'COM_BOOKPRO_ADULT' );
				break;
			case 2 :
				return JText::_ ( 'COM_BOOKPRO_CHILDREN' );
				break;
			case 3 :
				return JText::_ ( 'COM_BOOKPRO_INFANT' );
				break;
		}
	}
	
	
	
	static function getGender() {
		return array (
				array (
						'value' => 'M',
						'text' => JText::_ ( 'COM_BOOKPRO_MALE' ) 
				),
				array (
						'value' => 'F',
						'text' => JText::_ ( 'COM_BOOKPRO_FEMALE' ) 
				) 
		);
	}
	static function getGenderSelect($selected) {
		$data = array (
				array (
						'value' => 'M',
						'text' => JText::_ ( 'COM_BOOKPRO_MALE' ) 
				),
				array (
						'value' => 'F',
						'text' => JText::_ ( 'COM_BOOKPRO_FEMALE' ) 
				) 
		);
		return JHtml::_ ( 'select.genericlist', $data, 'psform[gender][]', 'class="input input-small"', 'value', 'text', 1 );
	}
	static function formatGender($value) {
		if ($value == "M") {
			return JText::_ ( 'COM_BOOKPRO_MALE' );
		} else if ($value == "F") {
			return JText::_ ( 'COM_BOOKPRO_FEMALE' );
		} else
			return 'N/A';
	}
	static function getAge() {
		return array (
				array (
						'value' => 1,
						'text' => JText::_ ( 'COM_BOOKPRO_ADULT' ) 
				),
				array (
						'value' => 0,
						'text' => JText::_ ( 'COM_BOOKPRO_CHILDREN' ) 
				),
				array (
						'value' => 2,
						'text' => JText::_ ( 'INFANT' ) 
				) 
		);
	}
	
	static function getCountryList($name, $select, $att = '', $ordering = "id") {
		if (! class_exists ( 'BookProModelCountries' )) {
			AImporter::model ( 'countries' );
		}
		$model = new BookProModelCountries ();
		
		$state = $model->getState ();
		$state->set ( 'list.order', $ordering );
		$state->set ( 'list.order_dir', 'ASC' );
		$state->set ( 'list.limit', NULL );
		
		$fullList = $model->getItems ();
		
		return AHtml::getFilterSelect ( $name, JText::_ ( "COM_BOOKPRO_SELECT_COUNTRY" ), $fullList, $select, false, $att, 'id', 'country_name' );
	}
	static function getGroupList($name, $select = 0, $att = '', $ordering = "id") {
		$db = JFactory::getDbo ();
		
		$query = $db->getQuery ( true );
		$query->select ( '*' )->from ( '#__bookpro_cgroup' )->order ( 'id ASC' );
		$db->setQuery ( $query );
		$list = $db->loadObjectList ();
		
		return JHtml::_ ( 'select.genericlist', $list, $name, $att, 'id', 'title', $select );
	}
	static function getOrderStatusList($name, $select = 0, $att = '') {
		AImporter::helper ( 'orderstatus' );
		OrderStatus::init ();
		return JHtml::_ ( 'select.genericlist', OrderStatus::$map, $name, $att, 'value', 'text', $select );
	}
	static function displayPaymentStatus($value) {
		return JText::_ ( 'COM_BOOKPRO_PAYMENT_STATUS_' . strtoupper ( $value ) );
	}
	static function displayOrderStatus($value) {
		return JText::_ ( 'COM_BOOKPRO_ORDER_STATUS_' . strtoupper ( $value ) );
	}
	
	
	/**
	 * Clean code from SUP tag.
	 *
	 * @param string $code        	
	 * @return string cleaned code
	 */
	static function cleanSupTag($code) {
		$code = str_replace ( array (
				'<sup>',
				'</sup>' 
		), '', $code );
		return $code;
	}
	
	
	
	
	static function formatName($person, $safe = false) {
		$parts = array ();
		
		$person->firstname = JString::trim ( $person->firstname );
		$person->lastname = JString::trim ( $person->lastname );
		
		if ($person->firstname) {
			$parts [] = $person->firstname;
		}
		if ($person->lastname) {
			$parts [] = $person->lastname;
		}
		
		$name = JString::trim ( implode ( ' ', $parts ) );
		if ($safe) {
			$name = htmlspecialchars ( $name, ENT_QUOTES, ENCODING );
		}
		return $name;
	}
	function formatPassengerName(&$flight, $safe = false) {
		$parts = array ();
		
		$flight->desto = JString::trim ( $person->firstname );
		$flight->lastname = JString::trim ( $person->lastname );
		
		if ($person->firstname) {
			$parts [] = $person->firstname;
		}
		if ($person->lastname) {
			$parts [] = $person->lastname;
		}
		
		$name = JString::trim ( implode ( ' ', $parts ) );
		if ($safe) {
			$name = htmlspecialchars ( $name, ENT_QUOTES, ENCODING );
		}
		return $name;
	}
	
	/**
	 * Format person adrress
	 *
	 * @param TableCustomer $person        	
	 * @return string HTML code
	 */
	function formatAdrress(&$person) {
		$parts = array ();
		$person->city = JString::trim ( $person->city );
		$person->street = JString::trim ( $person->street );
		$person->zip = JString::trim ( $person->zip );
		$person->country = JString::trim ( $person->country );
		if ($person->country) {
			$parts [] = $person->country;
		}
		if ($person->city) {
			$parts [] = $person->city;
		}
		if ($person->street) {
			$parts [] = $person->street;
		}
		if ($person->zip) {
			$parts [] = $person->zip;
		}
		return JString::trim ( implode ( ', ', $parts ) );
	}
	
	/**
	 * Get email link
	 *
	 * @param TableCustomer $person        	
	 * @param boolean $link
	 *        	display as link, default true
	 * @return string HTML code
	 */
	function getEmailLink(&$person, $link = true) {
		$person->email = JString::trim ( $person->email );
		if ($person->email) {
			return $link ? '<a href="mailto:' . $person->email . '" title="' . JText::_ ( 'Send email' ) . '">' . $person->email . '</a>' : $person->email;
		}
		return '';
	}
	function getIconEmail(&$person) {
		$email = JString::trim ( $person->email );
		if ($email) {
			return '<a href="mailto:' . $email . '" class="aIcon aIconEmail" title=""></a>';
		}
		return '';
	}
	static function getNameObjectType($documenttype = 0) {
		$objects = explode ( ';', JText::_ ( 'COM_BOOKPRO_PASSENGER_OBJECTTYPES' ) );
		for($i = 0; $i < count ( $objects ); $i ++) {
			$object = explode ( ':', $objects [$i] );
			if ($documenttype == $object [0])
				return JText::_ ( COM_BOOKPRO_PASSENGER_DOCTYPE . '_' . $doctype [1] );
		}
	}
	static function getBlockObjectTypes($name, $selected = null, $attr = '', $text = '') {
		$pgroups = explode ( ';', $text != '' ? $text : JText::_ ( 'COM_BOOKPRO_BLOCK_OBJECTTYPES' ) );
		
		$result = array ();
		for($i = 0; $i < count ( $pgroups ); $i ++) {
			$tmp = explode ( ':', $pgroups [$i] );
			$obj = new stdClass ();
			$obj->value = $tmp [0];
			$obj->text = JText::_ ( 'COM_BOOKPRO_BLOCK_OBJECTTYPE_' . $tmp [1] );
			$result [] = $obj;
		}
		
		return JHtml::_ ( 'select.genericlist', $result, $name, $attr, 'value', 'text', $selected );
	}
	static function getPassengerDocTypes($name, $selected = null, $attr = '', $text = '') {
		$pgroups = explode ( ';', $text != '' ? $text : JText::_ ( 'COM_BOOKPRO_PASSENGER_DOCTYPES' ) );
		
		$result = array ();
		
		$obj = new stdClass ();
		$obj->value = null;
		$obj->text = JText::_ ( "COM_BOOKPRO_PASSENGER_SELECT_DOCTYPE" );
		$result [] = $obj;
		
		for($i = 0; $i < count ( $pgroups ); $i ++) {
			$tmp = explode ( ':', $pgroups [$i] );
			$obj = new stdClass ();
			$obj->value = $tmp [0];
			$obj->text = JText::_ ( 'COM_BOOKPRO_PASSENGER_DOCTYPE_' . $tmp [1] );
			$result [] = $obj;
		}
		return JHtml::_ ( 'select.genericlist', $result, $name, $attr, 'value', 'text', $selected );
		
		// return AHtml::getFilterSelect($name, JText::_("COM_BOOKPRO_PASSENGER_SELECT_DOCTYPE"), $result, $selected, false,$attr, 'value', 'text');
	}
	static function getNameDocumentType($documenttype = 0) {
		$doctypes = explode ( ';', JText::_ ( 'COM_BOOKPRO_PASSENGER_DOCTYPES' ) );
		
		for($i = 0; $i < count ( $doctypes ); $i ++) {
			$doctype = explode ( ':', $doctypes [$i] );
			if ($documenttype == $doctype [0])
				return JText::_ ( COM_BOOKPRO_PASSENGER_DOCTYPE . '_' . $doctype [1] );
		}
	}
	
	/**
	 * Get time zone offset from Joomla! configuration in seconds.
	 *
	 * @return int
	 */
	function getTZOffset($inSeconds = true) {
		$mainframe = &JFactory::getApplication ();
		/* @var $mainframe JApplication */
		$tzoffset = $mainframe->getCfg ( 'offset' );
		
		$dateTimeZone = new DateTimeZone ( $tzoffset );
		$dateTime = new DateTime ( 'now', $dateTimeZone );
		$tzoffset = $dateTimeZone->getOffset ( $dateTime );
		if (! $inSeconds)
			$tzoffset /= 60 / 60;
		else
			$inSeconds = false;
		
		if ($inSeconds)
			$tzoffset *= 60 * 60;
		return $tzoffset;
	}
	
	/**
	 * Convert date into given format with given time zone offset.
	 *
	 * @param $date string
	 *        	date to convert
	 * @param $format string
	 *        	datetime format
	 * @param $tzoffset int
	 *        	time zone offset
	 * @return BookingDate
	 */
	function convertDate($date, $format = 'Y-m-d H:i:s', $tzoffset = 0) {
		static $cache;
		$key = $date . $format . $tzoffset;
		if (! isset ( $cache [$key] )) {
			$output = new BookingDate ();
			$output->orig = $date;
			$output->uts = strtotime ( $date );
			$output->dts = date ( $format, $output->uts );
			$output->uts = strtotime ( $output->dts ) - $tzoffset;
			$output->dts = date ( 'Y-m-d H:i:s', $output->uts );
			$cache [$key] = $output;
		}
		return $cache [$key];
	}
	
	/**
	 * Get difference between two dates in days count.
	 *
	 * @param $dateEnd BookingDate        	
	 * @param $dateStart BookingDate        	
	 * @return int
	 */
	function getCountDays(&$dateEnd, &$dateStart) {
		$difference = $dateEnd->uts - $dateStart->uts;
		$countDays = $difference ? round ( $difference / DAY_LENGTH ) : 1;
		return $countDays;
	}
	
	/**
	 * Get unix time stamp of date with given time zone offset.
	 *
	 * @param $date string        	
	 * @param $tzoffset int        	
	 * @return int
	 */
	function getUts($date, $tzoffset = 0) {
		$uts = strtotime ( $date ) + $tzoffset;
		return $uts;
	}
	
	/**
	 * Get date from start date by given offset (days count).
	 * For example: start date 01-01-2010 and offset 4, return 05-01-2010.
	 *
	 * @param $date string        	
	 * @param $offset int        	
	 * @return string
	 */
	function getDateFromStartByOffset($date, $offset) {
		$date = date ( 'Y-m-d', strtotime ( $date . ' + ' . $offset . ' days' ) );
		return $date;
	}
	
	/**
	 * Get week code by given unix time stamp.
	 *
	 * @param $uts int        	
	 * @return string
	 */
	function getWeekCodeByUts($uts) {
		$week = date ( 'N', $uts );
		return $week;
	}
	function timeToFloat($time, $tzoffset = 0) {
		$unixTimeOffset = ($unixTime = strtotime ( $time )) + $tzoffset;
		$timeToFloat = round ( date ( 'G', $unixTimeOffset ) + date ( 'i', $unixTimeOffset ) / 60, 2 );
		if (date ( 'H:i:s', $unixTimeOffset ) < date ( 'H:i:s', $unixTime ))
			$timeToFloat += 24;
		return $timeToFloat;
	}
	
	/**
	 * Convert float value to MySQL time value.
	 *
	 * @param float $value        	
	 * @return string
	 */
	function floatToTime($value) {
		if (($hour = floor ( $value )) < 10)
			$hour = '0' . $hour;
		if (($minute = round ( ($value - $hour) * 60 )) < 10)
			$minute = '0' . $minute;
		return $hour . ':' . $minute;
	}
	
	/**
	 * Display time without zero minutes value.
	 *
	 * @param string $time
	 *        	in format HH:MM
	 * @return string for example: if value = 12:00 return 12
	 */
	function displayTime($time) {
		// return ($time[3] . $time[4]) == '00' ? ($time[0] . $time[1]) : $time;
		return $time;
	}
	
	
	
	
	/**
	 * Get absolute path to directory with image.
	 *
	 * @param $image add
	 *        	into path image name
	 * @return string
	 */
	function getIPath($image = null) {
		static $ipath;
		if (empty ( $ipath )) {
			$config = &AFactory::getConfig ();
			$ipath = $config->images;
			$ipath = AImage::getIPath ( $ipath );
			if (! file_exists ( $ipath )) {
				@mkdir ( $ipath, 0775, true );
			}
		}
		return is_null ( $image ) ? $ipath : ($ipath . $image);
	}
	
	/**
	 * Get relative path to directory with image.
	 *
	 * @param $image add
	 *        	into path image name
	 * @return string
	 */
	function getRIPath($image) {
		$params = &JComponentHelper::getParams ( OPTION );
		/* @var $params JParameter */
		$ripath = $params->getValue ( 'images', 'images/bookpro' );
		$ripath = AImage::getRIPath ( $ripath ) . $image;
		return $ripath;
	}
	
	/**
	 * Number into database format.
	 * For example: 4 return like 04
	 *
	 * @param $number int        	
	 * @return string
	 */
	function intToDBFormat($number) {
		$number = ( int ) $number;
		if ($number < 10) {
			$number = '0' . $number;
		}
		return $number;
	}
	
	
	
	/**
	 * Save if user wiev subject into browser cookies.
	 *
	 * @param $id subject
	 *        	id
	 * @param $model BookingModelSubject
	 *        	model to store hits into database
	 */
	function setSubjectHits($id, &$model) {
		$param = OPTION . '_subject';
		if (! isset ( $_COOKIE [$param] [$id] )) {
			$model->incrementHits ( $id );
			$juri = &JURI::getInstance ();
			setcookie ( $param . '[' . $id . ']', $id, time () + YEAR_LENGTH, '/', $juri->getHost () );
		}
	}
	
	
	
	
	function getEmailMode($emailMode) {
		$emailMode = $emailMode != PLAIN_TEXT;
		return $emailMode;
	}
	
	/**
	 * Convert HTML code to plain text.
	 * Paragraphs (tag <p>) and
	 * break line (tag <br/>) replace by end line sign (\n or \r\n)
	 * and remove all others HTML tags.
	 *
	 * @param $string to
	 *        	convert
	 * @return $string converted to plain text
	 */
	function html2text($string) {
		$string = str_replace ( '</p>', '</p>' . PHP_EOL, $string );
		$string = str_replace ( '<br />', PHP_EOL, $string );
		$string = strip_tags ( $string );
		
		return $string;
	}
	function getFileThumbnail($filename) {
		$ext = strtolower ( JFile::getExt ( $filename ) );
		
		// icons taken from JoomDOC
		$icons = array ();
		$icons ['32-pdf.png'] = array (
				'pdf' 
		);
		$icons ['32-ai-eps-jpg-gif-png.png'] = array (
				'ai',
				'eps',
				'jpg',
				'jpeg',
				'gif',
				'png',
				'bmp' 
		);
		$icons ['32-xls-xlsx-csv.png'] = array (
				'xls',
				'xlsx',
				'csv' 
		);
		$icons ['32-ppt-pptx.png'] = array (
				'ppt',
				'pptx' 
		);
		$icons ['32-doc-rtf-docx.png'] = array (
				'doc',
				'rtf',
				'docx' 
		);
		$icons ['32-mpeg-avi-wav-ogg-mp3.png'] = array (
				'mpeg',
				'avi',
				'ogg',
				'mp3' 
		);
		$icons ['32-tar-gzip-zip-rar.png'] = array (
				'tar',
				'gzip',
				'zip',
				'rar' 
		);
		$icons ['32-mov.png'] = array (
				'mov' 
		);
		$icons ['32-fla'] = array (
				'fla' 
		);
		$icons ['32-fw'] = array (
				'fw' 
		);
		$icons ['32-indd.png'] = array (
				'indd' 
		);
		$icons ['32-mdb-ade-mda-mde-mdp.png'] = array (
				'mdb',
				'ade',
				'mda',
				'mde',
				'mdp' 
		);
		$icons ['32-psd.png'] = array (
				'psd' 
		);
		$icons ['32-pub.png'] = array (
				'pub' 
		);
		$icons ['32-swf.png'] = array (
				'swf' 
		);
		$icons ['32-asp-php-js-asp-css.png'] = array (
				'asp',
				'php',
				'js',
				'css' 
		);
		
		foreach ( $icons as $icon => $extension )
			if (in_array ( $ext, $extension )) {
				$thumb = $icon;
				break;
			}
		
		if (! isset ( $thumb ))
			$thumb = '32-default.png';
		
		return IMAGES . 'icons_file/' . $thumb;
	}
	
	
	/**
	 *
	 * @param string $from        	
	 * @param string $fromname        	
	 * @param string $email        	
	 * @param string $subject        	
	 * @param string $body        	
	 * @param boolean $htmlMode        	
	 * @return boolean
	 */
	static function sendMail($from, $fromname, $email, $subject, $body, $htmlMode) {
		if (! $htmlMode)
			$body = BookProHelper::html2text ( $body );
		
		if (is_array ( ($froms = explode ( ',', str_replace ( ';', ',', $from ) )) ) && count ( $froms ))
			$from = reset ( $froms );
		else {
			$mainframe = &JFactory::getApplication ();
			/* @var $mainframe JApplication */
			$from = $mainframe->getCfg ( 'mailfrom' );
		}
		if (is_array ( ($emails = explode ( ',', str_replace ( ';', ',', $email ) )) )) {
			$mail = JFactory::getMailer ();
			/* @var $mail JMail */
			foreach ( $emails as $email ) {
				$mail->sendMail ( $from, $fromname, $email, $subject, $body, $htmlMode, null, null, null );
			}
		}
	}
	public static function getActions() {
		$user = JFactory::getUser ();
		$result = new JObject ();
		
		$assetName = 'com_bookpro';
		
		$actions = array (
				'core.admin',
				'core.manage',
				'core.create',
				'core.edit',
				'core.edit.own',
				'core.edit.state',
				'core.delete' 
		);
		
		foreach ( $actions as $action ) {
			$result->set ( $action, $user->authorise ( $action, $assetName ) );
		}
		
		return $result;
	}
	
	static function addJqueryValidate(){
		$lang=JFactory::getLanguage();
		$local=substr($lang->getTag(),0,2);
	
		$document = JFactory::getDocument();
		$document->addScript("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js");
		if($local !='en'){
			$document->addScript("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/localization/messages_".$local.".js");
		}
		$document->addScript("http://jqueryvalidation.org/files/dist/additional-methods.min.js");
	
	}
}

?>
