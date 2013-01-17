<?php

/**
 * @file
 *
 * 	iProjectWebBackOffice class definition
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
 * 	iProjectWebBackOffice
 *
 * 	Performs service functions
 *
 */
class iProjectWebBackOffice {

	/**
	 * 	sendNotification
	 *
	 * 	sends an email message in response to user actions
	 *
	 * @param int $uid
	 * 	user id
	 * @param string $type
	 * 	object type
	 * @param int $oid
	 * 	object id
	 * @param string $text
	 * 	message text
	 */
	function sendNotification($uid, $type, $oid, $text) {

		$sender = $this->getSenderData($uid);
		if (!$sender) {
			return;
		}
		$emaillist = $this->getListMemberEmails($type, $oid);
		if (sizeof($emaillist) == 0) {
			return;
		}
		$object = $this->prepareObject($type, $oid);
		$template = $this->getTemplate($type);
		$message = $this->fillInTemplate($template, $object);
		$message = $this->merge($message, $text);
		$this->send($message, $emaillist, $sender);

	}

	/**
	 * 	getSenderData
	 *
	 * 	get current user data from a database
	 *
	 * @param int $uid
	 * 	a current user id
	 *
	 * @return object
	 * 	current user info
	 */
	function getSenderData($uid) {

		$query = "SELECT
				CONCAT(Users.Description,' ', Users.Name) AS name,
				Users.email,
				Users.email2
			FROM
				#wp__iprojectweb_users AS Users
			WHERE
				Users.id='$uid'";

		$result = iProjectWebDB::getObjects($query);
		$sender = $result[0];
		$sender->email = empty($sender->email) ? $sender->email2 : $sender->email;
		if (empty($sender->email)) {
			return NULL;
		}
		return $sender;

	}

	/**
	 * 	getListMemberEmails
	 *
	 * 	gets user data of people in the mailing list
	 *
	 * @param string $type
	 * 	object type
	 * @param int $oid
	 * 	object id
	 *
	 * @return array
	 * 	an array of contact data items
	 */
	function getListMemberEmails($type, $oid) {

		$dbobjname = iProjectWebDB::getTableName($type . '_MailingLists');
		$query = "SELECT Contacts FROM $dbobjname WHERE $type='$oid'";
		$rs = iProjectWebDB::getObjects($query);
		$result = array();
		foreach ($rs as $item) {
			$user = $this->getSenderData($item->Contacts);
			if (! is_null($user)) {
				$result[$user->email] = $user->email;
			}
		}

		$dbobjname = iProjectWebDB::getTableName($type);
		$query = "SELECT ObjectOwner FROM $dbobjname WHERE id='$oid'";
		$ooid = iProjectWebDB::getValue($query);
		$user = $this->getSenderData($ooid);
			if (! is_null($user)) {
				$result[$user->email] = $user->email;
			}

		return $result;

	}

	/**
	 * 	prepareObject
	 *
	 * 	Prepares object data
	 *
	 * @param string $type
	 * 	object type
	 * @param int $id
	 * 	object id
	 *
	 * @return object
	 * 	an initialized object
	 */
	function prepareObject($type, $id) {

		$tk_map = array();

		$tk_map['Projects'] = "SELECT
				Projects.id AS id,
				Projects.Description AS Title,
				ProjectStatuses.Description AS Status,
				Projects.StartDate AS StartDate,
				Projects.FinishDate AS FinishDate,
				CONCAT(Users.Description, ' ',Users.Name) AS Manager,
				ProjectField1.Description AS ProjectField1,
				ProjectField2.Description AS ProjectField2,
				Projects.ProjectDescription AS ProjectDescription,
				Projects.History AS History,
				Projects.ProjectField3 AS ProjectField3,
				Projects.ProjectField4 AS ProjectField4
			FROM
				#wp__iprojectweb_projects AS Projects
			LEFT JOIN
				#wp__iprojectweb_projectstatuses AS ProjectStatuses
					ON
						ProjectStatuses.id=Projects.Status
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Users.id=Projects.ObjectOwner
			LEFT JOIN
				#wp__iprojectweb_projectfield1 AS ProjectField1
					ON
						ProjectField1.id=Projects.ProjectField1
			LEFT JOIN
				#wp__iprojectweb_projectfield2 AS ProjectField2
					ON
						ProjectField2.id=Projects.ProjectField2
			WHERE
				Projects.id=:id";

		$tk_map['Tasks'] = "SELECT
				Tasks.id AS id,
				Tasks.Description AS Title,
				Projects.Description AS Project,
				Priorities.Description AS Priority,
				TaskStatuses.Description AS Status,
				TaskTypes.Description AS Type,
				CONCAT(Users.Description, ' ',Users.Name) AS Responsible,
				Tasks.PlannedDeadline AS PlannedDeadline,
				Tasks.PlannedEffort AS PlannedEffort,
				Tasks.ActualDeadline AS ActualDeadline,
				Tasks.ActualEffort AS ActualEffort,
				Tasks.Notes AS Notes,
				Tasks.History AS History
			FROM
				#wp__iprojectweb_tasks AS Tasks
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Projects.id=Tasks.Projects
			LEFT JOIN
				#wp__iprojectweb_priorities AS Priorities
					ON
						Priorities.id=Tasks.Priority
			LEFT JOIN
				#wp__iprojectweb_taskstatuses AS TaskStatuses
					ON
						TaskStatuses.id=Tasks.Status
			LEFT JOIN
				#wp__iprojectweb_tasktypes AS TaskTypes
					ON
						TaskTypes.id=Tasks.Type
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Users.id=Tasks.ObjectOwner
			WHERE
				Tasks.id=:id";

		$tk_map['Risks'] = "SELECT
				Risks.id AS id,
				Risks.Description AS Title,
				RiskTypes.Description AS Type,
				RiskStatuses.Description AS Status,
				RiskImpacts.Description AS Impact,
				CONCAT(Users.Description, ' ',Users.Name) AS ObjectOwner,
				RiskStrategies.Description AS MitigationStrategy,
				RiskProbabilities.Description AS Probability,
				Projects.Description AS Project,
				Risks.RiskDescription AS RiskDescription,
				Risks.MitigationPlan AS MitigationPlan,
				Risks.History AS History
			FROM
				#wp__iprojectweb_risks AS Risks
			LEFT JOIN
				#wp__iprojectweb_risktypes AS RiskTypes
					ON
						RiskTypes.id=Risks.Type
			LEFT JOIN
				#wp__iprojectweb_riskstatuses AS RiskStatuses
					ON
						RiskStatuses.id=Risks.Status
			LEFT JOIN
				#wp__iprojectweb_riskimpacts AS RiskImpacts
					ON
						RiskImpacts.id=Risks.Impact
			LEFT JOIN
				#wp__iprojectweb_users AS Users
					ON
						Users.id=Risks.ObjectOwner
			LEFT JOIN
				#wp__iprojectweb_riskstrategies AS RiskStrategies
					ON
						RiskStrategies.id=Risks.MitigationStrategy
			LEFT JOIN
				#wp__iprojectweb_riskprobabilities AS RiskProbabilities
					ON
						RiskProbabilities.id=Risks.Probability
			LEFT JOIN
				#wp__iprojectweb_projects AS Projects
					ON
						Projects.id=Risks.Projects
			WHERE
				Risks.id=:id";

		$query = $tk_map[$type];
		if (!isset($query)) {
			return (object) array();
		}
		$fvalues = array();
		$fvalues['fvalues'][':id'] = intval($id);
		$result = iProjectWebDB::select($query, $fvalues);
		return $result[0];

	}

	/**
	 * 	getTemplate
	 *
	 * 	gets a object type specific email template form application settings
	 *
	 * @param string $type
	 * 	object type
	 *
	 * @return object
	 * 	the found email templae
	 */
	function getTemplate($type) {

		$template = (object) array('subject' => '', 'body' => '', 'ishtml' => FALSE);
		$ishtml_pn = $type . '_EmailFormatHTML';
		$bd_pn = $type . '_EmailTemplate';
		$template->ishtml
			= iProjectWebApplicationSettings::getInstance()->get($ishtml_pn);
		$template->body
			= iProjectWebApplicationSettings::getInstance()->get($bd_pn);
		return $template;

	}

	/**
	 * 	fillInTemplate
	 *
	 * 	fills the template with object data
	 *
	 * @param object $template
	 * 	email template
	 * @param string $object
	 * 	object type
	 *
	 * @return object
	 * 	the filled template
	 */
	function fillInTemplate($template, $object) {

		if (!is_object($object)) {
			$template->body = str_replace('{messagebody}', $object, $template->body);
		}
		else {
			$fields = get_object_vars($object);
			foreach ($fields as $fname => $fvalue) {
				$value = (
					iProjectWebUtils::endsWith($fname, 'date') ||
					iProjectWebUtils::endsWith($fname, 'deadline')) ?
					iProjectWebUtils::getDate($fvalue, 'date') :
					$fvalue;
				$template->body = str_replace('{' . $fname . '}', $value, $template->body);
			}
		}
		return $template;

	}

	/**
	 * 	merge
	 *
	 * 	merges a template and input text
	 *
	 * @param object $message
	 * 	a message template
	 * @param string $text
	 * 	user comment
	 *
	 * @return object
	 * 	ready-to-send message
	 */
	function merge($message, $text) {

		$message->subject = isset($text->subject) ?
			$text->subject :
			IPROJECTWEB_NotificationSubject;
		$bkp = md5($message->body);
		$message = $this->fillInTemplate($message, $text->body);
		if (md5($message->body) == $bkp) {
			$message->body .= $text->body;
		}
		return $message;

	}

	/**
	 * 	send
	 *
	 * 	sends a message
	 *
	 * @param object $message
	 * 	a message to send
	 * @param array $emaillist
	 * 	a mainling list
	 * @param object $sender
	 * 	sender data
	 */
	function send($message, $emaillist, $sender) {

		$email = iProjectWebApplicationSettings::getInstance()->get('SendFrom');
		$headers = $email != '' ? "From: $sender->name <$email>\r\n\\" : '';

		if ($message->ishtml) {
			add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
		}

		wp_mail($emaillist, $message->subject, $message->body, $headers);

	}

	/**
	 * 	processHistory
	 *
	 * 	performs status/comment/history processing
	 *
	 * @param array $fieldvalues
	 * 	request field data
	 * @param string $type
	 * 	object type
	 * @param int $oid
	 * 	object id
	 * @param int $uid
	 * 	current user id
	 */
	function processHistory($fieldvalues, $type, $oid, $uid) {

		$object = iProjectWebClassLoader::getObject($type, TRUE, $oid);

		$is_st_changed = isset($fieldvalues->Status) &&
			($fieldvalues->Status != $object->get('Status'));
		$not_on_sn_chng_var = $type . '_NotifyOnStatusChange';

		$not_on_st_change = iProjectWebApplicationSettings::getInstance()->get($not_on_sn_chng_var);

		$is_n_comment = isset($fieldvalues->Comment);
		$not_on_new_comment_var = $type . '_NotifyOnNewComment';
		$not_on_new_comment = iProjectWebApplicationSettings::getInstance()->get($not_on_new_comment_var);

		$send_message = ($is_n_comment && $not_on_new_comment ) ||
			($is_st_changed && $not_on_st_change);

		if (! $is_st_changed && ! $is_n_comment) {
			return $fieldvalues;
		}

		$type_status_map = array();
		$type_status_map['Projects'] = 'ProjectStatuses';
		$type_status_map['Tasks'] = 'TaskStatuses';
		$type_status_map['Risks'] = 'RiskStatuses';

		$objname = iProjectWebDB::getTableName($type_status_map[$type]);

		$sid = $is_st_changed ?
			intval($fieldvalues->Status) : $object->get('Status');

		$status = iProjectWebDB::getValue("SELECT Description FROM $objname WHERE id='$sid'");

		$user = iProjectWebDB::getValue(
				"SELECT CONCAT(Description,' ',Name) FROM #wp__iprojectweb_users WHERE id='$uid'");

		$text = (object) array('body' => '', 'subject' => '');

		$comment = '';
		$delimeter = '-- ' . $user . ' -- ' . $status . ' -- ' .
			date(IPROJECTWEB_DateTimeFormat) . ' --<br/>';

		if ($is_n_comment) {
			$comment = $fieldvalues->Comment;
			unset($fieldvalues->Comment);
			$text->body = $comment;
			$stemplate = iProjectWebApplicationSettings::getInstance()->get('NewCommentSubject');
			$text->subject = sprintf(
				$stemplate,
				$type, $object->get('Description'), $status);
		}
		if ($is_st_changed) {
			$stemplate = iProjectWebApplicationSettings::getInstance()->get('StatusChangeSubject');
			$text->subject = sprintf(
				$stemplate,
				$type, $object->get('Description'), $status);
		}
		$history = $delimeter . $text->body . '<br/>' . $object->get('History');
		$fieldvalues->History = $history;

		if ($send_message) {
			$this->sendNotification($uid, $type, $oid, $text);
		}

		return $fieldvalues;

	}

}
