<?php

/**
 * @file
 *
 * 	iProjectWebTasks class definition
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
 * 	iProjectWebTasks
 *
 */
class iProjectWebTasks extends iProjectWebBase {

	/**
	 * 	iProjectWebTasks class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'Tasks';

		$this->fieldmap = array(
				'id' => NULL,
				'Description' => '',
				'Projects' => 0,
				'Priority' => 0,
				'Status' => 0,
				'Type' => 0,
				'ObjectOwner' => 0,
				'PlannedDeadline' => 0,
				'PlannedEffort' => 0,
				'ActualDeadline' => 0,
				'ActualEffort' => 0,
				'Notes' => '',
				'History' => '',
				'Comment' => '',
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a task record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$stmts[] = "DELETE FROM #wp__iprojectweb_tasks_mailinglists WHERE Tasks=$id;";

		$query = "SELECT id FROM #wp__iprojectweb_taskfiles WHERE Tasks=$id;";
		iProjectWebDB::cDelete($query, 'TaskFiles');

		$stmts[] = "DELETE FROM #wp__iprojectweb_tasks WHERE id=$id;";

		return $stmts;

	}

	/**
	 * 	getEmptyObject. Overrides iProjectWebBase::getEmptyObject()
	 *
	 * 	creates and initializes a new Task
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
		$fields->Projects = iProjectWebDB::getFirst('Projects');
		$fields->Priority = iProjectWebDB::getFirst('Priorities', TRUE);
		$fields->Status = iProjectWebDB::getFirst('TaskStatuses', TRUE);
		$fields->Type = iProjectWebDB::getFirst('TaskTypes', TRUE);

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

		$request = iProjectWebUtils::parseRequest($request, 'Projects', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Priority', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Status', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Type', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'ObjectOwner', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'PlannedDeadline', 'date');
		$request = iProjectWebUtils::parseRequest($request, 'PlannedEffort', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'ActualDeadline', 'date');
		$request = iProjectWebUtils::parseRequest($request, 'ActualEffort', 'int');

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

			case 'detailedmain':
				return $this->getDetailedMainView($vmap);
				break;

			case 'managemain':
				return $this->getManageMainView($vmap);
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
				Tasks.id,
				Tasks.PlannedDeadline,
				Tasks.Notes,
				Tasks.Description,
				Projects.Description AS ProjectsDescription,
				Priorities.ListPosition AS PriorityListPosition,
				Priorities.Description AS PriorityDescription,
				TaskStatuses.ListPosition AS StatusListPosition,
				TaskStatuses.Description AS StatusDescription,
				TaskTypes.ListPosition AS TypeListPosition,
				TaskTypes.Description AS TypeDescription,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription
			FROM
				#wp__iprojectweb_tasks AS Tasks
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Tasks.Projects=Projects.id
			LEFT JOIN
				#wp__iprojectweb_priorities AS Priorities
					ON
						Tasks.Priority=Priorities.id
			LEFT JOIN
				#wp__iprojectweb_taskstatuses AS TaskStatuses
					ON
						Tasks.Status=TaskStatuses.id
			LEFT JOIN
				#wp__iprojectweb_tasktypes AS TaskTypes
					ON
						Tasks.Type=TaskTypes.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Tasks.ObjectOwner=Users.id
			WHERE
				Tasks.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->set('Description', htmlspecialchars($obj->get('Description')));

		require 'views/iprojectweb_tasksasform.php';

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

		$query = "SELECT id, Description FROM #wp__iprojectweb_tasks";
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
				Tasks.id,
				Tasks.Description,
				Tasks.Projects,
				Tasks.Priority,
				Tasks.Status,
				Tasks.Type,
				Tasks.ObjectOwner,
				Tasks.PlannedDeadline,
				Tasks.PlannedEffort,
				Tasks.ActualDeadline,
				Tasks.ActualEffort,
				Tasks.Notes,
				Tasks.History,
				Projects.Description AS ProjectsDescription,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription
			FROM
				#wp__iprojectweb_tasks AS Tasks
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Tasks.Projects=Projects.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Tasks.ObjectOwner=Users.id
			WHERE
				Tasks.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->set('Description', htmlspecialchars($obj->get('Description')));

		$obj->Projects = (object) array();
		$obj->Projects->view = $obj;
		$obj->Projects->field = 'Projects';
		$obj->Projects->type = 'Projects';
		$obj->Projects->config['m2'] = 'getASList';
		$obj->Projects->config['t'] = 'Projects';

		$obj->ObjectOwner = (object) array();
		$obj->ObjectOwner->view = $obj;
		$obj->ObjectOwner->field = 'ObjectOwner';
		$obj->ObjectOwner->type = 'Users';
		$obj->ObjectOwner->config['m2'] = 'getUserASList';
		$obj->ObjectOwner->config['t'] = 'Users';
		$obj->ObjectOwner->asparams['listItemClass'] = 'ufo-user-list-item';

		$obj->PlannedDeadline = iProjectWebUtils::getDate($obj->get('PlannedDeadline'));
		$obj->ActualDeadline = iProjectWebUtils::getDate($obj->get('ActualDeadline'));
		$obj->set('Notes', htmlspecialchars($obj->get('Notes')));

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_tasksmainform.php';

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
				Tasks.id,
				Tasks.PlannedDeadline,
				Tasks.PlannedEffort,
				Tasks.ActualDeadline,
				Tasks.ActualEffort,
				Tasks.Notes,
				Tasks.History,
				Projects.Description AS ProjectsDescription,
				Priorities.ListPosition AS PriorityListPosition,
				Priorities.Description AS PriorityDescription,
				TaskStatuses.ListPosition AS StatusListPosition,
				TaskStatuses.Description AS StatusDescription,
				TaskTypes.ListPosition AS TypeListPosition,
				TaskTypes.Description AS TypeDescription,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Tasks.ObjectOwner AS ObjectOwner
			FROM
				#wp__iprojectweb_tasks AS Tasks
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Tasks.Projects=Projects.id
			LEFT JOIN
				#wp__iprojectweb_priorities AS Priorities
					ON
						Tasks.Priority=Priorities.id
			LEFT JOIN
				#wp__iprojectweb_taskstatuses AS TaskStatuses
					ON
						Tasks.Status=TaskStatuses.id
			LEFT JOIN
				#wp__iprojectweb_tasktypes AS TaskTypes
					ON
						Tasks.Type=TaskTypes.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Tasks.ObjectOwner=Users.id
			WHERE
				Tasks.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_tasksreadonlyform.php';

	}

	/**
	 * 	getDetailedMainView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getDetailedMainView($viewmap) {

		$spar = $this->getOrder($viewmap);

		$sortfields = array(
			'id',
			'Description',
			'PriorityListPosition',
			'PlannedDeadline',
			'PlannedEffort',
			'ProjectsDescription',
		);

		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "Tasks.Description");

		$rparams = array();
		$rparams['Status'] = iProjectWebDB::getStatusFilter('TaskStatuses');
		$rparams = $this->getFilter($viewmap, $rparams);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'Tasks.', 'Projects', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Priority', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Status', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Type', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'ObjectOwner', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'PlannedDeadline', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'PlannedEffort', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'ActualDeadline', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'ActualEffort', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Notes');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'History');
		iProjectWebRoot::mDelete('Tasks', $viewmap);

		$query = "SELECT
				Tasks.id,
				Tasks.Description,
				Tasks.PlannedDeadline,
				Tasks.PlannedEffort,
				Priorities.ListPosition AS PriorityListPosition,
				Priorities.Description AS PriorityDescription,
				Projects.Description AS ProjectsDescription,
				Tasks.Projects AS Projects
			FROM
				#wp__iprojectweb_tasks AS Tasks
			LEFT JOIN
				#wp__iprojectweb_priorities AS Priorities
					ON
						Tasks.Priority=Priorities.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Tasks.Projects=Projects.id";

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
		?><input type='hidden' name='t' id='t' value='Tasks'><?php

		require_once 'views/iprojectweb_tasksdetailedmainview.php';

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
			'PriorityListPosition',
			'ObjectOwnerDescription',
			'PlannedDeadline',
			'ProjectsDescription',
		);

		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "Tasks.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Priority', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'ObjectOwner', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'PlannedDeadline', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'PlannedEffort', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'ActualDeadline', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'ActualEffort', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Notes');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'History');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Projects', 'int');
		iProjectWebRoot::mDelete('Tasks', $viewmap);

		$query = "SELECT
				Tasks.id,
				Tasks.Description,
				Tasks.PlannedDeadline,
				Priorities.ListPosition AS PriorityListPosition,
				Priorities.Description AS PriorityDescription,
				Tasks.Priority AS Priority,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Tasks.ObjectOwner AS ObjectOwner,
				Projects.Description AS ProjectsDescription,
				Tasks.Projects AS Projects
			FROM
				#wp__iprojectweb_tasks AS Tasks
			LEFT JOIN
				#wp__iprojectweb_priorities AS Priorities
					ON
						Tasks.Priority=Priorities.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Tasks.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Tasks.Projects=Projects.id";

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

		$this->Projects = (object) array();
		$this->Projects->view = $this;
		$this->Projects->field = 'Projects';
		$this->Projects->filter = TRUE;
		$this->Projects->config['m2'] = 'getASList';
		$this->Projects->config['t'] = 'Projects';
		$this->Projects->inpstyle = " style='width:130px;'";

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Tasks'><?php

		require_once 'views/iprojectweb_tasksmainview.php';

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
		$orderby = iProjectWebDB::getOrderBy(array('id', 'Description'), $spar, "Tasks.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getMTMFilter($viewmap, $viewfilters, 'Tasks');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Description');

		$query = "SELECT
				Tasks.id,
				Tasks.Description
			FROM
				#wp__iprojectweb_tasks AS Tasks";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->showlist = FALSE;
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Tasks'><?php

		require_once 'views/iprojectweb_tasksmanagemainview.php';

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
			'Description',
			'PriorityListPosition',
			'StatusListPosition',
			'TypeListPosition',
			'ProjectsDescription',
		);

		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "Tasks.Description");
		$userid = $this->user->id;

		$rparams = array();
		$rparams['Status'] = iProjectWebDB::getStatusFilter('TaskStatuses');
		$rparams = $this->getFilter($viewmap, $rparams);
		$viewfilters = array();
		$viewfilters['skipWhere'] = TRUE;
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Priority', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Status', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Type', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'PlannedDeadline', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'PlannedEffort', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'ActualDeadline', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'ActualEffort', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Notes');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'History');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Tasks.', 'Projects', 'int');
		iProjectWebRoot::mDelete('Tasks', $viewmap);

		$query = "SELECT
				Tasks.id,
				Tasks.Description,
				Tasks.Priority,
				Tasks.Status,
				Tasks.Type,
				Tasks.Projects,
				Priorities.Description AS PriorityDescription,
				TaskStatuses.Description AS StatusDescription,
				Projects.Description AS ProjectsDescription,
				TaskTypes.Description AS TypeDescription,
				Priorities.ListPosition AS PriorityListPosition,
				TaskStatuses.ListPosition AS StatusListPosition,
				TaskTypes.ListPosition AS TypeListPosition
			FROM
				#wp__iprojectweb_tasks AS Tasks
			LEFT JOIN
				#wp__iprojectweb_priorities AS Priorities
					ON
						Tasks.Priority=Priorities.id
			LEFT JOIN
				#wp__iprojectweb_taskstatuses AS TaskStatuses
					ON
						Tasks.Status=TaskStatuses.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Tasks.Projects=Projects.id
			LEFT JOIN
				#wp__iprojectweb_tasktypes AS TaskTypes
					ON
						Tasks.Type=TaskTypes.id
			WHERE
				Tasks.id IN (
				SELECT
					Tasks.id
				FROM
					#wp__iprojectweb_tasks AS Tasks
				WHERE
					Tasks.ObjectOwner='$userid')";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->Projects = (object) array();
		$this->Projects->view = $this;
		$this->Projects->field = 'Projects';
		$this->Projects->filter = TRUE;
		$this->Projects->config['m2'] = 'getASList';
		$this->Projects->config['t'] = 'Projects';
		$this->Projects->inpstyle = " style='width:130px;'";

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Tasks'><?php

		require_once 'views/iprojectweb_tasksteammemberview.php';

	}

}
