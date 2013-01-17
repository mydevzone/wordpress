<?php

/**
 * @file
 *
 * 	iProjectWebProjectFiles class definition
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
 * 	iProjectWebProjectFiles
 *
 */
class iProjectWebProjectFiles extends iProjectWebBase {

	/**
	 * 	iProjectWebProjectFiles class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'ProjectFiles';

		$this->fieldmap = array(
				'id' => NULL,
				'Description' => '',
				'Date' => 0,
				'ObjectOwner' => 0,
				'Notes' => '',
				'Projects' => 0,
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a projectfile
	 * 	record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$query = "SELECT id FROM #wp__iprojectweb_files WHERE doctype='ProjectFiles' AND docid=$id;";
		iProjectWebDB::cDelete($query, 'Files');

		$stmts[] = "DELETE FROM #wp__iprojectweb_projectfiles WHERE id=$id;";

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

		$request = iProjectWebUtils::parseRequest($request, 'Date', 'date');
		$request = iProjectWebUtils::parseRequest($request, 'ObjectOwner', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Projects', 'int');

		parent::update($request, $id);

	}

	/**
	 * 	getEmptyObject. Overrides iProjectWebBase::getEmptyObject()
	 *
	 * 	creates and initializes a new ProjectFile
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
		$fields->Date = iProjectWebUtils::getDate(NULL, TRUE);
		$fields->Projects = iProjectWebDB::getFirst('Projects');

		return parent::getEmptyObject($map, $fields);

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
	 * 	getMainForm
	 *
	 * 	prepares the view data and finally passes it to the html template
	 *
	 * @param array $formmap
	 * 	request data
	 */
	function getMainForm($formmap) {

		$query = "SELECT
				ProjectFiles.id,
				ProjectFiles.Description,
				ProjectFiles.ObjectOwner,
				ProjectFiles.Date,
				ProjectFiles.Projects,
				ProjectFiles.Notes,
				Projects.Description AS ProjectsDescription
			FROM
				#wp__iprojectweb_projectfiles AS ProjectFiles
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						ProjectFiles.Projects=Projects.id
			WHERE
				ProjectFiles.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$files = iProjectWebClassLoader::getObject('Files');

		$obj->set('Description', htmlspecialchars($obj->get('Description')));

		$obj->ObjectOwner = (object) array();
		$obj->ObjectOwner->view = $obj;
		$obj->ObjectOwner->field = 'ObjectOwner';
		$obj->ObjectOwner->type = 'Users';
		$obj->ObjectOwner->config['m2'] = 'getUserASList';
		$obj->ObjectOwner->config['t'] = 'Users';
		$obj->ObjectOwner->asparams['listItemClass'] = 'ufo-user-list-item';

		$obj->Date = iProjectWebUtils::getDate($obj->get('Date'));

		$obj->Projects = (object) array();
		$obj->Projects->view = $obj;
		$obj->Projects->field = 'Projects';
		$obj->Projects->type = 'Projects';
		$obj->Projects->config['m2'] = 'getASList';
		$obj->Projects->config['t'] = 'Projects';

		$obj->set('Notes', htmlspecialchars($obj->get('Notes')));

		$obj->File = (object) array();
		$obj->File->request = (object) array();
		$obj->File->request->fld = 'File';
		$obj->File->request->oid = $obj->getId();
		$obj->File->request->t = 'ProjectFiles';
		$obj->File->oncomplete = (object) array();
		$obj->File->oncomplete->func = 'apply';
		$obj->File->oncomplete->args = $obj->jsconfig;

		$obj->File->value = $files->getFileValue('Name', 'File', $obj);

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_projectfilesmainform.php';

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
				ProjectFiles.id,
				ProjectFiles.Date,
				ProjectFiles.Notes,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				ProjectFiles.ObjectOwner AS ObjectOwner,
				Projects.Description AS ProjectsDescription
			FROM
				#wp__iprojectweb_projectfiles AS ProjectFiles
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						ProjectFiles.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						ProjectFiles.Projects=Projects.id
			WHERE
				ProjectFiles.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$files = iProjectWebClassLoader::getObject('Files');

		$obj->File = array(
				'doctype' => 'ProjectFiles',
				'docid' => $obj->get('id'),
				'field' => 'File',
				'tag' => 'a',
				'content' => IPROJECTWEB_Download,
			);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_projectfilesreadonlyform.php';

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
			'Date',
			'ObjectOwnerDescription',
			'ProjectsDescription',
		);

		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "ProjectFiles.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'ProjectFiles.', 'Projects', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'Date', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'ObjectOwner', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'Notes');
		iProjectWebRoot::mDelete('ProjectFiles', $viewmap);

		$query = "SELECT
				ProjectFiles.id,
				ProjectFiles.Description,
				ProjectFiles.Date,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				ProjectFiles.ObjectOwner AS ObjectOwner,
				Projects.Description AS ProjectsDescription,
				ProjectFiles.Projects AS Projects
			FROM
				#wp__iprojectweb_projectfiles AS ProjectFiles
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						ProjectFiles.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						ProjectFiles.Projects=Projects.id";

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
		?><input type='hidden' name='t' id='t' value='ProjectFiles'><?php

		require_once 'views/iprojectweb_projectfilesdetailedmainview.php';

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
			'Date',
			'ObjectOwnerDescription',
			'ProjectsDescription',
		);

		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "ProjectFiles.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'Date', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'ObjectOwner', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'Notes');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'ProjectFiles.', 'Projects', 'int');
		iProjectWebRoot::mDelete('ProjectFiles', $viewmap);

		$query = "SELECT
				ProjectFiles.id,
				ProjectFiles.Description,
				ProjectFiles.Date,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				ProjectFiles.ObjectOwner AS ObjectOwner,
				Projects.Description AS ProjectsDescription,
				ProjectFiles.Projects AS Projects
			FROM
				#wp__iprojectweb_projectfiles AS ProjectFiles
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						ProjectFiles.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						ProjectFiles.Projects=Projects.id";

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
		?><input type='hidden' name='t' id='t' value='ProjectFiles'><?php

		require_once 'views/iprojectweb_projectfilesmainview.php';

	}

}
