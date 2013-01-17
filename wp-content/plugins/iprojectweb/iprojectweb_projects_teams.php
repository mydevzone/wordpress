<?php

/**
 * @file
 *
 * 	iProjectWebProjects_Teams class definition
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
 * 	iProjectWebProjects_Teams
 *
 */
class iProjectWebProjects_Teams extends iProjectWebBase {

	/**
	 * 	iProjectWebProjects_Teams class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'Projects_Teams';
		$this->fieldmap = array(
				'id' => NULL,
				'Projects' => 0,
				'Members' => 0,
				'Role' => 0,
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a projectteam
	 * 	record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$stmts[] = "DELETE FROM #wp__iprojectweb_projects_teams WHERE id=$id;";

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

		$request = iProjectWebUtils::parseRequest($request, 'Projects', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Members', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Role', 'int');

		parent::update($request, $id);

	}

	/**
	 * 	getProjectsMainView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getProjectsMainView($viewmap) {

		$spar = $this->getOrder($viewmap);
		$orderby = iProjectWebDB::getOrderBy(array('id', 'MembersDescription', 'Role'), $spar);

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'Projects_Teams.', 'Projects', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects_Teams.', 'Members', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects_Teams.', 'Role', 'int');
		iProjectWebRoot::mDelete('Projects_Teams', $viewmap);

		$query = "SELECT
				Projects_Teams.id,
				Projects_Teams.Role,
				CONCAT(Users.Description, ' ', Users.Name) AS MembersDescription,
				Projects_Teams.Members AS Members
			FROM
				#wp__iprojectweb_projects_teams AS Projects_Teams
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Projects_Teams.Members=Users.id";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->Members = (object) array();
		$this->Members->view = $this;
		$this->Members->field = 'Members';
		$this->Members->filter = TRUE;
		$this->Members->config['m2'] = 'getUserASList';
		$this->Members->config['t'] = 'Users';
		$this->Members->asparams['listItemClass'] = 'ufo-user-list-item';
		$this->Members->inpstyle = " style='width:130px;'";

		$this->objid = $rparams['Projects']->values[0];
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Projects_Teams'><?php

		require_once 'views/iprojectweb_projects_teamsprojectsmainview.php';

	}

	/**
	 * 	getProjectsReadonlyView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getProjectsReadonlyView($viewmap) {

		$spar = $this->getOrder($viewmap);
		$orderby = iProjectWebDB::getOrderBy(array('id', 'MembersDescription', 'RoleDescription'), $spar);

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'Projects_Teams.', 'Projects', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects_Teams.', 'Members', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects_Teams.', 'Role', 'int');

		$query = "SELECT
				Projects_Teams.id,
				CONCAT(Users.Description, ' ', Users.Name) AS MembersDescription,
				Projects_Teams.Members AS Members,
				ProjectRoles.Description AS RoleDescription
			FROM
				#wp__iprojectweb_projects_teams AS Projects_Teams
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Projects_Teams.Members=Users.id
			LEFT JOIN
				#wp__iprojectweb_projectroles AS ProjectRoles
					ON
						Projects_Teams.Role=ProjectRoles.id";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->Members = (object) array();
		$this->Members->view = $this;
		$this->Members->field = 'Members';
		$this->Members->filter = TRUE;
		$this->Members->config['m2'] = 'getUserASList';
		$this->Members->config['t'] = 'Users';
		$this->Members->asparams['listItemClass'] = 'ufo-user-list-item';
		$this->Members->inpstyle = " style='width:130px;'";

		$this->objid = $rparams['Projects']->values[0];
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Projects_Teams'><?php

		require_once 'views/iprojectweb_projects_teamsprojectsreadonlyview.php';

	}

	/**
	 * 	getUsersMainView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getUsersMainView($viewmap) {

		$spar = $this->getOrder($viewmap);
		$orderby = iProjectWebDB::getOrderBy(array('id', 'ProjectsDescription', 'Role'), $spar);

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'Projects_Teams.', 'Members', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects_Teams.', 'Projects', 'int');
		iProjectWebRoot::mDelete('Projects_Teams', $viewmap);

		$query = "SELECT
				Projects_Teams.id,
				Projects_Teams.Role,
				Projects.Description AS ProjectsDescription,
				Projects_Teams.Projects AS Projects
			FROM
				#wp__iprojectweb_projects_teams AS Projects_Teams
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Projects_Teams.Projects=Projects.id";

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

		$this->objid = $rparams['Members']->values[0];
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Projects_Teams'><?php

		require_once 'views/iprojectweb_projects_teamsusersmainview.php';

	}

	/**
	 * 	getUsersReadonlyView
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $viewmap
	 * 	request data
	 */
	function getUsersReadonlyView($viewmap) {

		$spar = $this->getOrder($viewmap);
		$orderby = iProjectWebDB::getOrderBy(array('id', 'ProjectsDescription', 'RoleDescription'), $spar);

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'Projects_Teams.', 'Members', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects_Teams.', 'Projects', 'int');

		$query = "SELECT
				Projects_Teams.id,
				Projects.Description AS ProjectsDescription,
				Projects_Teams.Projects AS Projects,
				ProjectRoles.Description AS RoleDescription
			FROM
				#wp__iprojectweb_projects_teams AS Projects_Teams
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Projects_Teams.Projects=Projects.id
			LEFT JOIN
				#wp__iprojectweb_projectroles AS ProjectRoles
					ON
						Projects_Teams.Role=ProjectRoles.id";

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

		$this->objid = $rparams['Members']->values[0];
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Projects_Teams'><?php

		require_once 'views/iprojectweb_projects_teamsusersreadonlyview.php';

	}

}
