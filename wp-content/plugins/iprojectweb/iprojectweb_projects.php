<?php

/**
 * @file
 *
 * 	iProjectWebProjects class definition
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
 * 	iProjectWebProjects
 *
 */
class iProjectWebProjects extends iProjectWebBase {

	/**
	 * 	iProjectWebProjects class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'Projects';

		$this->fieldmap = array(
				'id' => NULL,
				'Description' => '',
				'Status' => 0,
				'StartDate' => 0,
				'FinishDate' => 0,
				'ObjectOwner' => 0,
				'ProjectField1' => 0,
				'ProjectField2' => 0,
				'ProjectDescription' => '',
				'History' => '',
				'Comment' => '',
				'ProjectField3' => '',
				'ProjectField4' => '',
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a project record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$stmts[] = "DELETE FROM #wp__iprojectweb_projects_teams WHERE Projects=$id;";

		$stmts[] = "DELETE FROM #wp__iprojectweb_projects_mailinglists WHERE Projects=$id;";

		$query = "SELECT id FROM #wp__iprojectweb_projectfiles WHERE Projects=$id;";
		iProjectWebDB::cDelete($query, 'ProjectFiles');

		$query = "SELECT id FROM #wp__iprojectweb_tasks WHERE Projects=$id;";
		iProjectWebDB::cDelete($query, 'Tasks');

		$query = "SELECT id FROM #wp__iprojectweb_risks WHERE Projects=$id;";
		iProjectWebDB::cDelete($query, 'Risks');

		$stmts[] = "DELETE FROM #wp__iprojectweb_projects WHERE id=$id;";

		return $stmts;

	}

	/**
	 * 	getEmptyObject. Overrides iProjectWebBase::getEmptyObject()
	 *
	 * 	creates and initializes a new Project
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
		$fields->Status = iProjectWebDB::getFirst('ProjectStatuses', TRUE);
		$fields->ProjectField1 = iProjectWebDB::getFirst('ProjectField1');
		$fields->ProjectField2 = iProjectWebDB::getFirst('ProjectField2');

		return parent::getEmptyObject($map, $fields);

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

		$request = iProjectWebUtils::parseRequest($request, 'Status', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'StartDate', 'date');
		$request = iProjectWebUtils::parseRequest($request, 'FinishDate', 'date');
		$request = iProjectWebUtils::parseRequest($request, 'ObjectOwner', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'ProjectField1', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'ProjectField2', 'int');

		require_once 'iprojectweb_backoffice.php';
		$bo = new iProjectWebBackOffice();
		$request = $bo->processHistory($request, $this->type, $id, $this->user->id);

		parent::update($request, $id);

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

			case 'pm':
				return $this->getPMView($vmap);
				break;

			case 'teammember':
				return $this->getTeamMemberView($vmap);
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
				Projects.id,
				Projects.StartDate,
				Projects.FinishDate,
				Projects.ProjectDescription,
				Projects.Description,
				ProjectStatuses.ListPosition AS StatusListPosition,
				ProjectStatuses.Description AS StatusDescription,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				ProjectField1.Description AS ProjectField1Description,
				ProjectField2.Description AS ProjectField2Description
			FROM
				#wp__iprojectweb_projects AS Projects
			LEFT JOIN
				#wp__iprojectweb_projectstatuses AS ProjectStatuses
					ON
						Projects.Status=ProjectStatuses.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Projects.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_projectfield1 AS ProjectField1
					ON
						Projects.ProjectField1=ProjectField1.id
			LEFT JOIN
				#wp__iprojectweb_projectfield2 AS ProjectField2
					ON
						Projects.ProjectField2=ProjectField2.id
			WHERE
				Projects.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->set('Description', htmlspecialchars($obj->get('Description')));

		require 'views/iprojectweb_projectsasform.php';

	}

	/**
	 * 	getASList
	 *
	 * 	returns an array prepared to show in the ajax suggestion list
	 *
	 * @param array $map
	 * 	request data
	 */
	function getASList($map) {

		$query = "SELECT id, Description FROM #wp__iprojectweb_projects";
		if (isset($map['oid'])) {
			$objid = intval($map['oid']);
			$query .= " WHERE id ='$objid'";
		}
		else {
			$query .= " WHERE Description LIKE :input";
		}
		return $this->getBasicASList($map, $query);

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

		$query = "SELECT
				Projects.id,
				Projects.Description,
				Projects.Status,
				Projects.StartDate,
				Projects.FinishDate,
				Projects.ObjectOwner,
				Projects.ProjectField1,
				Projects.ProjectField2,
				Projects.ProjectDescription,
				Projects.History,
				Projects.ProjectField3,
				Projects.ProjectField4,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription
			FROM
				#wp__iprojectweb_projects AS Projects
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Projects.ObjectOwner=Users.id
			WHERE
				Projects.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->set('Description', htmlspecialchars($obj->get('Description')));
		$obj->StartDate = iProjectWebUtils::getDate($obj->get('StartDate'));
		$obj->FinishDate = iProjectWebUtils::getDate($obj->get('FinishDate'));

		$obj->ObjectOwner = (object) array();
		$obj->ObjectOwner->view = $obj;
		$obj->ObjectOwner->field = 'ObjectOwner';
		$obj->ObjectOwner->type = 'Users';
		$obj->ObjectOwner->config['m2'] = 'getUserASList';
		$obj->ObjectOwner->config['t'] = 'Users';
		$obj->ObjectOwner->asparams['listItemClass'] = 'ufo-user-list-item';

		$obj->set('ProjectDescription', htmlspecialchars($obj->get('ProjectDescription')));
		$obj->set('ProjectField3', htmlspecialchars($obj->get('ProjectField3')));
		$obj->set('ProjectField4', htmlspecialchars($obj->get('ProjectField4')));

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_projectsmainform.php';

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

		$query = "SELECT
				Projects.id,
				Projects.StartDate,
				Projects.FinishDate,
				Projects.ProjectDescription,
				Projects.History,
				Projects.ProjectField3,
				Projects.ProjectField4,
				ProjectStatuses.ListPosition AS StatusListPosition,
				ProjectStatuses.Description AS StatusDescription,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Projects.ObjectOwner AS ObjectOwner,
				ProjectField1.Description AS ProjectField1Description,
				ProjectField2.Description AS ProjectField2Description
			FROM
				#wp__iprojectweb_projects AS Projects
			LEFT JOIN
				#wp__iprojectweb_projectstatuses AS ProjectStatuses
					ON
						Projects.Status=ProjectStatuses.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Projects.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_projectfield1 AS ProjectField1
					ON
						Projects.ProjectField1=ProjectField1.id
			LEFT JOIN
				#wp__iprojectweb_projectfield2 AS ProjectField2
					ON
						Projects.ProjectField2=ProjectField2.id
			WHERE
				Projects.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->set('ProjectField3', htmlspecialchars($obj->get('ProjectField3')));
		$obj->set('ProjectField4', htmlspecialchars($obj->get('ProjectField4')));

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_projectsreadonlyform.php';

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
			'Description',
			'StartDate',
			'FinishDate',
			'ObjectOwnerDescription',
		);
		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "Projects.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'StartDate', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'FinishDate', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ObjectOwner', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectDescription');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'History');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectField3');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectField4');
		iProjectWebRoot::mDelete('Projects', $viewmap);

		$query = "SELECT
				Projects.id,
				Projects.Description,
				Projects.StartDate,
				Projects.FinishDate,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Projects.ObjectOwner AS ObjectOwner
			FROM
				#wp__iprojectweb_projects AS Projects
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Projects.ObjectOwner=Users.id";

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
		?><input type='hidden' name='t' id='t' value='Projects'><?php

		require_once 'views/iprojectweb_projectsmainview.php';

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
		$orderby = iProjectWebDB::getOrderBy(array('id', 'Description'), $spar, "Projects.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getMTMFilter($viewmap, $viewfilters, 'Projects');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'Description');

		$query = "SELECT
				Projects.id,
				Projects.Description
			FROM
				#wp__iprojectweb_projects AS Projects";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->showlist = FALSE;
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Projects'><?php

		require_once 'views/iprojectweb_projectsmanagemainview.php';

	}

	/**
	 * 	getPMView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getPMView($viewmap) {

		$spar = $this->getOrder($viewmap);
		$sortfields = array(
			'id',
			'Description',
			'StatusListPosition',
			'StartDate',
			'FinishDate',
		);
		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "Projects.Description");
		$userid = $this->user->id;

		$rparams = array();
		$rparams['Status'] = iProjectWebDB::getStatusFilter('ProjectStatuses');
		$rparams = $this->getFilter($viewmap, $rparams);
		$viewfilters = array();
		$viewfilters['skipWhere'] = TRUE;
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'Status', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'StartDate', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'FinishDate', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectDescription');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'History');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectField3');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectField4');

		$query = "SELECT
				Projects.id,
				Projects.Description,
				Projects.Status,
				Projects.StartDate,
				Projects.FinishDate,
				ProjectStatuses.Description AS StatusDescription
			FROM
				#wp__iprojectweb_projects AS Projects
			LEFT JOIN
				#wp__iprojectweb_projectstatuses AS ProjectStatuses
					ON
						Projects.Status=ProjectStatuses.id
			WHERE
				Projects.ObjectOwner='$userid'";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Projects'><?php

		require_once 'views/iprojectweb_projectspmview.php';

	}

	/**
	 * 	getTeamMemberView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getTeamMemberView($viewmap) {

		$spar = $this->getOrder($viewmap);
		$sortfields = array(
			'id',
			'Description',
			'StartDate',
			'FinishDate',
			'ObjectOwnerDescription',
		);
		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "Projects.Description");

		$rparams = array();
		$rparams['Status'] = iProjectWebDB::getStatusFilter('ProjectStatuses');
		$rparams = $this->getFilter($viewmap, $rparams);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'StartDate', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'FinishDate', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ObjectOwner', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectDescription');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'History');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectField3');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects.', 'ProjectField4');

		$query = "SELECT
				Projects.id,
				Projects.Description,
				Projects.StartDate,
				Projects.FinishDate,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Projects.ObjectOwner AS ObjectOwner
			FROM
				#wp__iprojectweb_projects AS Projects
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Projects.ObjectOwner=Users.id";

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
		?><input type='hidden' name='t' id='t' value='Projects'><?php

		require_once 'views/iprojectweb_projectsteammemberview.php';

	}

}
