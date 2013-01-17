<?php

/**
 * @file
 *
 * 	iProjectWebSecurityManager class definition
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
 * 	iProjectWebSecurityManager
 *
 * 	Security and access functions
 *
 */
class iProjectWebSecurityManager {

	/**
	 * 	getInstance
	 *
	 * 	Returns an instance of security manager
	 *
	 *
	 * @return object
	 * 	a security manager instance
	 */
	function getInstance() {

		static $sminstance;
		if (!isset($sminstance)) {
			$sminstance = new iProjectWebSecurityManager();
		}
		return $sminstance;

	}

	/**
	 * 	getGuest
	 *
	 * 	returns a guest role object
	 *
	 *
	 * @return object
	 * 	the guest role object
	 */
	function getGuest() {

		$role = (object) array();
		$role->id = 4;
		$role->Description = 'Guest';
		$user = (object) array();
		$user->id = 0;
		$user->role = $role;
		return $user;

	}

	/**
	 * 	getRights
	 *
	 * 	inits a 'iprojectusr' variable with the current user role
	 *
	 * @param array $_ssmap
	 * 	request data
	 */
	function getRights($_ssmap) {

		$_ssmap['iprojectusr'] = iProjectWebSecurityManager::getGuest();

		$foreignid = intval($_ssmap['fid']);

		$query = "SELECT
				Users.Role AS roleid,
				Users.id
			FROM
				#wp__iprojectweb_users AS Users
			WHERE
				Users.CMSId='$foreignid'";

		$usr = iProjectWebDB::getObjects($query);
		if (iProjectWebDB::err()) {
			return $_ssmap;
		}

		if (count($usr) == 0) {
			return $_ssmap;
		}

		$usr = $usr[0];

		$query = "SELECT * FROM #wp__iprojectweb_roles AS Roles WHERE Roles.id = '" . $usr->roleid . "'";
		$role = iProjectWebDB::getObjects($query);

		if (iProjectWebDB::err()) {
			return $_ssmap;
		}
		if (count($role) == 0) {
			return $_ssmap;
		}

		$usr->role = (object) array();
		$usr->role->Description = $role[0]->Description;
		$usr->role->id = $role[0]->id;
		unset($usr->roleid);

		$_ssmap['iprojectusr'] = $usr;
		return $_ssmap;

	}

	/**
	 * 	roleObjectCheck
	 *
	 * 	performs a simple check if users of current user role have access to
	 * 	a selected object type
	 *
	 * @param array $_cmmap
	 * 	request data
	 *
	 * @return boolean
	 * 	TRUE if they have, FALSE if they do not
	 */
	function roleObjectCheck($_cmmap) {

		$objecttype = $_cmmap['t'];
		$userrole = $_cmmap['iprojectusr']->role->Description;

		$query = "SELECT
				Count(id)
			FROM
				#wp__iprojectweb_acl
			WHERE
				objtype='$objecttype'
				AND role='$userrole'";

		$value = iProjectWebDB::getValue($query);
		return ($value > 0);

	}

	/**
	 * 	getYouAreNotLoggedInMessage
	 *
	 * 	Prints a 'not logged in message'
	 *
	 */
	function getYouAreNotLoggedInMessage() {

		require_once 'iprojectweb_ihtml.php';
		return iProjectWebIHTML::getNotLoggedInHTML();

	}

	/**
	 * 	getViewName
	 *
	 * 	Finds a name of an object view indended for a current user role
	 *
	 * @param array $_vnmap
	 * 	request data
	 *
	 * @return string
	 * 	view name
	 */
	function getViewName($_vnmap) {

		$objecttype = $_vnmap['t'];
		$vnmethod = $_vnmap['m'];

		if (empty($objecttype)) {
			return '';
		}
		if (empty($vnmethod)) {
			return '';
		}

		switch ($vnmethod) {
			case 'show':
			case 'new':
			case 'view':
			case 'viewDetailed':
				return $this->getObjectViewName($_vnmap);
				break;
			default:
				return $this->getObjectMethodViewName($_vnmap);
		}

	}

	/**
	 * 	getObjectMethodViewName
	 *
	 * 	not used
	 *
	 * @param array $_cmmap
	 * 	Request data
	 */
	function getObjectMethodViewName($_cmmap) {

		if (!isset($_cmmap["iprojectusr"])) {
			return NULL;
		}
		return $_cmmap;

	}

	/**
	 * 	isObjectOwner
	 *
	 * 	Check if a current user may play as object's owner
	 *
	 * @param string $objtype
	 * 	object type
	 * @param int $objid
	 * 	object id
	 * @param int $usrid
	 * 	user id
	 *
	 * @return boolean
	 * 	TRUE if he may, FALSE if he may not
	 */
	function isObjectOwner($objtype, $objid, $usrid) {

		$xml = _IPROJECTWEB_APPLICATION_DIR . DIRECTORY_SEPARATOR . 'iprojectweb_objects.xml';
		$xml = simplexml_load_file($xml);

		$nodes = $xml->xpath('//' . $objtype);
		$node = $nodes[0];
		$childname = strtolower($node->getName());

		while (TRUE) {
			$parents = $node->xpath('..');
			$parent = $parents[0];
			$parentname = $parent->getName();
			$noparents = ($parentname == 'objects');
			$obj = iProjectWebClassLoader::getObject($childname, TRUE, $objid);
			if ($obj->get('ObjectOwner') == $usrid) {
				return TRUE;
			}
			if ($noparents) {
				break;
			}
			$objid = $obj->get($parentname);
			$node = $parent;
			$childname = strtolower($parentname);
		}
		return FALSE;

	}

	/**
	 * 	getOwnerRole
	 *
	 * 	Perform additional search in the roles.xml file to find
	 * 	if there are any exceptions to the general access rules
	 *
	 * @param string $roleid
	 * 	a current user role name
	 * @param string $objtype1
	 * 	an object name the user gets access to
	 * @param string $objtype2
	 * 	a subordinated object name the user gets access to
	 *
	 * @return string
	 * 	final role name
	 */
	function getOwnerRole($roleid, $objtype1, $objtype2) {

		$xml = _IPROJECTWEB_APPLICATION_DIR . DIRECTORY_SEPARATOR . 'iprojectweb_roles.xml';
		$xml = simplexml_load_file($xml);
		$roleid = $xml->xpath("$roleid/$objtype1/$objtype2");
		$roleid = $roleid ? $roleid[0] : 'Owner';

		return $roleid;

	}

	/**
	 * 	checkRole
	 *
	 * 	Performs additional role check
	 *
	 * @param array $_ofnmap
	 * 	request data
	 *
	 * @return string
	 * 	role name
	 */
	function checkRole($_ofnmap) {

		$usr = $_ofnmap['iprojectusr'];

		if ($usr->role->Description == 'SuperAdmin') {
			return $usr->role->Description;
		}
		if ($usr->role->Description == 'Guest') {
			return $usr->role->Description;
		}

		$objtype1 = @$_ofnmap['t'];
		$objtype2 = @$_ofnmap['t'];
		$method = @$_ofnmap['m'];
		$objid = @$_ofnmap['oid'];

		if (isset($_ofnmap['specialfilter'])) {
			$sf = json_decode(stripslashes($_ofnmap['specialfilter']));
			$objtype1 = $method == 'viewDetailed' ?
				$sf[0]->property :
				$_ofnmap['n'] ;
			$objid = $sf[0]->value->values[0];
		}

		if (isset($_ofnmap['a'])) {
			$a = json_decode(stripslashes($_ofnmap['a']));
			$mtm = isset($a->m) &&
				$a->m == 'mtmview';
			if ($mtm) {
				$objtype1 = $a->ca[0]->t;
				$objid = $a->ca[0]->oid;
			}
		}

		if (!isset($objid)) {
			return $usr->role->Description;
		}

		$obj = iProjectWebClassLoader::getObject($objtype1);
		$fieldlist = $obj->getFieldNames();
		if (!in_array('ObjectOwner', $fieldlist)) {
			return $usr->role->Description;
		}

		if (!iProjectWebSecurityManager::isObjectOwner($objtype1, $objid, $usr->id)) {
			return $usr->role->Description;
		}

		$usr->role->Description = iProjectWebSecurityManager::getOwnerRole(
			$usr->role->Description,
			$objtype1,
			$objtype2
			);

		return $usr->role->Description;

	}

	/**
	 * 	getObjectViewName
	 *
	 * 	Returns a view name
	 *
	 * @param array $_ovnmap
	 * 	request data
	 *
	 * @return string
	 * 	a view name
	 */
	function getObjectViewName($_ovnmap) {

		$ovnmethod = $_ovnmap["m"];
		$objecttype = $_ovnmap["t"];
		$roleid = iProjectWebSecurityManager::checkRole($_ovnmap);

		return $this->getACLViewName($roleid, $objecttype, $ovnmethod);

	}

	/**
	 * 	getACLViewName
	 *
	 * 	Returns a view name based on a user role, object type and request
	 * 	method
	 *
	 * @param string $role
	 * 	a role name
	 * @param string $type
	 * 	an object type
	 * @param string $method
	 * 	a method name
	 *
	 * @return string
	 * 	a view name
	 */
	function getACLViewName($role, $type, $method) {

		$query = "SELECT
				name
			FROM
				#wp__iprojectweb_acl
			WHERE
				objtype='$type'
				AND role='$role'
				AND method='$method'";

		$result = iProjectWebDB::getValue($query);
		if (iProjectWebDB::err()) {
			return '';
		}
		return $result;

	}

	/**
	 * 	getServerPwd
	 *
	 * 	Returns the Appplicataion Settings SecretWord constant value
	 *
	 *
	 * @return string
	 * 	the value
	 */
	function getServerPwd() {

		return iProjectWebApplicationSettings::getInstance()->get('SecretWord');

	}

}
