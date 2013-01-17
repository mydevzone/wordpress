<?php

/**
 * @file
 *
 * 	iProjectWebUtils class definition
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

/**
 * 	iProjectWebUtils
 *
 * 	A class, handling utility operations
 *
 */
class iProjectWebUtils {

	/**
	 * 	addMSlashes
	 *
	 * 	string escaping
	 *
	 * @param string $string
	 * 	a string to escape
	 *
	 * @return string
	 * 	an escaped string
	 */
	function addMSlashes($string) {

		if (!get_magic_quotes_gpc()) {
			$string = addslashes($string);
		}
		return $string;

	}

	/**
	 * 	stripMSlashes
	 *
	 * 	string unescaping
	 *
	 * @param string $string
	 * 	a string to unescape
	 *
	 * @return string
	 * 	an escaped string
	 */
	function stripMSlashes($string) {

		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		return $string;

	}

	/**
	 * 	getASInput
	 *
	 * 	a function analyzing an incoming request
	 *
	 * @param array $_asmap
	 * 	request data
	 *
	 * @return array
	 * 	an object prepared to be transfered to the client side
	 */
	function getASInput($_asmap) {

		if (!isset($_asmap['query'])) {
			return FALSE;
		}

		$_input = $_asmap['query'];
		if (empty($_input)) {
			return FALSE;
		}

		$_input = preg_replace('#%u([0-9A-F]{4})#se', 'iconv("UTF-16BE","UTF-8", pack("H4","$1"))', $_input);
		$_input = urldecode($_input);

		$_limit	 = isset($_asqmap['limit']) ? $_asqmap['limit'] : '7';
		$_limit = intval($_limit);
		$_limit = ($_limit == 0) ? '' : 'LIMIT 0, ' . $_limit;

		return (object) array('input' => $_input, 'limit' => $_limit);

	}

	/**
	 * 	escapeRequest
	 *
	 * 	Escapes a request
	 *
	 * @param array $_imap
	 * 	request data
	 * @param array $strflds
	 * 	string items
	 * @param array $numflds
	 * 	int items
	 *
	 * @return array
	 * 	escaped request data
	 */
	function escapeRequest($_imap, $strflds = NULL, $numflds = NULL) {

		if ($strflds) {
			foreach ($strflds as $fld) {
				if (isset($_imap[$fld])) {
					$_imap[$fld] = iProjectWebUtils::addMSlashes($_imap[$fld]);
				}
			}
		}

		if ($numflds) {
			foreach ($numflds as $fld) {
				if (isset($_imap[$fld])) {
					$_imap[$fld] = intval($_imap[$fld]);
				}
			}
		}
		return $_imap;

	}

	/**
	 * 	intercept
	 *
	 * 	Checks ACL
	 *
	 * @param array $_imap
	 * 	Request data
	 *
	 * @return array
	 * 	Request data
	 */
	function intercept($_imap) {

		$sm = iProjectWebSecurityManager::getInstance();
		$_imap = $sm->getRights($_imap);
		$viewname = $sm->getViewName($_imap);
		if ((!isset($viewname)) || ($viewname == '')) {
			return NULL;
		}
		$_imap['n'] = $viewname;
		return $_imap;

	}

	/**
	 * 	subStringBefore
	 *
	 * 	a simple function parsing a string and returning a substring before a
	 * 	found symbol
	 *
	 * @param string $string
	 * 	a string to search in
	 * @param string $delimiter
	 * 	a string to find
	 *
	 * @return string
	 * 	the substring
	 */
	function subStringBefore($string, $delimiter) {

		$position = strpos($string, $delimiter);
		if ($position === FALSE) {
			return NULL;
		}
		return substr($string, 0, $position);

	}

	/**
	 * 	subStringAfter
	 *
	 * 	a simple function parsing a string and returning a substring after a
	 * 	found symbol
	 *
	 * @param string $string
	 * 	a string to search in
	 * @param string $delimiter
	 * 	a string to find
	 *
	 * @return string
	 * 	the substring
	 */
	function subStringAfter($string, $delimiter) {

		$position = strpos($string, $delimiter);
		if ($position === FALSE) {
			return NULL;
		}
		return substr($string, $position + strlen($delimiter));

	}

	/**
	 * 	beginsWith
	 *
	 * 	check is a string begins with a defined substring
	 *
	 * @param string $string
	 * 	a string to search in
	 * @param string $beginning
	 * 	a string to find
	 *
	 * @return boolean
	 * 	TRUE if begins and FALSE if does not
	 */
	function beginsWith($string, $beginning) {

		$index = strpos($string, $beginning);
		if ($index === FALSE) {
			return FALSE;
		}
		if ($index == 0) {
			return TRUE;
		}
		return FALSE;

	}

	/**
	 * 	endsWith
	 *
	 * 	check is a string ends with a defined substring
	 *
	 * @param string $string
	 * 	a string to search in
	 * @param string $end
	 * 	a string to find
	 *
	 * @return boolean
	 * 	TRUE if begins and FALSE if does not
	 */
	function endsWith($string, $end) {

		$index = strpos($string, $end);
		if ($index === FALSE) {
			return FALSE;
		}
		if ($index + strlen($end) == strlen($string)) {
			return TRUE;
		}
		return FALSE;

	}

	/**
	 * 	cutPrefix
	 *
	 * 	cuts a prefix
	 *
	 * @param string $string
	 * 	a string to cut
	 * @param string $prefix
	 * 	a prefix
	 *
	 * @return string
	 * 	result
	 */
	function cutPrefix($string, $prefix) {

		if (! iProjectWebUtils::beginsWith($string, $prefix)) {
			return $string;
		}
		return substr($string, strlen($prefix));

	}

	/**
	 * 	convert
	 *
	 * 	Converts data
	 *
	 * @param arbitrary $value
	 * 	a value to convert
	 * @param string $datatype
	 * 	data type name
	 */
	function convert($value, $datatype) {

		if (! isset($value)) {
			return NULL;
		}
		if (is_null($datatype)) {
			return $value;
		}

		switch ($datatype) {

			case 'boolean':
				return ($value == 'on' || $value == '1') ? 1 : 0;

			case 'float':
				return ((1 + $value) - 1);

			case 'int':
				return intval($value);

			case 'date':
				$dvalue = strtotime($value);

				return $dvalue;

		}
		return $value;

	}

	/**
	 * 	parseRequest
	 *
	 * 	prepares an object before update
	 *
	 * @param object $request
	 * 	request values
	 * @param string $field
	 * 	object field name
	 * @param string $datatype
	 * 	data type name
	 */
	function parseRequest($request, $field, $datatype) {

		if (! isset($request->$field)) {
			return $request;
		}
		$request->$field = iProjectWebUtils::convert($request->$field, $datatype);
		return $request;

	}

	/**
	 * 	getDate
	 *
	 * 	returns a formatted date string
	 *
	 * @param int $date
	 * 	time stamp
	 * @param boolean $setcurrent
	 * 	should the function return current data if first argument is null
	 * @param boolean $showtime
	 * 	should the function cut off the time value
	 * @param boolean $datetime
	 * 	should the function return date and time
	 *
	 * @return string
	 * 	formatted date string
	 */
	function getDate($date, $setcurrent = FALSE, $showtime = FALSE, $datetime = FALSE) {

		$empty = 0;

		$format = ( $datetime ) ? IPROJECTWEB_DateTimeFormat : IPROJECTWEB_DateFormat;

		if (( $date == $empty ) || ( !isset($date) )) {
			$datestr = $setcurrent ? date($format) : '';
		}
		else {
			$datestr = date($format, $date);
		}

		if ($datetime && ! $showtime) {
			$datestr = date(IPROJECTWEB_DateTimeFormat, strtotime($datestr));
		};

		return $datestr;

	}

	/**
	 * 	isAssocArray
	 *
	 * 	checks if the argument is assoc array
	 *
	 * @param array $var
	 * 	array to check
	 *
	 * @return boolean
	 * 	TRUE if it is, FALSE if it is not
	 */
	function isAssocArray($var) {

		if ((!is_array($var)) || (!count($var))) {
			return FALSE;
		}
		foreach ($var as $k => $v) {
			if (! is_int($k)) {
				return TRUE;
			}
		}
		return FALSE;

	}

	/**
	 * 	toJs
	 *
	 * 	converts a php data item into js object
	 * 	(c) dr dot slump at cyteknt dot com
	 *
	 * @param arbitrary $var
	 * 	php variable
	 * @param boolean $recursed
	 * 	recursive call flag
	 *
	 * @return string
	 * 	js code
	 */
	function toJs($var, $recursed = FALSE) {

		if (is_null($var) || is_resource($var)) {
			return 'null';
		}
		$js = '';
		if (is_object($var) || iProjectWebUtils::isAssocArray($var)) {
			$props = (array) $var;
			foreach ($props as $k => $v) {
				if (is_int($k)) {
					$k = "idx_$k";
				}
				$js .= $k . ':' . iProjectWebUtils::toJs($v, TRUE) . ',';
			}
			if (count($props)) {
				$js = substr($js, 0, strlen($js) - 1);
			}
			$js = '{' . $js . '}';
			if (! $recursed) {
				$js = "($js)";
			}
		}
		elseif (is_array($var)) {
			foreach ($var as $v) {
				$js .= iProjectWebUtils::toJs($v, TRUE) . ",";
			}
			if (count($var)) {
				$js = substr($js, 0, strlen($js) - 1);
			}
			$js = "[$js]";
		}
		elseif (is_string($var)) {
			$var = str_replace(array('"', "\n", "\r"), array('\\"', '\\n'), stripslashes($var));
			$js = $recursed ? "\"$var\"" : "(new String(\"$var\"))";

		}
		elseif (is_bool($var)) {
			$var = ($var) ? 'TRUE':'FALSE';
			$js = $recursed ? $var : "(new Boolean($var))";

		}
		else {
			$js = $recursed ? $var : "(new Number($var))";
		}
		return $js;

	}

	/**
	 * 	getTypeFormDescription
	 *
	 * 	produces a view header
	 *
	 * @param int $id
	 * 	object id
	 * @param string $type
	 * 	object type
	 * @param string $fields
	 * 	fields to select
	 * @param string $format
	 * 	format to apply
	 * @param string $spanclass
	 * 	span class to apply
	 *
	 * @return string
	 * 	html text
	 */
	function getTypeFormDescription($id, $type, $fields = NULL, $format = NULL, $spanclass = 'formdescription') {

		$fields = isset($fields) ? $fields : 'Description';
		$obj = iProjectWebClassLoader::getObject($type);
		$tablename = $obj->getTableName();
		$query = 'SELECT ' . $fields . ' FROM ' . $tablename . ' WHERE id = %d';
		return iProjectWebUtils::getFormDescription($id, $query, $format, $spanclass);

	}

	/**
	 * 	getFormDescription
	 *
	 * 	Returns a page header
	 *
	 * @param int $id
	 * 	object id
	 * @param string $query
	 * 	query to execute
	 * @param string $format
	 * 	format to apply
	 * @param string $spanclass
	 * 	span class to apply
	 *
	 * @return string
	 * 	html text
	 */
	function getFormDescription($id, $query, $format = NULL, $spanclass = NULL) {

		$query = sprintf($query, $id);
		$result = iProjectWebDB::getObjects($query);
		$result = (array) $result[0];
		if (!isset($format)) {
			$format = array();
			foreach ($result as $item) {
				$format[] = '%s';
			}
			$format = implode('&nbsp;', $format);
		}
		$text = vsprintf($format, $result);
		$spanclass = isset($spanclass) ? " class = '$spanclass'" : '' ;
		return "<span$spanclass>$text</span>";

	}

	/**
	 * 	getViewDescriptionLabel
	 *
	 * 	return a view header
	 *
	 * @param string $resid
	 * 	constant name
	 *
	 * @return string
	 * 	html text
	 */
	function getViewDescriptionLabel($resid) {

		return "<span class = 'formdescriptionspec'>" . $resid . "</span>";

	}

	/**
	 * 	vImplode
	 *
	 * 	a custom implode function
	 *
	 * @param string $glue
	 * 	a glue
	 * @param array $array
	 * 	the array of values to implode
	 *
	 * @return string
	 * 	a joined string
	 */
	function vImplode($glue, $array) {

		$result = '';
		foreach ($array as $item) {
			if (empty($item)) {
				continue;
			}
			$delim = empty($result) ? '' : $glue;
			$result .= $delim . trim($item, "$glue");
		}
		return $result;

	}

	/**
	 * 	createFolder
	 *
	 * 	creates a folder
	 *
	 * @param string $targdir
	 * 	a folder to created
	 */
	function createFolder($targdir) {

		$ds = DIRECTORY_SEPARATOR;
		$dirs = explode($ds, $targdir);
		$path = '';
		foreach ($dirs as $subdir) {
			$path .= $subdir . '/';
			if (!is_dir($path)) {
				if (!mkdir($path)) {
					echo IPROJECTWEB_ImpossibleToPerformOperation;
					return FALSE;
				}
				if (!$handle = fopen($path . 'index.html', 'w')) {
					echo 'Cannot open file (' . $path . 'index.html)';
					return FALSE;
				}
				if (fwrite($handle, '<body></body>') === FALSE) {
					echo 'Cannot write to file (' . $path . 'index.html)';
					return FALSE;
				}
				fclose($handle);
			}
		}

	}

	/**
	 * 	hasMoreFiles
	 *
	 * 	checks if a folder has files
	 *
	 * @param string $targdir
	 * 	the folder to check
	 * @param array $exceptions
	 * 	a list of files to ignore. for example, index.html
	 *
	 * @return boolean
	 * 	TRUE if it does, FALSE if it does not
	 */
	function hasMoreFiles($targdir, $exceptions) {

		if ($handle = opendir($targdir)) {
			while (FALSE !== ($file = readdir($handle))) {
				if ($file == '.') {
					continue;
				}
				if ($file == '..') {
					continue;
				}
				if (in_array($file, $exceptions)) {
					continue;
				}
				closedir($handle);
				return TRUE;
			}
			closedir($handle);
		}
		return FALSE;

	}

	/**
	 * 	getHelpLink
	 *
	 * 	returns a help link
	 *
	 * @param string $type
	 * 	An object to show the help for
	 *
	 * @return string
	 * 	the link
	 */
	function getHelpLink($type) {

		$link = IPROJECTWEB__helpRoot;
		$link .= '/help.php?pr=iproject';
		$link .= '&v='. IPROJECTWEB__prodVersion;
		$link .= '&prod=iproject';
		$link .= '&o=' . $type;
		$link = 'window.open("' . $link . '")';
		return $link;

	}

}
