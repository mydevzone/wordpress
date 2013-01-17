<?php

/**
 * @file
 *
 * 	iProjectWebUsers class definition
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
 * 	iProjectWebUsers
 *
 */
class iProjectWebUsers extends iProjectWebBase {

	/**
	 * 	iProjectWebUsers class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'Users';

		$this->fieldmap = array(
				'id' => NULL,
				'Description' => '',
				'Name' => '',
				'ObjectOwner' => 0,
				'Birthday' => 0,
				'Role' => 0,
				'CMSId' => 0,
				'About' => '',
				'Notes' => '',
				'email' => '',
				'email2' => '',
				'UserType' => 0,
				'Cell' => '',
				'Phone' => '',
				'SkypeId' => '',
				'UserField1' => 0,
				'UserField2' => 0,
				'UserField3' => '',
				'UserField4' => '',
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a user record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$query = "SELECT id FROM #wp__iprojectweb_files WHERE doctype='Users' AND docid=$id;";
		iProjectWebDB::cDelete($query, 'Files');

		$stmts[] = "DELETE FROM #wp__iprojectweb_projects_teams WHERE Members=$id;";

		$stmts[] = "DELETE FROM #wp__iprojectweb_projects_mailinglists WHERE Contacts=$id;";

		$stmts[] = "DELETE FROM #wp__iprojectweb_tasks_mailinglists WHERE Contacts=$id;";

		$stmts[] = "DELETE FROM #wp__iprojectweb_risks_mailinglists WHERE Contacts=$id;";

		$stmts[] = "DELETE FROM #wp__iprojectweb_users WHERE id=$id;";

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

		$request = iProjectWebUtils::parseRequest($request, 'ObjectOwner', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Birthday', 'date');
		$request = iProjectWebUtils::parseRequest($request, 'Role', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'CMSId', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'UserType', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'UserField1', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'UserField2', 'int');

		parent::update($request, $id);

	}

	/**
	 * 	getEmptyObject. Overrides iProjectWebBase::getEmptyObject()
	 *
	 * 	creates and initializes a new User
	 *
	 * @param array $map
	 * 	request data
	 * @param array $fields
	 * 	a field array
	 *
	 * @return object
	 * 	the initialized instance
	 */
	function getEmptyObject($map, $fields = NULL) {

		$fields = (object) array();
		$fields->Role = iProjectWebDB::getFirst('Roles');
		$fields->UserType = iProjectWebDB::getFirst('UserTypes');
		$fields->UserField1 = iProjectWebDB::getFirst('UserField1');
		$fields->UserField2 = iProjectWebDB::getFirst('UserField2');

		return parent::getEmptyObject($map, $fields);

	}

	/**
	 * 	getEUserASList
	 *
	 * 	Prepares a site user list to send to the Ajax Suggest list component
	 *
	 * @param array $_asmap
	 * 	request data
	 */
	function getEUserASList($_asmap) {

		$plainselect = "SELECT ID as id, user_login AS Description, display_name  as info FROM #wp__users AS Users";

		$values = array();
		$_result = array();
		$_idmode = isset($_asmap['oid']);

		if ($_idmode) {
			$values['fvalues'][':input'] = intval($_asmap['oid']);
			$_query = "$plainselect WHERE Users.ID=:input";
		}
		else {
			$asinput = iProjectWebUtils::getASInput($_asmap);
			if (!$asinput) {
				return $_result;
			}
			$values['fvalues'][':input'] = "%$asinput->input%";
			$_limit	= $asinput->limit;
			$_query = "$plainselect WHERE Users.display_name LIKE :input $_limit";
		}

		$_aslist = iProjectWebDB::select($_query, $values);

		foreach ($_aslist as $_asitem) {
			$_resultitem = array();
			$_resultitem['id'] = $_asitem->id;
			$_resultitem['value'] = $_asitem->Description;
			$_resultitem['info'] = $_asitem->info;
			$_result[] = (object) $_resultitem;
		}
		return $_result;

	}

	/**
	 * 	getUserASList
	 *
	 * 	Prepares a list of iProjectWeb users to send to the Ajax Suggest list
	 * 	component
	 *
	 * @param array $_asmap
	 * 	request data
	 */
	function getUserASList($_asmap) {

		$plainselect = "SELECT
				CONCAT(Users.Description,' ', Users.Name) AS Description,
				Users.id
			FROM
				#wp__iprojectweb_users AS Users";

		$values = array();
		$_result = array();
		$_idmode = isset($_asmap['oid']);

		if ($_idmode) {
			$values['fvalues'][':input'] = intval($_asmap['oid']);
			$_query = "$plainselect WHERE Users.id=:input";
		}
		else {
			$asinput = iProjectWebUtils::getASInput($_asmap);
			if (!$asinput) {
				return $_result;
			}
			$values['fvalues'][':input'] = "%$asinput->input%";
			$_limit	= $asinput->limit;

			$_query = "$plainselect WHERE CONCAT (Users.Description,' ',Users.Name) LIKE :input $_limit";
		}

		$_aslist = iProjectWebDB::select($_query, $values);

		foreach ($_aslist as $_asitem) {
			$_resultitem = array();
			$_resultitem['id'] = $_asitem->id;
			$_resultitem['value'] = trim($_asitem->Description);
			$_resultitem['info'] = $this->getObjectASForm($_asitem->id);
			$_result[] = (object) $_resultitem;
		}
		return $_result;

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

			case 'getEUserASList':
				$this->getEUserASList($dispmap);
				return NULL;

			case 'getUserASList':
				$this->getUserASList($dispmap);
				return NULL;

			default : return $dispmap;
		}

	}

	/**
	 * 	getViews. Overrides iProjectWebBase::getViews()
	 *
	 * 	selects an object view to show on the client side
	 *
	 * @param array $vmap
	 * 	request data
	 */
	function getViews($vmap) {

		$viewname = parent::getViews($vmap);

		switch ($viewname) {

			case 'managemain':
				return $this->getManageMainView($vmap);
				break;

			case 'readonly':
				return $this->getReadonlyView($vmap);
				break;

			default:return '';
		}

	}

	/**
	 * 	getForms. Overrides iProjectWebBase::getForms()
	 *
	 * 	selects an object view to show on the client side
	 *
	 * @param array $vmap
	 * 	request data
	 */
	function getForms($vmap) {

		$viewname = parent::getForms($vmap);

		switch ($viewname) {

			case 'readonly':
				return $this->getReadonlyForm($vmap);
				break;

			case 'teammember':
				return $this->getTeamMemberForm($vmap);
				break;

			default:return '';
		}

	}

	/**
	 * 	getASForm
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $formmap
	 * 	request data
	 */
	function getASForm($formmap) {

		$query = "SELECT
				Users.id,
				Users.Cell,
				Users.Phone,
				Users.Birthday,
				Users.email,
				Users.About,
				UserTypes.Description AS UserTypeDescription,
				Roles.Description AS RoleDescription,
				UserField1.Description AS UserField1Description,
				UserField2.Description AS UserField2Description
			FROM
				#wp__iprojectweb_users AS Users
			LEFT JOIN
				#wp__iprojectweb_usertypes AS UserTypes
					ON
						Users.UserType=UserTypes.id
			LEFT JOIN
				#wp__iprojectweb_roles AS Roles
					ON
						Users.Role=Roles.id
			LEFT JOIN
				#wp__iprojectweb_userfield1 AS UserField1
					ON
						Users.UserField1=UserField1.id
			LEFT JOIN
				#wp__iprojectweb_userfield2 AS UserField2
					ON
						Users.UserField2=UserField2.id
			WHERE
				Users.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->thumbPhoto = array(
			'doctype' => 'Users',
			'docid' => $obj->get('id'),
			'field' => 'thumbPhoto',
			'tag' => 'img',
			'content' => '',
			'style' => "class='ufo-img ufo-as-info-img'",
		);

		require 'views/iprojectweb_usersasform.php';

	}

	/**
	 * 	getMainForm
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $formmap
	 * 	request data
	 */
	function getMainForm($formmap) {

		$fields = array();
		$fields[] = 'id';
		$fields[] = 'Name';
		$fields[] = 'Description';
		$fields[] = 'Birthday';
		$fields[] = 'email';
		$fields[] = 'Cell';
		$fields[] = 'Phone';
		$fields[] = 'SkypeId';
		$fields[] = 'email2';
		$fields[] = 'About';
		$fields[] = 'Role';
		$fields[] = 'ObjectOwner';
		$fields[] = 'UserField1';
		$fields[] = 'CMSId';
		$fields[] = 'UserType';
		$fields[] = 'UserField2';
		$fields[] = 'Notes';
		$fields[] = 'UserField3';
		$fields[] = 'UserField4';

		$obj = $this->formInit($formmap, $fields);

		$files = iProjectWebClassLoader::getObject('Files');

		$obj->set('Name', htmlspecialchars($obj->get('Name')));
		$obj->set('Description', htmlspecialchars($obj->get('Description')));
		$obj->Birthday = iProjectWebUtils::getDate($obj->get('Birthday'));
		$obj->set('email', htmlspecialchars($obj->get('email')));
		$obj->set('Cell', htmlspecialchars($obj->get('Cell')));
		$obj->set('Phone', htmlspecialchars($obj->get('Phone')));
		$obj->set('SkypeId', htmlspecialchars($obj->get('SkypeId')));
		$obj->set('email2', htmlspecialchars($obj->get('email2')));
		$obj->set('About', htmlspecialchars($obj->get('About')));

		$obj->ObjectOwner = (object) array();
		$obj->ObjectOwner->view = $obj;
		$obj->ObjectOwner->field = 'ObjectOwner';
		$obj->ObjectOwner->type = 'Users';
		$obj->ObjectOwner->config['m2'] = 'getUserASList';
		$obj->ObjectOwner->config['t'] = 'Users';
		$obj->ObjectOwner->asparams['listItemClass'] = 'ufo-user-list-item';

		$obj->CMSId = (object) array();
		$obj->CMSId->view = $obj;
		$obj->CMSId->field = 'CMSId';
		$obj->CMSId->config['m2'] = 'getEUserASList';
		$obj->CMSId->config['t'] = 'Users';
		$obj->CMSId->inpstyle = " style='width:100%'";

		$obj->set('Notes', htmlspecialchars($obj->get('Notes')));

		$obj->Photo = (object) array();
		$obj->Photo->request = (object) array();
		$obj->Photo->request->thumbnaily = 120;
		$obj->Photo->request->webdirupload = 'on';
		$obj->Photo->request->t = 'Users';
		$obj->Photo->request->fld = 'Photo';
		$obj->Photo->request->oid = $obj->getId();
		$obj->Photo->request->thumbnailx = 100;
		$obj->Photo->oncomplete = (object) array();
		$obj->Photo->oncomplete->func = 'apply';
		$obj->Photo->oncomplete->args = $obj->jsconfig;

		$obj->Photo->value = $files->getFileValue('Name', 'Photo', $obj);

		$obj->PhotoImg = array(
			'doctype' => 'Users',
			'docid' => $obj->get('id'),
			'field' => 'Photo',
			'tag' => 'img',
			'content' => '',
			'style' => "class='ufo-img image' style='max-width:450px;max-height:270px'",
		);

		$obj->thumbPhoto = (object) array();
		$obj->thumbPhoto->request = (object) array();
		$obj->thumbPhoto->request->webdirupload = 'on';
		$obj->thumbPhoto->request->t = 'Users';
		$obj->thumbPhoto->request->fld = 'thumbPhoto';
		$obj->thumbPhoto->request->oid = $obj->getId();
		$obj->thumbPhoto->oncomplete = (object) array();
		$obj->thumbPhoto->oncomplete->func = 'apply';
		$obj->thumbPhoto->oncomplete->args = $obj->jsconfig;

		$obj->thumbPhoto->value = $files->getFileValue('Name', 'thumbPhoto', $obj);

		$obj->thumbPhotoImg = array(
			'doctype' => 'Users',
			'docid' => $obj->get('id'),
			'field' => 'thumbPhoto',
			'tag' => 'img',
			'content' => '',
			'style' => "class='ufo-img image' style='max-width:100px;max-height:120px'",
		);

		$obj->set('UserField3', htmlspecialchars($obj->get('UserField3')));
		$obj->set('UserField4', htmlspecialchars($obj->get('UserField4')));

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_usersmainform.php';

	}

	/**
	 * 	getReadonlyForm
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $formmap
	 * 	request data
	 */
	function getReadonlyForm($formmap) {

		$fields = array();
		$fields[] = 'id';
		$fields[] = 'Cell';
		$fields[] = 'email';
		$fields[] = 'SkypeId';
		$fields[] = 'Phone';
		$fields[] = 'email2';
		$fields[] = 'About';
		$fields[] = 'UserType';
		$fields[] = 'UserField1';
		$fields[] = 'UserField2';
		$fields[] = 'UserField3';
		$fields[] = 'UserField4';

		$obj = $this->formInit($formmap, $fields);

		$files = iProjectWebClassLoader::getObject('Files');

		$obj->thumbPhoto = array(
			'doctype' => 'Users',
			'docid' => $obj->get('id'),
			'field' => 'thumbPhoto',
			'tag' => 'img',
			'content' => '',
			'style' => "class='ufo-img image' style='float:left;padding:10px;max-height:120px;max-width:100px'",
		);

		$obj->Photo = (object) array();
		$obj->Photo->request = (object) array();
		$obj->Photo->request->fld = 'Photo';
		$obj->Photo->request->oid = $obj->getId();
		$obj->Photo->request->t = 'Users';
		$obj->Photo->oncomplete = (object) array();
		$obj->Photo->oncomplete->func = 'apply';
		$obj->Photo->oncomplete->args = $obj->jsconfig;

		$obj->Photo->value = $files->getFileValue('Name', 'Photo', $obj);

		$obj->set('UserField3', htmlspecialchars($obj->get('UserField3')));
		$obj->set('UserField4', htmlspecialchars($obj->get('UserField4')));

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_usersreadonlyform.php';

	}

	/**
	 * 	getTeamMemberForm
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $formmap
	 * 	request data
	 */
	function getTeamMemberForm($formmap) {

		$fields = array();
		$fields[] = 'id';
		$fields[] = 'Name';
		$fields[] = 'Description';
		$fields[] = 'Birthday';
		$fields[] = 'email';
		$fields[] = 'Cell';
		$fields[] = 'Phone';
		$fields[] = 'SkypeId';
		$fields[] = 'email2';
		$fields[] = 'About';
		$fields[] = 'UserField3';
		$fields[] = 'UserField4';
		$fields[] = 'UserType';
		$fields[] = 'UserField1';
		$fields[] = 'UserField2';

		$obj = $this->formInit($formmap, $fields);

		$files = iProjectWebClassLoader::getObject('Files');

		$obj->set('Name', htmlspecialchars($obj->get('Name')));
		$obj->set('Description', htmlspecialchars($obj->get('Description')));
		$obj->Birthday = iProjectWebUtils::getDate($obj->get('Birthday'));
		$obj->set('email', htmlspecialchars($obj->get('email')));
		$obj->set('Cell', htmlspecialchars($obj->get('Cell')));
		$obj->set('Phone', htmlspecialchars($obj->get('Phone')));
		$obj->set('SkypeId', htmlspecialchars($obj->get('SkypeId')));
		$obj->set('email2', htmlspecialchars($obj->get('email2')));
		$obj->set('About', htmlspecialchars($obj->get('About')));

		$obj->Photo = (object) array();
		$obj->Photo->request = (object) array();
		$obj->Photo->request->thumbnaily = 120;
		$obj->Photo->request->webdirupload = 'on';
		$obj->Photo->request->t = 'Users';
		$obj->Photo->request->fld = 'Photo';
		$obj->Photo->request->oid = $obj->getId();
		$obj->Photo->request->thumbnailx = 100;
		$obj->Photo->oncomplete = (object) array();
		$obj->Photo->oncomplete->func = 'apply';
		$obj->Photo->oncomplete->args = $obj->jsconfig;

		$obj->Photo->value = $files->getFileValue('Name', 'Photo', $obj);

		$obj->PhotoImg = array(
			'doctype' => 'Users',
			'docid' => $obj->get('id'),
			'field' => 'Photo',
			'tag' => 'img',
			'content' => '',
			'style' => "class='ufo-img image' style='max-width:450px;max-height:270px'",
		);

		$obj->thumbPhoto = (object) array();
		$obj->thumbPhoto->request = (object) array();
		$obj->thumbPhoto->request->webdirupload = 'on';
		$obj->thumbPhoto->request->t = 'Users';
		$obj->thumbPhoto->request->fld = 'thumbPhoto';
		$obj->thumbPhoto->request->oid = $obj->getId();
		$obj->thumbPhoto->oncomplete = (object) array();
		$obj->thumbPhoto->oncomplete->func = 'apply';
		$obj->thumbPhoto->oncomplete->args = $obj->jsconfig;

		$obj->thumbPhoto->value = $files->getFileValue('Name', 'thumbPhoto', $obj);

		$obj->thumbPhotoImg = array(
			'doctype' => 'Users',
			'docid' => $obj->get('id'),
			'field' => 'thumbPhoto',
			'tag' => 'img',
			'content' => '',
			'style' => "class='ufo-img image' style='max-width:100px;max-height:120px'",
		);

		$obj->set('UserField3', htmlspecialchars($obj->get('UserField3')));
		$obj->set('UserField4', htmlspecialchars($obj->get('UserField4')));

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_usersteammemberform.php';

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
		$orderby = iProjectWebDB::getOrderBy(array('id', 'Description', 'Name', 'email'), $spar, "Users.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'Name');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'Role', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'CMSId', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'email');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'email2');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'UserType', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'UserField3');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'UserField4');
		iProjectWebRoot::mDelete('Users', $viewmap);

		$query = "SELECT
				Users.id,
				Users.Description,
				Users.Name,
				Users.email
			FROM
				#wp__iprojectweb_users AS Users";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->CMSId = (object) array();
		$this->CMSId->view = $this;
		$this->CMSId->field = 'CMSId';
		$this->CMSId->filter = TRUE;
		$this->CMSId->config['m2'] = 'getEUserASList';
		$this->CMSId->config['t'] = 'Users';
		$this->CMSId->inpstyle = " style='width:130px;'";

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Users'><?php

		require_once 'views/iprojectweb_usersmainview.php';

	}

	/**
	 * 	getManageMainView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getManageMainView($viewmap) {

		$spar = $this->getOrder($viewmap);
		$orderby = iProjectWebDB::getOrderBy(array('id', 'Description', 'Name'), $spar, "Users.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getMTMFilter($viewmap, $viewfilters, 'Users');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'Name');

		$query = "SELECT
				Users.id,
				Users.Description,
				Users.Name
			FROM
				#wp__iprojectweb_users AS Users";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->showlist = FALSE;
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Users'><?php

		require_once 'views/iprojectweb_usersmanagemainview.php';

	}

	/**
	 * 	getReadonlyView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getReadonlyView($viewmap) {

		$spar = $this->getOrder($viewmap);
		$orderby = iProjectWebDB::getOrderBy(array('Description', 'Name', 'email'), $spar, "Users.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'Name');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'UserField3');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Users.', 'UserField4');

		$query = "SELECT
				Users.id,
				Users.Description,
				Users.Name,
				Users.email
			FROM
				#wp__iprojectweb_users AS Users";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Users'><?php

		require_once 'views/iprojectweb_usersreadonlyview.php';

	}

}
