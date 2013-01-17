<?php

/**
 * @file
 *
 * 	iProjectWebProjects_MailingLists class definition
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
 * 	iProjectWebProjects_MailingLists
 *
 */
class iProjectWebProjects_MailingLists extends iProjectWebBase {

	/**
	 * 	iProjectWebProjects_MailingLists class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'Projects_MailingLists';
		$this->fieldmap = array('id' => NULL, 'Projects' => 0, 'Contacts' => 0);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a
	 * 	projectmailinglist record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$stmts[] = "DELETE FROM #wp__iprojectweb_projects_mailinglists WHERE id=$id;";

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
		$request = iProjectWebUtils::parseRequest($request, 'Contacts', 'int');

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
		$orderby = iProjectWebDB::getOrderBy(array('id', 'ContactsDescription'), $spar);

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'Projects_MailingLists.', 'Projects', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects_MailingLists.', 'Contacts', 'int');
		iProjectWebRoot::mDelete('Projects_MailingLists', $viewmap);

		$query = "SELECT
				Projects_MailingLists.id,
				CONCAT(Users.Description, ' ', Users.Name) AS ContactsDescription,
				Projects_MailingLists.Contacts AS Contacts
			FROM
				#wp__iprojectweb_projects_mailinglists AS Projects_MailingLists
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Projects_MailingLists.Contacts=Users.id";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->Contacts = (object) array();
		$this->Contacts->view = $this;
		$this->Contacts->field = 'Contacts';
		$this->Contacts->filter = TRUE;
		$this->Contacts->config['m2'] = 'getUserASList';
		$this->Contacts->config['t'] = 'Users';
		$this->Contacts->asparams['listItemClass'] = 'ufo-user-list-item';
		$this->Contacts->inpstyle = " style='width:130px;'";

		$this->objid = $rparams['Projects']->values[0];
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Projects_MailingLists'><?php

		require_once 'views/iprojectweb_projects_mailinglistsprojectsmainview.php';

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
		$orderby = iProjectWebDB::getOrderBy(array('id', 'ProjectsDescription'), $spar);

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'Projects_MailingLists.', 'Contacts', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Projects_MailingLists.', 'Projects', 'int');
		iProjectWebRoot::mDelete('Projects_MailingLists', $viewmap);

		$query = "SELECT
				Projects_MailingLists.id,
				Projects.Description AS ProjectsDescription,
				Projects_MailingLists.Projects AS Projects
			FROM
				#wp__iprojectweb_projects_mailinglists AS Projects_MailingLists
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Projects_MailingLists.Projects=Projects.id";

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

		$this->objid = $rparams['Contacts']->values[0];
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Projects_MailingLists'><?php

		require_once 'views/iprojectweb_projects_mailinglistsusersmainview.php';

	}

}
