<?php
/**
 * @file
 * iprojectweb configuration constants.
 */
/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


	DEFINE('IPROJECTWEB__helpRoot',	'http://help.wp-pal.com');
	DEFINE('IPROJECTWEB__prodVersion', '1.0.8.11');
	$ds = DIRECTORY_SEPARATOR;
	/**
	 * A default style folder name
	 */
	DEFINE('IPROJECTWEB_DEFAULT_STYLE', 'std');
	/**
	 * A file system application root
	 */
	DEFINE('_IPROJECTWEB_APPLICATION_DIR', dirName(__FILE__));
	/**
	 * A web application root
	 */
	DEFINE('IPROJECTWEB__engineRoot', admin_url( 'admin-ajax.php' ) . '?action=iprojectweb-submit');

	/**
	 * A directory to store protected files
	 */
	DEFINE('IPROJECTWEB__fileProtectedUploadDir', _IPROJECTWEB_APPLICATION_DIR . $ds . 'pfiles');
	/**
	 * file folder subdir name
	 */
	DEFINE('IPROJECTWEB__fileFolder', iProjectWebApplicationSettings::getInstance()->get('FileFolder'));
	/**
	 * A directory to store regular files and direct access files(images)
	 */
	DEFINE('IPROJECTWEB__fileUploadDir', _IPROJECTWEB_APPLICATION_DIR . $ds . IPROJECTWEB__fileFolder);
	DEFINE('IPROJECTWEB__notLoggenInRedirect', '');
