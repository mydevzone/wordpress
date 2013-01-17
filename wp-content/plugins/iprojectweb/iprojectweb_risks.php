<?php

/**
 * @file
 *
 * 	iProjectWebRisks class definition
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
 * 	iProjectWebRisks
 *
 */
class iProjectWebRisks extends iProjectWebBase {

	/**
	 * 	iProjectWebRisks class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'Risks';

		$this->fieldmap = array(
				'id' => NULL,
				'Description' => '',
				'Type' => 0,
				'Status' => 0,
				'Impact' => 0,
				'MitigationStrategy' => 0,
				'Probability' => 0,
				'RiskDescription' => '',
				'MitigationPlan' => '',
				'Comment' => '',
				'History' => '',
				'Projects' => 0,
				'ObjectOwner' => 0,
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a risk record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$stmts[] = "DELETE FROM #wp__iprojectweb_risks_mailinglists WHERE Risks=$id;";

		$stmts[] = "DELETE FROM #wp__iprojectweb_risks WHERE id=$id;";

		return $stmts;

	}

	/**
	 * 	getEmptyObject. Overrides iProjectWebBase::getEmptyObject()
	 *
	 * 	creates and initializes a new Risk
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
		$fields->Type = iProjectWebDB::getFirst('RiskTypes', TRUE);
		$fields->Status = iProjectWebDB::getFirst('RiskStatuses', TRUE);
		$fields->Impact = iProjectWebDB::getFirst('RiskImpacts', TRUE);
		$fields->MitigationStrategy = iProjectWebDB::getFirst('RiskStrategies');
		$fields->Probability = iProjectWebDB::getFirst('RiskProbabilities', TRUE);
		$fields->Projects = iProjectWebDB::getFirst('Projects');

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

		$request = iProjectWebUtils::parseRequest($request, 'Type', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Status', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Impact', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'MitigationStrategy', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Probability', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'Projects', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'ObjectOwner', 'int');

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
				Risks.id,
				Risks.Description,
				Risks.Type,
				Risks.Status,
				Risks.Impact,
				Risks.ObjectOwner,
				Risks.MitigationStrategy,
				Risks.Probability,
				Risks.Projects,
				Risks.RiskDescription,
				Risks.MitigationPlan,
				Risks.History,
				Risks.Comment,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription
			FROM
				#wp__iprojectweb_risks AS Risks
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Risks.ObjectOwner=Users.id
			WHERE
				Risks.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->set('Description', htmlspecialchars($obj->get('Description')));

		$obj->ObjectOwner = (object) array();
		$obj->ObjectOwner->view = $obj;
		$obj->ObjectOwner->field = 'ObjectOwner';
		$obj->ObjectOwner->type = 'Users';
		$obj->ObjectOwner->config['m2'] = 'getUserASList';
		$obj->ObjectOwner->config['t'] = 'Users';
		$obj->ObjectOwner->asparams['listItemClass'] = 'ufo-user-list-item';

		$obj->Projects = (object) array();
		$obj->Projects->view = $obj;
		$obj->Projects->field = 'Projects';
		$obj->Projects->type = 'Projects';
		$obj->Projects->config['m2'] = 'getASList';
		$obj->Projects->config['t'] = 'Projects';

		$obj->set('RiskDescription', htmlspecialchars($obj->get('RiskDescription')));
		$obj->set('MitigationPlan', htmlspecialchars($obj->get('MitigationPlan')));
		$obj->set('Comment', htmlspecialchars($obj->get('Comment')));

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_risksmainform.php';

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
				Risks.id,
				Risks.RiskDescription,
				Risks.MitigationPlan,
				Risks.History,
				Risks.Comment,
				RiskTypes.ListPosition AS TypeListPosition,
				RiskTypes.Description AS TypeDescription,
				RiskStatuses.ListPosition AS StatusListPosition,
				RiskStatuses.Description AS StatusDescription,
				RiskImpacts.ListPosition AS ImpactListPosition,
				RiskImpacts.Description AS ImpactDescription,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Risks.ObjectOwner AS ObjectOwner,
				RiskStrategies.Description AS MitigationStrategyDescription,
				RiskProbabilities.ListPosition AS ProbabilityListPosition,
				RiskProbabilities.Description AS ProbabilityDescription,
				Projects.Description AS ProjectsDescription,
				Risks.Projects AS Projects
			FROM
				#wp__iprojectweb_risks AS Risks
			LEFT JOIN
				#wp__iprojectweb_risktypes AS RiskTypes
					ON
						Risks.Type=RiskTypes.id
			LEFT JOIN
				#wp__iprojectweb_riskstatuses AS RiskStatuses
					ON
						Risks.Status=RiskStatuses.id
			LEFT JOIN
				#wp__iprojectweb_riskimpacts AS RiskImpacts
					ON
						Risks.Impact=RiskImpacts.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Risks.ObjectOwner=Users.id
			LEFT JOIN
				#wp__iprojectweb_riskstrategies AS RiskStrategies
					ON
						Risks.MitigationStrategy=RiskStrategies.id
			LEFT JOIN
				#wp__iprojectweb_riskprobabilities AS RiskProbabilities
					ON
						Risks.Probability=RiskProbabilities.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Risks.Projects=Projects.id
			WHERE
				Risks.id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->set('Comment', htmlspecialchars($obj->get('Comment')));

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_risksreadonlyform.php';

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
			'TypeListPosition',
			'StatusListPosition',
			'ProjectsDescription',
			'ObjectOwnerDescription',
		);

		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "Risks.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getFilter($viewfilters, $rparams, 'Risks.', 'Projects', '=', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Type', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Status', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Impact', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'MitigationStrategy', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Probability', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'RiskDescription');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'MitigationPlan');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'History');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'ObjectOwner', 'int');
		iProjectWebRoot::mDelete('Risks', $viewmap);

		$query = "SELECT
				Risks.id,
				Risks.Description,
				RiskTypes.ListPosition AS TypeListPosition,
				RiskTypes.Description AS TypeDescription,
				Risks.Type AS Type,
				RiskStatuses.ListPosition AS StatusListPosition,
				RiskStatuses.Description AS StatusDescription,
				Risks.Status AS Status,
				Projects.Description AS ProjectsDescription,
				Risks.Projects AS Projects,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Risks.ObjectOwner AS ObjectOwner
			FROM
				#wp__iprojectweb_risks AS Risks
			LEFT JOIN
				#wp__iprojectweb_risktypes AS RiskTypes
					ON
						Risks.Type=RiskTypes.id
			LEFT JOIN
				#wp__iprojectweb_riskstatuses AS RiskStatuses
					ON
						Risks.Status=RiskStatuses.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Risks.Projects=Projects.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Risks.ObjectOwner=Users.id";

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
		?><input type='hidden' name='t' id='t' value='Risks'><?php

		require_once 'views/iprojectweb_risksdetailedmainview.php';

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
			'StatusListPosition',
			'TypeListPosition',
			'ProjectsDescription',
			'ObjectOwnerDescription',
		);

		$orderby = iProjectWebDB::getOrderBy($sortfields, $spar, "Risks.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Type', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Status', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Impact', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'MitigationStrategy', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Probability', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'RiskDescription');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'MitigationPlan');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'History');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Projects', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'ObjectOwner', 'int');
		iProjectWebRoot::mDelete('Risks', $viewmap);

		$query = "SELECT
				Risks.id,
				Risks.Description,
				RiskStatuses.ListPosition AS StatusListPosition,
				RiskStatuses.Description AS StatusDescription,
				Risks.Status AS Status,
				RiskTypes.ListPosition AS TypeListPosition,
				RiskTypes.Description AS TypeDescription,
				Risks.Type AS Type,
				Projects.Description AS ProjectsDescription,
				Risks.Projects AS Projects,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Risks.ObjectOwner AS ObjectOwner
			FROM
				#wp__iprojectweb_risks AS Risks
			LEFT JOIN
				#wp__iprojectweb_riskstatuses AS RiskStatuses
					ON
						Risks.Status=RiskStatuses.id
			LEFT JOIN
				#wp__iprojectweb_risktypes AS RiskTypes
					ON
						Risks.Type=RiskTypes.id
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Risks.Projects=Projects.id
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Risks.ObjectOwner=Users.id";

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

		$this->ObjectOwner = (object) array();
		$this->ObjectOwner->view = $this;
		$this->ObjectOwner->field = 'ObjectOwner';
		$this->ObjectOwner->filter = TRUE;
		$this->ObjectOwner->config['m2'] = 'getUserASList';
		$this->ObjectOwner->config['t'] = 'Users';
		$this->ObjectOwner->asparams['listItemClass'] = 'ufo-user-list-item';
		$this->ObjectOwner->inpstyle = " style='width:130px;'";

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Risks'><?php

		require_once 'views/iprojectweb_risksmainview.php';

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

		$orderby = iProjectWebDB::getOrderBy(array('id', 'Description', 'ObjectOwnerDescription'), $spar, "Risks.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getMTMFilter($viewmap, $viewfilters, 'Risks');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Risks.', 'Description');

		$query = "SELECT
				Risks.id,
				Risks.Description,
				CONCAT(Users.Description, ' ', Users.Name) AS ObjectOwnerDescription,
				Risks.ObjectOwner AS ObjectOwner
			FROM
				#wp__iprojectweb_risks AS Risks
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Risks.ObjectOwner=Users.id";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$this->showlist = FALSE;
		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Risks'><?php

		require_once 'views/iprojectweb_risksmanagemainview.php';

	}

}
