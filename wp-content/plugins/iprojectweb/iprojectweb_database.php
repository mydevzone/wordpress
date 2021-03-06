<?php

/**
 * @file
 *
 * 	iProjectWebDB class definition
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

/**
 * 	iProjectWebDB
 *
 * 	database operations
 *
 */
class iProjectWebDB {

	/**
	 * 	wptn
	 *
	 * @param  $query
	 * 
	 *
	 * @return
	 * 
	 */
	function wptn($query) {

		global $wpdb;

		$query = str_replace("#wp__", $wpdb->prefix, $query);
		return $query;

	}

	/**
	 * 	query
	 *
	 * 	executes an arbitrary query
	 *
	 * @param string $sqltext
	 * 	sql query text
	 */
	function query($sqltext) {

		global $wpdb;

		$sqltext=iProjectWebDB::wptn($sqltext);
		$wpdb->query($sqltext);

	}

	/**
	 * 	getObjects
	 *
	 * 	returns an array of db objects
	 *
	 * @param string $sqltext
	 * 	a query to execute
	 *
	 * @return array
	 * 	db objects array
	 */
	function getObjects($sqltext) {

		global $wpdb;

		$sqltext=iProjectWebDB::wptn($sqltext);
		return $wpdb->get_results($sqltext);

	}

	/**
	 * 	getValue
	 *
	 * 	returns a first column first row value
	 *
	 * @param string $sqltext
	 * 	a query to execute
	 *
	 * @return arbitrary
	 * 	the requested value
	 */
	function getValue($sqltext) {

		global $wpdb;

		$sqltext=iProjectWebDB::wptn($sqltext);
		return $wpdb->get_var($sqltext);

	}

	/**
	 * 	err
	 *
	 * 	informs about possible errors. TBD
	 *
	 *
	 * @return boolean
	 * 	the error flag
	 */
	function err() {

		return FALSE;

	}

	/**
	 * 	select
	 *
	 * 	composes and executes a select statement
	 *
	 * @param string $select
	 * 	a select statement to excecute
	 * @param array $filters
	 * 	a list of filters and filter values
	 * @param string $orderby
	 * 	a comma separated list of order by fields
	 * @param object $limit
	 * 	an object having the start and limit fields
	 *
	 * @return array
	 * 	an array of db objects
	 */
	function select($select, $filters = NULL, $orderby = NULL, $limit = NULL) {

		$viewlimits = is_null($limit) ? '' : ' LIMIT ' . intval($limit->start) . ', ' . intval($limit->limit);

		$where = is_null($filters) ? '' : iProjectWebDB::getWhere($filters);

		$select = $select . $where;

		if (! is_null($filters) && isset($filters['fvalues'])){
			foreach ($filters['fvalues'] as $key => $value){
				$replacement = is_array($value) ?
					"'" . implode("', '", $value) . "'" :
					"'" . mysql_real_escape_string($value) . "'";

				$select = str_replace($key, $replacement, $select);
			}
		}

		$orderby = is_null($orderby) ? '' : ' ' . $orderby;

		$select = $select . $orderby . $viewlimits;

		$select=iProjectWebDB::wptn($select);

		$result = iProjectWebDB::getObjects($select);
		return $result;

	}

	/**
	 * 	update
	 *
	 * 	executes an update statement
	 *
	 * @param array $valuemap
	 * 	an array containing values to put into a database
	 * @param string $type
	 * 	an updated object type
	 * @param int $id
	 * 	object id
	 */
	function update($valuemap, $type, $id) {

		if (count($valuemap) == 0) {
			return;
		}

		$update = '';
		$comma = '';
		foreach($valuemap as $key => $value){
			$update.= $comma.$key." = '" . mysql_real_escape_string($value) . "'";
			$comma = ', ';
		}

		$obj = iProjectWebClassLoader::getObject($type);

		$dbtable = $obj->getTableName();
		$dbtable = iProjectWebDB::wptn($dbtable);

		$id = intval($id);
		$query = "UPDATE $dbtable SET $update WHERE id = '$id'";
		iProjectWebDB::query($query);

	}

	/**
	 * 	insert
	 *
	 * 	insert new object data
	 *
	 * @param array $valuemap
	 * 	values to insert
	 * @param string $type
	 * 	inserted object type
	 *
	 * @return int
	 * 	inserted object id
	 */
	function insert($valuemap, $type) {

		if (count($valuemap) == 0) {
			return;
		}

		$names = '';
		$values = '';
		$comma = '';
		foreach($valuemap as $key => $value) {
			if (is_null($value)) continue;
			$names .= $comma . '' . $key . '';
			$values .= $comma . " '" . $value . "'";
			$comma = ', ';
		}

		$obj = iProjectWebClassLoader::getObject($type);
		$dbtable = $obj->getTableName();
		$dbtable = iProjectWebDB::wptn($dbtable);

		$query = 'INSERT INTO ' . $dbtable . '(' . $names . ') VALUES (' . $values . ')';
		iProjectWebDB::query($query);

		global $wpdb;

		return $wpdb->insert_id;

	}

	/**
	 * 	cDelete
	 *
	 * 	executes a part of cascade delete operation
	 *
	 * @param string $query
	 * 	a select query to perform
	 * @param string $type
	 * 	a type of objects being deleted
	 */
	function cDelete($query, $type) {

		$delids = iProjectWebDB::getObjects($query);
		$delobj = iProjectWebClassLoader::getObject($type);
		foreach ($delids as $delrow) {
			$delobj->delete($delrow->id);
		}

	}

	/**
	 * 	getFirst
	 *
	 * 	selects a first record in an object table
	 *
	 * @param string $type
	 * 	a type of object to look up
	 * @param boolean $lp
	 * 	indicates a way of object ordering
	 *
	 * @return int
	 * 	a found object id
	 */
	function getFirst($type, $lp = FALSE) {

		$orderby = $lp ? 'ListPosition' : 'Description';
		$tablename = iProjectWebDB::getTableName($type);
		$query = 'SELECT id FROM ' . $tablename . ' ORDER BY ' . $orderby . ' LIMIT 1';
		$result = iProjectWebDB::getValue($query);
		return $result;

	}

	/**
	 * 	getSign
	 *
	 * 	returns a human readable form of sql operator
	 *
	 * @param int $signid
	 * 	operator id
	 *
	 * @return string
	 * 	sql operator
	 */
	function getSign($signid) {

		if ($signid == '2') {
			return '<';
		}
		if ($signid == '4') {
			return '<=';
		}
		if ($signid == '9') {
			return '<>';
		}
		if ($signid == '3') {
			return '=';
		}
		if ($signid == '1') {
			return '>';
		}
		if ($signid == '5') {
			return '>=';
		}
		if ($signid == '10') {
			return 'ANY';
		}
		if ($signid == '11') {
			return 'BETWEEN';
		}
		if ($signid == '7') {
			return 'IN';
		}
		if ($signid == '8') {
			return 'LIKE';
		}
		if ($signid == '6') {
			return 'NOT';
		}
		return ' = ';

	}

	/**
	 * 	getSignSList
	 *
	 * 	returns a list of comparison operators
	 *
	 * @param string $group
	 * 	a name of operator group
	 * @param boolean $useany
	 * 	allows/disallows the 'ANY' operator
	 *
	 * @return array
	 * 	comparison operators
	 */
	function getSignSList($group, $useany) {

		$signs = array();
		switch ($group) {
			case 'string':
				$signs = array('8' => IPROJECTWEB_SIGN_LIKE, '3' => IPROJECTWEB_SIGN_EQUAL);
				break;

			case 'ref':
				$signs = array(
					'3' => IPROJECTWEB_SIGN_EQUAL,
					'9' => IPROJECTWEB_SIGN_NOT_EQUAL,
				);
				break;

			case 'bool':
				$signs = array('10' => IPROJECTWEB_SIGN_ANY, '3' => IPROJECTWEB_SIGN_EQUAL);
				break;

			case 'date':

				$signs = array(
					'1' => IPROJECTWEB_SIGN_MORE,
					'5' => IPROJECTWEB_SIGN_MOREOREQUAL,
					'2' => IPROJECTWEB_SIGN_LESS,
					'4' => IPROJECTWEB_SIGN_LESSOREQUAL,
				);

				break;

			case 'general':

				$signs = array(
					'3' => IPROJECTWEB_SIGN_EQUAL,
					'1' => IPROJECTWEB_SIGN_MORE,
					'5' => IPROJECTWEB_SIGN_MOREOREQUAL,
					'2' => IPROJECTWEB_SIGN_LESS,
					'4' => IPROJECTWEB_SIGN_LESSOREQUAL,
					'9' => IPROJECTWEB_SIGN_NOT_EQUAL,
				);

				break;

		}
		if ($useany && $group != 'bool') {
			$signs[10] = IPROJECTWEB_SIGN_ANY;
		}
		$options = '';
		foreach ($signs as $key => $value) {
			$options .= "<option value = '$key' > $value</option > \n";
		}
		return $options;

	}

	/**
	 * 	getStdOrder
	 *
	 * 	prepares a sort field list
	 *
	 * @param array $orders
	 * 	a predefined list of order fields
	 * @param array $filterarray
	 * 	an array containing predefined table order settings
	 *
	 * @return array
	 * 	sort list
	 */
	function getStdOrder($orders, $filterarray = NULL) {

		$stdfilters = ($filterarray == NULL)?array():$filterarray;
		foreach ($orders as $order) {
			$stdfilters[$order->property] = $order->direction;
		}
		return $stdfilters;

	}

	/**
	 * 	getStdFilters
	 *
	 * 	prepares an array of filters
	 *
	 * @param array $filters
	 * 	an array containg a requested set of filters
	 * @param array $filterarray
	 * 	an array containig a predefined set of filters
	 *
	 * @return array
	 * 	the prepared filter list
	 */
	function getStdFilters($filters, $filterarray = NULL) {

		$stdfilters = is_null($filterarray) ? array() : $filterarray;
		foreach ($filters as $filter) {
			$stdfilters[$filter->property] = $filter->value;
		}
		return $stdfilters;

	}

	/**
	 * 	getStatusFilter
	 *
	 * 	sets a status filter, filtering out objects having a
	 * 	last-by-list-position status
	 *
	 * @param string $type
	 * 	a name a type to set a status filter for
	 *
	 * @return object
	 * 	the predefined filter object
	 */
	function getStatusFilter($type) {

		$query = 'SELECT id FROM ' . iProjectWebDB::getTableName($type) .
			' ORDER BY ListPosition DESC';
		$limit = (object) array('start' => 0, 'limit' => 1);
		$result = iProjectWebDB::select($query, NULL, NULL, $limit);
		if (count($result) == 0) {
			return (object) (array('sign' => '10', 'values' => array(0)));
		}
		else {
			return (object) (array('sign' => '9', 'values' => array($result[0]->id)));
		}

	}

	/**
	 * 	getMTMFilter
	 *
	 * 	peforms many-to-many table filterfing
	 *
	 * @param array $map
	 * 	request data
	 * @param array $filters
	 * 	filter list
	 * @param string $alias
	 * 	object alias to use when preparing filter statements
	 *
	 * @return array
	 * 	an array containig mtm filters
	 */
	function getMTMFilter($map, $filters, $alias) {

		if (!isset($map['a'])) {
			return $filters;
		}

		$jsparams = json_decode(stripslashes($map['a']));
		if ($jsparams->m != 'mtmview') {
			return $filters;
		}

		foreach ($jsparams->ca as $obj) {
			$mobj = iProjectWebClassLoader::getObject($obj->mt);

			$tablename = $mobj->getTableName();
			$fields = $mobj->getFieldNames();
			if (!in_array($obj->n, $fields)) {
				continue;
			}
			if (!in_array($obj->fld, $fields)) {
				continue;
			}
			$objid = intval($obj->oid);
			if (!isset($filters['fnames'])) {
				$filters['fnames'] = array();
			}
			$filters['fnames'][] = $alias . '.id NOT IN (SELECT ' .
				$obj->n . ' FROM ' . $tablename .
				' WHERE ' . $obj->fld . ' = \'' . $objid . '\')';
		}

		return $filters;

	}

	/**
	 * 	getSignFilter
	 *
	 * 	prepares a comparison operator based statement, reading the operator
	 * 	value from the incoming request
	 *
	 * @param array $filters
	 * 	a filter array to add values to
	 * @param array $rparams
	 * 	incoming request filters
	 * @param string $alias
	 * 	object alias to use when building the statement
	 * @param string $pttype
	 * 	object type
	 * @param string $datatype
	 * 	data type
	 *
	 * @return array
	 * 	comparison statement
	 */
	function getSignFilter($filters, $rparams, $alias, $pttype, $datatype = NULL) {

		if (!isset($rparams[$pttype]) || empty($rparams[$pttype])) {
			return $filters;
		}

		$value = $rparams[$pttype];
		if (!isset($value->sign) || empty($value->sign)) {
			return $filters;
		}

		$sign = intval($value->sign);
		if ($sign == '10') {
			return $filters;
		}

		$sign = iProjectWebDB::getSign($sign);

		return iProjectWebDB::getFilter($filters, $rparams, $alias, $pttype, $sign, $datatype);

	}

	/**
	 * 	getFilter
	 *
	 * 	prepares a comparison operator based statement, reading the operator
	 * 	value from the incoming request
	 *
	 * @param array $filters
	 * 	a filter array to add values to
	 * @param array $rparams
	 * 	incoming request filters
	 * @param string $alias
	 * 	object alias to use when building the statement
	 * @param string $pttype
	 * 	object type
	 * @param string $sign
	 * 	an operator to use when building the statement
	 * @param string $datatype
	 * 	data type
	 *
	 * @return array
	 * 	comparison statement
	 */
	function getFilter($filters, $rparams, $alias, $pttype, $sign, $datatype = NULL) {

		if (!isset($rparams[$pttype]) || empty($rparams[$pttype])) {
			return $filters;
		}
		if (!isset($filters['fnames'])) {
			$filters['fnames'] = array();
			$filters['fvalues'] = array();
		}

		$lalias = $alias . $pttype;
		$falias = str_replace('.', '_', $lalias);

		$value = $rparams[$pttype];
		if ($sign == 'BETWEEN') {
			$filters['fnames'][] = "$lalias BETWEEN :$falias1 AND :$falias2";
			return $filters;
			$filters['fvalues'][":$falias1"]
				= iProjectWebUtils::convert($value->values[0], $datatype, TRUE);
			$filters['fvalues'][":$falias2"]
				= iProjectWebUtils::convert($value->values[1], $datatype, TRUE);
			return $filters;
		}

		if ($sign == 'IN') {
			$filters['fnames'][] = "$lalias IN (:$falias)";
			$values = array();
			foreach ($value->values as $vvalue) {
				$values[] = iProjectWebUtils::convert($vvalue, $datatype, TRUE);
			}
			$filters['fvalues'][":$falias"] = $values;
			return $filters;
		}

		$value = iProjectWebUtils::convert($value->values[0], $datatype, TRUE);

		if ($sign == 'LIKE') {
			$filters['fnames'][] = "$lalias LIKE :$falias";
			$filters['fvalues'][":$falias"] = "%$value%";
			return $filters;
		}

		$filters['fnames'][] = "$lalias $sign :$falias";
		$filters['fvalues'][":$falias"] = $value;

		return $filters;

	}

	/**
	 * 	getWhere
	 *
	 * 	build the where part
	 *
	 * @param array $filters
	 * 	a set of filters to use for building
	 * @param array $viewmap
	 * 	not used
	 * @param string $alias
	 * 	not used
	 *
	 * @return string
	 * 	a where statement
	 */
	function getWhere($filters, $viewmap = NULL, $alias = NULL) {

		if (is_null($filters)) {
			return '';
		}

		if (!isset($filters['fnames'])) {
			return '';
		}
		if (count($filters['fnames']) == 0) {
			return '';
		}

		$fnames = implode(' AND ', $filters['fnames']);
		$prefix = isset($filters['skipWhere']) ? ' AND ' : ' WHERE ';

		return $prefix . $fnames;

	}

	/**
	 * 	getOrderBy
	 *
	 * 	build the order by part
	 *
	 * @param array $fields
	 * 	a list of fields to use
	 * @param array $orders
	 * 	an incoming sort request
	 * @param string $defaultorder
	 * 	default order by statement
	 *
	 * @return string
	 * 	the build ORDER BY
	 */
	function getOrderBy($fields, $orders, $defaultorder = '') {

		$orderby = '';
		$comma = '';
		foreach ($orders as $key => $value) {
			$ovalue = $value == 'DESC' ? ' DESC' : ' ASC';
			if (! in_array($key, $fields)) {
				continue;
			}
			$orderby .= $comma . $key . $ovalue;
			$comma = ', ';
		}
		$comma = (($orderby != '') && ($defaultorder != '')) ? ', ' : '';
		$orderby .= $comma . $defaultorder;
		$header = ($orderby == '') ? '' : 'ORDER BY ';
		return $header . $orderby;

	}

	/**
	 * 	getRowCount
	 *
	 * 	returns a count of rows
	 *
	 * @param string $rcsql
	 * 	a statement to return a count of rows for
	 * @param array $filters
	 * 	a set of applied filters
	 *
	 * @return int
	 * 	row count
	 */
	function getRowCount($rcsql, $filters = NULL) {

		list($first, $second) = explode('FROM', $rcsql, 2);
		$rcquery = 'SELECT COUNT(*) AS c FROM ' . $second;
		$rcresult = iProjectWebDB::select($rcquery, $filters);
		return $rcresult[0]->c;

	}

	/**
	 * 	getQueryText
	 *
	 * 	creates a parameter-value based sql query
	 *
	 * @param string $query
	 * 	sql text
	 * @param array $params
	 * 	parameter key => values pairs
	 *
	 * @return string
	 * 	sql text
	 */
	function getQueryText($query, $params) {

		if (isset($params)) {
			foreach ($params as $key => $value) {
				$query = str_replace('%' . $key,
				iProjectWebUtils::addMSlashes($value),
				$query);
			}
		}
		return $query;

	}

	/**
	 * 	getTableName
	 *
	 * 	return an object table name
	 *
	 * @param string $objname
	 * 	object type name
	 *
	 * @return string
	 * 	table name
	 */
	function getTableName($objname) {

		return '#wp__iprojectweb_' . strtolower($objname) . '';

	}

	/**
	 * 	updateListPosition
	 *
	 * 	updates an object list position value right after object is created
	 *
	 * @param string $type
	 * 	object type name
	 * @param int $id
	 * 	object id
	 */
	function updateListPosition($type, $id) {

		$valuemap = array();
		$valuemap['ListPosition'] = $id;
		iProjectWebDB::update($valuemap, $type, $id);

	}

}
