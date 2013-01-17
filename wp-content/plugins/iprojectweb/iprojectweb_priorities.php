<?php

/**
 * @file
 *
 * 	iProjectWebPriorities class definition
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
 * 	iProjectWebPriorities
 *
 */
class iProjectWebPriorities extends iProjectWebBase {

	/**
	 * 	iProjectWebPriorities class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'Priorities';
		$this->fieldmap = array(
				'id' => NULL,
				'Description' => '',
				'ListPosition' => 0,
				'Notes' => '',
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a priority record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$stmts[] = "DELETE FROM #wp__iprojectweb_priorities WHERE id=$id;";

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

		$request = iProjectWebUtils::parseRequest($request, 'ListPosition', 'int');

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

			case 'readonly':
				return $this->getReadonlyView($vmap);
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
		$fields[] = 'Notes';

		$obj = $this->formInit($formmap, $fields, TRUE);
		$obj->set('Description', htmlspecialchars($obj->get('Description')));
		$obj->set('Notes', htmlspecialchars($obj->get('Notes')));

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_prioritiesmainform.php';

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
		$orderby = iProjectWebDB::getOrderBy(array('id', 'Description', 'ListPosition'), $spar, "Priorities.ListPosition");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Priorities.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Priorities.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'Priorities.', 'Notes');

		iProjectWebRoot::moveRow('Priorities', $viewmap, $viewfilters, 'Priorities');
		iProjectWebRoot::mDelete('Priorities', $viewmap);

		$query = "SELECT
				Priorities.id,
				Priorities.Description,
				Priorities.ListPosition
			FROM
				#wp__iprojectweb_priorities AS Priorities";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Priorities'><?php

		require_once 'views/iprojectweb_prioritiesmainview.php';

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

		$query = "SELECT
				Priorities.id,
				Priorities.Description,
				Priorities.ListPosition,
				Priorities.Notes
			FROM
				#wp__iprojectweb_priorities AS Priorities
			ORDER BY
				Priorities.ListPosition";

		$resultset = iProjectWebDB::select($query);

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='Priorities'><?php

		require_once 'views/iprojectweb_prioritiesreadonlyview.php';

	}

}
