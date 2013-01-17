<?php

/**
 * @file
 *
 * 	iProjectWebFiles class definition
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

require_once 'iprojectweb_baseclass.php';

/**
 * 	iProjectWebFiles
 *
 */
class iProjectWebFiles extends iProjectWebBase {

	/**
	 * 	iProjectWebFiles class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'Files';

		$this->fieldmap = array(
				'id' => NULL,
				'Doctype' => '',
				'Docfield' => '',
				'Docid' => 0,
				'Name' => '',
				'Type' => '',
				'Size' => 0,
				'Protected' => 0,
				'Webdir' => 0,
				'Count' => 0,
				'Storagename' => '',
				'ObjectOwner' => 0,
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a file record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		iProjectWebFiles::deletefile($id);

		$stmts[] = "DELETE FROM #wp__iprojectweb_files WHERE id=$id;";

		return $stmts;

	}

	/**
	 * 	update. Overrides iProjectWebBase::update()
	 *
	 * 	updates an object with request data
	 *
	 * @param array $request
	 * 	request data
	 * @param int $id
	 * 	object id
	 */
	function update($request, $id) {

		$request = iProjectWebUtils::parseRequest($request, 'Docid', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Size', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Protected', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Webdir', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Count', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'ObjectOwner', 'int');

		parent::update($request, $id);

	}

	/**
	 * 	deletedocfile
	 *
	 * 	deletes a file accosiated with a particular object
	 *
	 * @param array $map
	 * 	request data
	 */
	function deletedocfile($map) {

		$values = array();
		$values[':docid'] = intval($map['oid']);
		$values[':docfield'] = $map['fld'];
		$values[':doctype'] = $map['t'];

		$query = "SELECT
				id
			FROM
				#wp__iprojectweb_files
			WHERE
				Docid=:docid
				AND Docfield=:docfield
				AND Doctype=:doctype";

		$fileid = iProjectWebDB::select($query, array('fvalues' => $values));
		if (count($fileid) == 0) {
			return;
		}
		$fileid = $fileid[0]->id;
		iProjectWebFiles::deletefile($fileid);
		$query = "DELETE FROM #wp__iprojectweb_files WHERE id='$fileid';";
		iProjectWebDB::query($query);

	}

	/**
	 * 	deletefile
	 *
	 * 	deletes a file
	 *
	 * @param int $id
	 * 	file id
	 */
	function deletefile($id) {

		$query = "SELECT
				Doctype,
				Storagename,
				Docfield,
				Docid,
				Webdir,
				Protected
			FROM
				#wp__iprojectweb_files
			WHERE
				id='$id'";

		$filespec = iProjectWebDB::getObjects($query);
		if (count($filespec) == 0) {
			return;
		}
		$webdir = $filespec[0]->Webdir;
		if ($webdir) {
			iProjectWebFiles::deletedirfile($filespec);
		}
		else {
			iProjectWebFiles::deletepfile($filespec);
		}

	}

	/**
	 * 	deletepfile
	 *
	 * 	deletes a regular file
	 *
	 * @param object $filespec
	 * 	file data
	 */
	function deletepfile($filespec) {

		$ds = DIRECTORY_SEPARATOR;
		$storagename = $filespec[0]->Storagename;
		$filedir = IPROJECTWEB__fileUploadDir;
		$filepath = $filedir . $ds . $storagename;
		if (is_file($filepath)) {
			unlink($filepath);
		}

	}

	/**
	 * 	deletedirfile
	 *
	 * 	deletes a file from a web directory
	 *
	 * @param object $filespec
	 * 	file data
	 */
	function deletedirfile($filespec) {

		$ds = DIRECTORY_SEPARATOR;
		$filepath
			= IPROJECTWEB__fileUploadDir . $ds .
			$filespec[0]->Doctype . $ds .
			$filespec[0]->Docid . $ds .
			$filespec[0]->Docfield . $ds .
			$filespec[0]->Storagename;

		if (is_file($filepath)) {
			unlink($filepath);
		}

		$dir
			= IPROJECTWEB__fileUploadDir . $ds .
			$filespec[0]->Doctype . $ds .
			$filespec[0]->Docid . $ds .
			$filespec[0]->Docfield . $ds .

		$filepath = $dir . $ds . 'index.html';
		if (is_file($filepath)) {
			unlink($filepath);
		}
		if (is_dir($dir)) {
			@rmdir($dir);
		}

		$dir
			= IPROJECTWEB__fileUploadDir . $ds .
			$filespec[0]->Doctype . $ds .
			$filespec[0]->Docid;

		if (iProjectWebUtils::hasMoreFiles($dir, array('index.html'))) {
			return;
		}

		$filepath = $dir . $ds . 'index.html';
		if (is_file($filepath)) {
			unlink($filepath);
		}
		if (is_dir($dir)) {
			@rmdir($dir);
		}

	}

	/**
	 * 	getFileValue
	 *
	 * 	check if a file associated with an object exists, and returns a
	 * 	selected value
	 *
	 * @param string $field
	 * 	field name
	 * @param string $docfield
	 * 	file field name
	 * @param object $obj
	 * 	object
	 *
	 * @return arbitrary
	 * 	the selected value
	 */
	function getFileValue($field, $docfield, $obj) {

		$query = "SELECT $field FROM #wp__iprojectweb_files WHERE Doctype='" . $obj->type . "' AND Docfield='$docfield' AND Docid='" . $obj->getId() . "'";

		return iProjectWebDB::getValue($query);

	}

	/**
	 * 	fileNotFound
	 *
	 * 	prints a 'file not found' message
	 *
	 * @param array $_map
	 * 	request data
	 */
	function fileNotFound($_map) {

		echo iProjectWebIHTML::showMessage(
			IPROJECTWEB_FileNotFoundInDownloads,
			'warningMessage');
		exit;

	}

	/**
	 * 	download
	 *
	 * 	file download
	 *
	 * @param array $_map
	 * 	request data
	 */
	function download($_map) {

		$id = '';
		$query = '';
		if (isset($_map['oid'])) {
			$id = intval($_map['oid']);
			$query = 'SELECT * FROM #wp__iprojectweb_files WHERE id=\'' . $id . '\' AND Webdir=FALSE';
		}

		$token = isset($_map['token']) ? $_map['token'] : '' ;
		$md5 = md5(iProjectWebSecurityManager::getServerPwd() . session_id() . $id);
		if ($md5 != $token) {
			iProjectWebFiles::fileNotFound($_map);
		}

		$response = iProjectWebDB::getObjects($query);
		if ((iProjectWebDB::err()) || (count($response) == 0)) {
				iProjectWebFiles::fileNotFound($_map);
		}

		$ds = DIRECTORY_SEPARATOR;
		$downloaddir = IPROJECTWEB__fileUploadDir;

		$Count = intval($response[0]->Count);
		$Size = $response[0]->Size;
		$Type = $response[0]->Type;
		$Name = $response[0]->Name;
		$filepath = $downloaddir . $ds . $response[0]->Storagename;
		if (!is_file($filepath)) {
			iProjectWebFiles::fileNotFound($_map);
		}
		header("Content-length: $Size");
		header("Content-type: $Type");
		header("Content-Disposition: attachment; filename=$Name");
		readfile($filepath);
		$valuemap = array();
		$valuemap['Count'] = ++$Count;
		iProjectWebDB::update($valuemap, 'Files', $response[0]->id);
		exit;

	}

	/**
	 * 	getFileDownloadLink
	 *
	 * 	builds a file download link
	 *
	 * @param string $doctype
	 * 	object type
	 * @param string $docfield
	 * 	object field
	 * @param int $docid
	 * 	object id
	 *
	 * @return string
	 * 	file uri
	 */
	function getFileDownloadLink($doctype, $docfield, $docid) {

		$query = "SELECT
				id,
				Name,
				Webdir
			FROM
				#wp__iprojectweb_files
			WHERE
				Docid='$docid'
				AND Docfield='$docfield'
				AND Doctype='$doctype'";

		$filedata = iProjectWebDB::getObjects($query);
		if (sizeof($filedata) == 0) {
			return FALSE;
		}
		$filedata = $filedata[0];
		$ds = DIRECTORY_SEPARATOR;
		if ($filedata->Webdir) {
			return IPROJECTWEB__engineWebAppDirectory . '/' .
			IPROJECTWEB__fileFolder . '/' .
			$doctype . '/' .
			$docid . '/' .
			$docfield . '/' .
			$filedata->Name;
		}
		else {
			$md5 = md5(iProjectWebSecurityManager::getServerPwd() . session_id() . $filedata->id);
			return IPROJECTWEB__engineRoot .
				'&m=download&oid=' . $filedata->id . '&token=' . $md5;
		}

	}

	/**
	 * 	upload
	 *
	 * 	uploads a file
	 *
	 * @param array $_uldmap
	 * 	request data
	 */
	function upload($_uldmap) {

		if (isset($_uldmap["webdirupload"]) && $_uldmap["webdirupload"] == "on") {
			iProjectWebFiles::webdirUpload($_uldmap);
		}
		else {
			iProjectWebFiles::protectedUpload($_uldmap);
		}

	}

	/**
	 * 	protectedUpload
	 *
	 * 	takes a file from a temporary folder and registers it in the file
	 * 	manager
	 *
	 * @param array $_uldmap
	 * 	request data
	 */
	function protectedUpload($_uldmap) {

		$filerequestid
			= $_uldmap['t'] . '_' .
			$_uldmap['fld'] . '_' .
			$_uldmap['oid'];

		if ($_FILES[$filerequestid]['error'] != UPLOAD_ERR_OK) {
			return FALSE;
		}

		$protect = 0;
		if (isset($_uldmap['protect'])) {
			$protect = ($_uldmap['protect'] == "on") ? 1 : 0;
		}

		$oowner = $_uldmap['iprojectusr']->id;

		$filename = $_FILES[$filerequestid]['name'];
		$tmpname	= $_FILES[$filerequestid]['tmp_name'];
		$filesize = intval($_FILES[$filerequestid]['size']);
		$filetype = iProjectWebUtils::addMSlashes($_FILES[$filerequestid]['type']);

		$Type = iProjectWebUtils::addMSlashes($_uldmap['t']);
		$id = intval($_uldmap['oid']);
		$fieldname = iProjectWebUtils::addMSlashes($_uldmap['fld']);

		$ds = DIRECTORY_SEPARATOR;

		$filename = iProjectWebUtils::addMSlashes($filename);
		$basename = iProjectWebUtils::subStringBefore($filename, ".");

		if ($protect &&
			(($basename == NULL) || preg_match('/^[A-Fa-f0-9]{32}$/', $basename))) {
			echo iProjectWebIHTML::showMessage(
				IPROJECTWEB_ImpossibleToPerformOperation, 'warningMessage');
			return FALSE;
		}

		$query = "SELECT
				Count
			FROM
				#wp__iprojectweb_files
			WHERE
				Doctype='$Type'
				AND Docid='$id'
				AND Docfield='$fieldname'";

		$counter = iProjectWebDB::getValue($query);
		$counter = isset($counter) ? $counter : 0;

		$query = "SELECT
				id
			FROM
				#wp__iprojectweb_files
			WHERE
				Doctype='$Type'
				AND Docid='$id'
				AND Docfield='$fieldname'";

		$fileid = iProjectWebDB::getValue($query);
		if (isset($fileid)) {
			iProjectWebFiles::deletefile($fileid);
		}
		$query
			= "DELETE FROM #wp__iprojectweb_files WHERE Doctype='$Type' AND Docid='$id' AND Docfield='$fieldname'";
		iProjectWebDB::query($query);

		$valuemap = array();
		$valuemap['Count'] = $counter;
		$valuemap['Docfield'] = $fieldname;
		$valuemap['Doctype'] = $Type;
		$valuemap['Docid'] = $id;
		$valuemap['Name'] = $filename;
		$valuemap['Size'] = $filesize;
		$valuemap['Type'] = $filetype;
		$valuemap['Protected'] = $protect;
		$valuemap['Webdir'] = 0;
		$valuemap['Storagename'] = '';
		$valuemap['ObjectOwner'] = $oowner;

		$isid = iProjectWebDB::insert($valuemap, 'Files');

		$filespec = (object) array();
		$filespec->protect = $protect;
		$filespec->fieldname = $fieldname;
		$filespec->docType = $Type;
		$filespec->filename = $filename;

		$valuemap = array();
		if ($Type == "Files") {
			$filespec->id = $isid;
			$Storagename = iProjectWebFiles::getStorageFileName($filespec);
			$valuemap['Docid'] = $isid;
			$valuemap['Storagename'] = $Storagename;
		}
		else {
			$filespec->id = $id;
			$Storagename = iProjectWebFiles::getStorageFileName($filespec);
			$valuemap['Storagename'] = $Storagename;
		}

		iProjectWebDB::update($valuemap, 'Files', $isid);
		$filedirectory = ($protect)? IPROJECTWEB__fileProtectedUploadDir : IPROJECTWEB__fileUploadDir;
		if (!is_dir($filedirectory)) {
			iProjectWebUtils::createFolder($filedirectory);
		}
		$newpath = $filedirectory . $ds . $Storagename;

		move_uploaded_file($tmpname, $newpath);
		echo json_encode(array('success' => 'true'));
		return TRUE;

	}

	/**
	 * 	getStorageFileName
	 *
	 * 	return a new file name
	 *
	 * @param object $filespec
	 * 	file data
	 *
	 * @return string
	 * 	file name
	 */
	function getStorageFileName($filespec) {

		if (!$filespec->protect) {
			return
			$filespec->docType . '_' .
			$filespec->id . '_' .
			$filespec->fieldname . '_' .
			$filespec->filename ;
		}
		$strarr = explode(".", $filespec->filename);
		$ext = $strarr[count($strarr) - 1];

		$md5name = md5(iProjectWebSecurityManager::getServerPwd() . $filespec->filename . $filespec->docType . $filespec->id);

		$newfilename = $md5name . '.' . $ext;
		return $newfilename;

	}

	/**
	 * 	webdirUpload
	 *
	 * 	takes a file from a temporary folder, registers it in the file
	 * 	manager
	 * 	places the file to a web directory for direct download and makes a
	 * 	thumbnail
	 * 	copy if it is necessary
	 *
	 * @param array $_uldmap
	 * 	request data
	 */
	function webdirUpload($_uldmap) {

		$filerequestid = $_uldmap['t'] . '_' . $_uldmap['fld'] . '_' . $_uldmap['oid'];
		if ($_FILES[$filerequestid]['error'] != UPLOAD_ERR_OK) {
			return FALSE;
		}

		$oowner = $_uldmap['iprojectusr']->id;

		$filename = $_FILES[$filerequestid]['name'];
		$tmpname	= $_FILES[$filerequestid]['tmp_name'];
		$filesize = $_FILES[$filerequestid]['size'];
		$filetype = iProjectWebUtils::addMSlashes($_FILES[$filerequestid]['type']);

		$id = intval($_uldmap['oid']);
		$Type = iProjectWebUtils::addMSlashes($_uldmap['t']);
		$fieldname = iProjectWebUtils::addMSlashes($_uldmap['fld']);
		$filename = iProjectWebUtils::addMSlashes($filename);

		$ds = DIRECTORY_SEPARATOR;

		$targdir = IPROJECTWEB__fileUploadDir . $ds . $Type . $ds . $id . $ds . $fieldname;

		$query = "SELECT Name FROM #wp__iprojectweb_files WHERE Doctype='$Type' AND Docid='$id' AND Docfield='$fieldname'";
		$name = iProjectWebDB::getValue($query);

		if (is_file($targdir . $ds . $name)) {
			unlink($targdir . $ds . $name);
		}

		$query = "DELETE FROM #wp__iprojectweb_files WHERE Doctype='$Type' AND Docid='$id' AND Docfield='$fieldname'";
		iProjectWebDB::query($query);

		$valuemap = array();
		$valuemap['Count'] = '0';
		$valuemap['Docfield'] = $fieldname;
		$valuemap['Doctype'] = $Type;
		$valuemap['Docid'] = $id;
		$valuemap['Name'] = $filename;
		$valuemap['Size'] = $filesize;
		$valuemap['Type'] = $filetype;
		$valuemap['Protected'] = 0;
		$valuemap['Webdir'] = 1;
		$valuemap['Storagename'] = $filename;
		$valuemap['ObjectOwner'] = $oowner;

		$isid = iProjectWebDB::insert($valuemap, 'Files');
		if ($Type == 'Files') {
			$valuemap = array();
			$valuemap['Docid'] = $isid;
			iProjectWebDB::update($valuemap, 'Files', $isid);
		}

		if (!is_dir($targdir)) {
			iProjectWebUtils::createFolder($targdir);
		}

		$newpath = $targdir . $ds . $filename;

		move_uploaded_file($tmpname, $newpath);

		if (isset($_uldmap['thumbnailx'])) {
			$newfieldname = 'thumb' . $fieldname;
			$newfilename = 'thumb' . $filename;
			$newtargdir = IPROJECTWEB__fileUploadDir . $ds . $Type . $ds . $id . $ds . $newfieldname;

			$query = "SELECT Name FROM #wp__iprojectweb_files WHERE Doctype='$Type' AND Docid='$id' AND Docfield='thumb$fieldname'";

			$name = iProjectWebDB::getValue($query);
			if (is_file($newtargdir . $ds . $name)) {
				unlink($newtargdir . $ds . $name);
			}

			iProjectWebUtils::createFolder($newtargdir);

			iProjectWebFiles::imgResize($newpath, $newtargdir . $ds . $newfilename, $_uldmap['thumbnailx'], $_uldmap['thumbnaily'], 0xFFFFFF, 80);

			$query = "DELETE FROM #wp__iprojectweb_files WHERE Doctype='$Type' AND Docid='$id' AND Docfield='$newfieldname'";
			iProjectWebDB::query($query);

			$valuemap = array();
			$valuemap['Count'] = '0';
			$valuemap['Docfield'] = $newfieldname;
			$valuemap['Doctype'] = $Type;
			$valuemap['Docid'] = $id;
			$valuemap['Name'] = $newfilename;
			$valuemap['Size'] = filesize($newtargdir . $ds . $newfilename);
			$valuemap['Type'] = $filetype;
			$valuemap['Protected'] = 0;
			$valuemap['Webdir'] = 1;
			$valuemap['Storagename'] = $newfilename;
			$valuemap['ObjectOwner'] = $oowner;

			iProjectWebDB::insert($valuemap, 'Files');
		}
		echo json_encode(array('success' => 'TRUE'));
		return TRUE;

	}

	/**
	 * 	imgResize
	 *
	 * 	resizes an image based on defined parameters and crates a jpg
	 * 	thumbnail image
	 *
	 * @param string $src
	 * 	source image path
	 * @param string $dest
	 * 	destination image path
	 * @param int $width
	 * 	destination image width
	 * @param int $height
	 * 	destination image height
	 * @param int $rgb
	 * 	initial color
	 * @param int $quality
	 * 	jpg image quality
	 *
	 * @return boolean
	 * 	TRUE if succees, FALSE otherwise
	 */
	function imgResize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 80) {

		if (!file_exists($src)) {
			return FALSE;
		}
		$size = getimagesize($src);

		if ($size === FALSE) {
			return FALSE;
		}

		$format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));

		$icfunc = 'imagecreatefrom' . $format;
		if (!function_exists($icfunc)) {
			return FALSE;
		}

		$div = min($size[0], $size[1]);
		$usex = FALSE;
		$usey = FALSE;

		if ($div == $size[0]) {
			$ratio = $width / $div;
			$usex = TRUE;
		}
		else {
			$ratio = $height / $div;
			$usey = TRUE;
		}

		$new_width = floor($size[0] * $ratio);
		$new_height = floor($size[1] * $ratio);

		$new_left = $usex ? 0 : floor(($width - $new_width) / 2);
		$new_top = $usey ? 0 : floor(($height - $new_height) / 2);

		$isrc = $icfunc($src);
		$idest = imagecreatetruecolor($width, $height);
		imagefill($idest, 0, 0, $rgb);
		imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);
		imagejpeg($idest, $dest, $quality);
		imagedestroy($isrc);
		imagedestroy($idest);
		return TRUE;

	}

	/**
	 * 	dispatch. Overrides iProjectWebBase::dispatch()
	 *
	 * 	invokes requested object methods
	 *
	 * @param array $dispmap
	 * 	request data
	 */
	function dispatch($dispmap) {

		$dispmap = parent::dispatch($dispmap);
		if ($dispmap == NULL) {
			return NULL;
		}

		$dispmethod = $dispmap["m"];
		switch ($dispmethod) {

			case 'deletefile':
				$this->deletefile($dispmap);
				return NULL;

			case 'download':
				$this->download($dispmap);
				return NULL;

			case 'upload':
				$this->upload($dispmap);
				return NULL;

			default : return $dispmap;
		}

	}

	/**
	 * 	getMainView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getMainView($viewmap) {

		$spar = $this->getOrder($viewmap);

		$sortfields = array(
			'id',
			'Doctype',
			'Docfield',
			'Docid',
			'Name',
			'Size',
			'Webdir',
			'Storagename',
			'ObjectOwnerDescription',
		);

		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar);

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Doctype');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Docfield');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Docid', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Name');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Type');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Size', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Protected', 'boolean');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Webdir', 'boolean');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Count', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'Storagename');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Files.', 'ObjectOwner', 'int');
		iProjectWebRoot::mDelete('Files', $viewmap);

		$query = "SELECT
				Files.id,
				Files.Doctype,
				Files.Docfield,
				Files.Docid,
				Files.Name,
				Files.Size,
				Files.Webdir,
				Files.Storagename,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Files.ObjectOwner AS ObjectOwner
			FROM
				#wp__iprojectweb_files AS Files
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Files.ObjectOwner=Users.id";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->ObjectOwner = (object) array();
		$this->ObjectOwner->view = $this;
		$this->ObjectOwner->field = 'ObjectOwner';
		$this->ObjectOwner->filter = TRUE;
		$this->ObjectOwner->config['m2'] = 'getUserASList';
		$this->ObjectOwner->config['t'] = 'Users';
		$this->ObjectOwner->asparams['listItemClass'] = 'ufo-user-list-item';
		$this->ObjectOwner->inpstyle = " style='width:130px;'";

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Files'><?php

		require_once 'views/iprojectweb_filesmainview.php';

	}

}
