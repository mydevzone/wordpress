<?php

/**
 * @file
 *
 * 	iProjectWebUserField2 class definition
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
 * 	iProjectWebUserField2
 *
 */
class iProjectWebUserField2 extends iProjectWebBase {

	/**
	 * 	iProjectWebUserField2 class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'UserField2';
		$this->fieldmap = array('id' => NULL, 'Description' => '', 'Notes' => '');

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a userfield2
	 * 	record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$stmts[] = "DELETE FROM #wp__iprojectweb_userfield2 WHERE id=$id;";

		return $stmts;

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

		$obj = $this->formInit($formmap, $fields);
		$obj->set('Description', htmlspecialchars($obj->get('Description')));
		$obj->set('Notes', htmlspecialchars($obj->get('Notes')));

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_userfield2mainform.php';

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
		$orderby = iProjectWebDB::getOrderBy(array('id', 'Description'), $spar, "UserField2.Description");

		$rparams = $this->getFilter($viewmap);
		$viewfilters = array();
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'UserField2.', 'id', 'int');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'UserField2.', 'Description');
		$viewfilters = iProjectWebDB::getSignFilter($viewfilters, $rparams, 'UserField2.', 'Notes');
		iProjectWebRoot::mDelete('UserField2', $viewmap);

		$query = "SELECT
				UserField2.id,
				UserField2.Description
			FROM
				#wp__iprojectweb_userfield2 AS UserField2";

		$this->start = isset($viewmap['start']) ? intval($viewmap['start']) : 0;
		$this->limit = isset($viewmap['limit']) ? intval($viewmap['limit']) : 10;
		$this->rowCount = iProjectWebDB::getRowCount($query, $viewfilters);

		$resultset = iProjectWebDB::select($query, $viewfilters, $orderby, $this);

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='UserField2'><?php

		require_once 'views/iprojectweb_userfield2mainview.php';

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
				UserField2.id,
				UserField2.Description,
				UserField2.Notes
			FROM
				#wp__iprojectweb_userfield2 AS UserField2
			ORDER BY
				UserField2.Description";

		$resultset = iProjectWebDB::select($query);

		$obj = $this;
		?><input type='hidden' name='t' id='t' value='UserField2'><?php

		require_once 'views/iprojectweb_userfield2readonlyview.php';

	}

}
