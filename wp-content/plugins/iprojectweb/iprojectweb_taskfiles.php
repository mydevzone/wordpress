<?php

/**
 * @file
 *
 * 	iProjectWebTaskFiles class definition
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
 * 	iProjectWebTaskFiles
 *
 */
class iProjectWebTaskFiles extends iProjectWebBase {

	/**
	 * 	iProjectWebTaskFiles class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'TaskFiles';

		$this->fieldmap = array(
				'id' => NULL,
				'Description' => '',
				'Date' => 0,
				'ObjectOwner' => 0,
				'Notes' => '',
				'Tasks' => 0,
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a taskfile record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$query = "SELECT id FROM #wp__iprojectweb_files WHERE doctype='TaskFiles' AND docid=$id;";
		iProjectWebDB::cDelete($query, 'Files');

		$stmts[] = "DELETE FROM #wp__iprojectweb_taskfiles WHERE id=$id;";

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
		$request = iProjectWebUtils::parseRequest($request, 'Tasks', 'int');

		parent::update($request, $id);

	}

	/**
	 * 	getEmptyObject. Overrides iProjectWebBase::getEmptyObject()
	 *
	 * 	creates and initializes a new TaskFile
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
		$fields->Tasks = iProjectWebDB::getFirst('Tasks');

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

		$fields = array();
		$fields[] = 'id';
		$fields[] = 'Description';
		$fields[] = 'Date';
		$fields[] = 'ObjectOwner';
		$fields[] = 'Tasks';
		$fields[] = 'Notes';

		$obj = $this->formInit($formmap, $fields);

		$files = iProjectWebClassLoader::getObject('Files');

		$obj->set('Description', htmlspecialchars($obj->get('Description')));
		$obj->Date = iProjectWebUtils::getDate($obj->get('Date'));

		$obj->ObjectOwner = (object) array();
		$obj->ObjectOwner->view = $obj;
		$obj->ObjectOwner->field = 'ObjectOwner';
		$obj->ObjectOwner->type = 'Users';
		$obj->ObjectOwner->config['t'] = 'Users';
		$obj->ObjectOwner->config['m2'] = 'getUserASList';
		$obj->ObjectOwner->asparams['listItemClass'] = 'ufo-user-list-item';

		$obj->Tasks = (object) array();
		$obj->Tasks->view = $obj;
		$obj->Tasks->field = 'Tasks';
		$obj->Tasks->type = 'Tasks';
		$obj->Tasks->config['m2'] = 'getASList';
		$obj->Tasks->config['t'] = 'Tasks';

		$obj->set('Notes', htmlspecialchars($obj->get('Notes')));

		$obj->File = (object) array();
		$obj->File->request = (object) array();
		$obj->File->request->fld = 'File';
		$obj->File->request->oid = $obj->getId();
		$obj->File->request->t = 'TaskFiles';
		$obj->File->oncomplete = (object) array();
		$obj->File->oncomplete->func = 'apply';
		$obj->File->oncomplete->args = $obj->jsconfig;

		$obj->File->value = $files->getFileValue('Name', 'File', $obj);

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_taskfilesmainform.php';

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
				TaskFiles.id,
				TaskFiles.Date,
				TaskFiles.Notes,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				TaskFiles.ObjectOwner AS ObjectOwner,
				Tasks.Description AS TasksDescription
			FROM
				#wp__iprojectweb_taskfiles AS TaskFiles
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						TaskFiles.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_tasks AS Tasks
					ON
						TaskFiles.Tasks=Tasks.id
			WHERE
				TaskFiles.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$files = iProjectWebClassLoader::getObject('Files');

		$obj->File = array(
				'doctype' => 'TaskFiles',
				'docid' => $obj->get('id'),
				'field' => 'File',
				'tag' => 'a',
				'content' => IPROJECTWEB_Download,
			);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_taskfilesreadonlyform.php';

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
			'TasksDescription',
		);
		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "TaskFiles.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'TaskFiles.', 'Tasks', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'Date', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'ObjectOwner', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'Notes');
		iProjectWebRoot::mDelete('TaskFiles', $viewmap);

		$query = "SELECT
				TaskFiles.id,
				TaskFiles.Description,
				TaskFiles.Date,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				TaskFiles.ObjectOwner AS ObjectOwner,
				Tasks.Description AS TasksDescription,
				TaskFiles.Tasks AS Tasks
			FROM
				#wp__iprojectweb_taskfiles AS TaskFiles
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						TaskFiles.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_tasks AS Tasks
					ON
						TaskFiles.Tasks=Tasks.id";

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
		?><input type='hidden' name='t' id='t' value='TaskFiles'><?php

		require_once 'views/iprojectweb_taskfilesdetailedmainview.php';

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
			'TasksDescription',
		);
		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "TaskFiles.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'Date', 'date');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'ObjectOwner', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'Notes');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'TaskFiles.', 'Tasks', 'int');
		iProjectWebRoot::mDelete('TaskFiles', $viewmap);

		$query = "SELECT
				TaskFiles.id,
				TaskFiles.Description,
				TaskFiles.Date,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				TaskFiles.ObjectOwner AS ObjectOwner,
				Tasks.Description AS TasksDescription,
				TaskFiles.Tasks AS Tasks
			FROM
				#wp__iprojectweb_taskfiles AS TaskFiles
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						TaskFiles.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_tasks AS Tasks
					ON
						TaskFiles.Tasks=Tasks.id";

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

		$this->Tasks = (object) array();
		$this->Tasks->view = $this;
		$this->Tasks->field = 'Tasks';
		$this->Tasks->filter = TRUE;
		$this->Tasks->config['m2'] = 'getASList';
		$this->Tasks->config['t'] = 'Tasks';
		$this->Tasks->inpstyle = " style='width:130px;'";

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='TaskFiles'><?php

		require_once 'views/iprojectweb_taskfilesmainview.php';

	}

}
