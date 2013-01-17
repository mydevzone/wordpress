<?php

/**
 * @file
 *
 * 	iProjectWebApplicationSettings class definition
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
 * 	iProjectWebApplicationSettings
 *
 */
class iProjectWebApplicationSettings extends iProjectWebBase {

	/**
	 * 	iProjectWebApplicationSettings class constructor
	 *
	 * @param boolean $objdata
	 * 	TRUE if the object should be initialized with db data
	 * @param int $new_id
	 * 	object id. If id is not set or empty a new db record will be created
	 */
	function __construct($objdata = FALSE, $new_id = NULL) {

		$this->type = 'ApplicationSettings';

		$this->fieldmap = array(
				'id' => NULL,
				'Description' => '',
				'Projects_NotifyOnStatusChange' => 0,
				'Projects_NotifyOnNewComment' => 0,
				'Projects_EmailTemplate' => '',
				'Tasks_NotifyOnStatusChange' => 0,
				'Tasks_NotifyOnNewComment' => 0,
				'Tasks_EmailTemplate' => '',
				'Risks_NotifyOnStatusChange' => 0,
				'Risks_NotifyOnNewComment' => 0,
				'Risks_EmailTemplate' => '',
				'TinyMCEConfig' => '',
				'UseTinyMCE' => 0,
				'Projects_EmailFormatHTML' => 0,
				'Tasks_EmailFormatHTML' => 0,
				'Risks_EmailFormatHTML' => 0,
				'ApplicationWidth' => 0,
				'ApplicationWidth2' => 0,
				'DefaultStyle' => '',
				'DefaultStyle2' => '',
				'SecretWord' => '',
				'NotLoggenInText' => '',
				'FileFolder' => '',
				'SendFrom' => '',
				'NewCommentSubject' => '',
				'StatusChangeSubject' => '',
			);

		if ($objdata) {
			$this->init($new_id);
		}

	}

	/**
	 * 	getDeleteStatements
	 *
	 * 	prepares delete statements to be executed to delete a
	 * 	applicationsetting record
	 *
	 * @param int $id
	 * 	object id
	 *
	 * @return array
	 * 	the array of statements
	 */
	function getDeleteStatements($id) {

		$stmts[] = "DELETE FROM #wp__iprojectweb_applicationsettings WHERE id=$id;";

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

		$request = iProjectWebUtils::parseRequest($request, 'Projects_NotifyOnStatusChange', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Projects_NotifyOnNewComment', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Tasks_NotifyOnStatusChange', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Tasks_NotifyOnNewComment', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Risks_NotifyOnStatusChange', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Risks_NotifyOnNewComment', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'UseTinyMCE', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Projects_EmailFormatHTML', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Tasks_EmailFormatHTML', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'Risks_EmailFormatHTML', 'boolean');
		$request = iProjectWebUtils::parseRequest($request, 'ApplicationWidth', 'int');
		$request = iProjectWebUtils::parseRequest($request, 'ApplicationWidth2', 'int');

		parent::update($request, $id);

	}

	/**
	 * 	getInstance
	 *
	 * 	Returns a single iProjectWebApplicationSettings instance
	 *
	 *
	 * @return object
	 * 	the iProjectWebApplicationSettings instance
	 */
	function getInstance() {

		static $obj;
		if (!isset($obj)) {
			$obj = new iProjectWebApplicationSettings(TRUE, 1);
			if ($obj->get('SecretWord') == '') {
				$obj->set('SecretWord', md5('mt=' . microtime()));
				$obj->save();
			}
		}
		return $obj;

	}

	/**
	 * 	getEmailTemplate
	 *
	 * 	Makes a list of object fields available for adding into the email
	 * 	template
	 *
	 * @param string $type
	 * 	An object type
	 */
	function getEmailTemplate($type) {

		if ($type == 'Tasks') {
			echo '<table class="vtable" style="border:0">';
			$this->getEmailTemplateRow("Tasks", "Title", IPROJECTWEB_Title);
			$this->getEmailTemplateRow("Tasks", "Project", IPROJECTWEB_Project);
			$this->getEmailTemplateRow("Tasks", "Priority", IPROJECTWEB_Priority);
			$this->getEmailTemplateRow("Tasks", "Status", IPROJECTWEB_Status);
			$this->getEmailTemplateRow("Tasks", "Type", IPROJECTWEB_Type);
			$this->getEmailTemplateRow("Tasks", "Responsible", IPROJECTWEB_Responsible);
			$this->getEmailTemplateRow("Tasks", "PlannedDeadline", IPROJECTWEB_PlannedDeadline);
			$this->getEmailTemplateRow("Tasks", "PlannedEffort", IPROJECTWEB_PlannedEffort);
			$this->getEmailTemplateRow("Tasks", "ActualDeadline", IPROJECTWEB_ActualDeadline);
			$this->getEmailTemplateRow("Tasks", "ActualEffort", IPROJECTWEB_ActualEffort);
			$this->getEmailTemplateRow("Tasks", "Notes", IPROJECTWEB_Notes);
			echo '</table>';
		}

		if ($type == 'Projects') {
			echo '<table class="vtable" style="border:0">';
			$this->getEmailTemplateRow("Projects", "Title", IPROJECTWEB_Title);
			$this->getEmailTemplateRow("Projects", "Status", IPROJECTWEB_Status);
			$this->getEmailTemplateRow("Projects", "StartDate", IPROJECTWEB_StartDate);
			$this->getEmailTemplateRow("Projects", "FinishDate", IPROJECTWEB_FinishDate);
			$this->getEmailTemplateRow("Projects", "Manager", IPROJECTWEB_Manager);
			$this->getEmailTemplateRow("Projects", "ProjectField1", IPROJECTWEB_ProjectField1);
			$this->getEmailTemplateRow("Projects", "ProjectField2", IPROJECTWEB_ProjectField2);
			$this->getEmailTemplateRow("Projects", "ProjectDescription", IPROJECTWEB_ProjectDescription);
			$this->getEmailTemplateRow("Projects", "ProjectField3", IPROJECTWEB_ProjectField3);
			$this->getEmailTemplateRow("Projects", "ProjectField4", IPROJECTWEB_ProjectField4);
			echo '</table>';
		}

		if ($type == 'Risks') {
			echo '<table class="vtable" style="border:0">';
			$this->getEmailTemplateRow("Risks", "Title", IPROJECTWEB_Title);
			$this->getEmailTemplateRow("Risks", "Type", IPROJECTWEB_Type);
			$this->getEmailTemplateRow("Risks", "Status", IPROJECTWEB_Status);
			$this->getEmailTemplateRow("Risks", "Impact", IPROJECTWEB_Impact);
			$this->getEmailTemplateRow("Risks", "ObjectOwner", IPROJECTWEB_ObjectOwner);
			$this->getEmailTemplateRow("Risks", "MitigationStrategy", IPROJECTWEB_MitigationStrategy);
			$this->getEmailTemplateRow("Risks", "Probability", IPROJECTWEB_Probability);
			$this->getEmailTemplateRow("Risks", "Project", IPROJECTWEB_Project);
			$this->getEmailTemplateRow("Risks", "RiskDescription", IPROJECTWEB_RiskDescription);
			$this->getEmailTemplateRow("Risks", "MitigationPlan", IPROJECTWEB_MitigationPlan);
			echo '</table>';
		}

	}

	/**
	 * 	getEmailTemplateRow
	 *
	 * 	Produces a clickable table row
	 *
	 * @param string $type
	 * 	an object type
	 * @param string $field
	 * 	an object field
	 * @param string $label
	 * 	a field label
	 */
	function getEmailTemplateRow($type, $field, $label) {
			?>

		<tr style='border:0'>
      <td style='border:0'>
        <a id='<?php echo $type . $field . 'icLink';?>' title='<?php echo IPROJECTWEB_ClickToAddToTheTemplate;?>' href='javascript:;' class='ufo-id-link' onmousedown='insertContent(this, "<?php echo $type;?>","{<?php echo $field;?>}")'>
          <?php echo $label;?>
        </a>
      </td>
    </tr>

		<?php
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

		$formmap['oid'] = '1';
		$query = "SELECT * FROM #wp__iprojectweb_applicationsettings WHERE id=:id";

		$obj = $this->formQueryInit($formmap, $query);

		$obj->Projects_NotifyOnStatusChangeChecked
			= $obj->get('Projects_NotifyOnStatusChange') ? 'checked' : '';
		$obj->Projects_NotifyOnStatusChange
			= $obj->get('Projects_NotifyOnStatusChange') ? 'on' : 'off';

		$obj->Projects_NotifyOnNewCommentChecked
			= $obj->get('Projects_NotifyOnNewComment') ? 'checked' : '';
		$obj->Projects_NotifyOnNewComment
			= $obj->get('Projects_NotifyOnNewComment') ? 'on' : 'off';

		$obj->Projects_EmailFormatHTMLChecked
			= $obj->get('Projects_EmailFormatHTML') ? 'checked' : '';
		$obj->Projects_EmailFormatHTML
			= $obj->get('Projects_EmailFormatHTML') ? 'on' : 'off';

		$obj->set('Projects_EmailTemplate', htmlspecialchars($obj->get('Projects_EmailTemplate')));

		$obj->Tasks_NotifyOnStatusChangeChecked
			= $obj->get('Tasks_NotifyOnStatusChange') ? 'checked' : '';
		$obj->Tasks_NotifyOnStatusChange
			= $obj->get('Tasks_NotifyOnStatusChange') ? 'on' : 'off';

		$obj->Tasks_NotifyOnNewCommentChecked
			= $obj->get('Tasks_NotifyOnNewComment') ? 'checked' : '';
		$obj->Tasks_NotifyOnNewComment
			= $obj->get('Tasks_NotifyOnNewComment') ? 'on' : 'off';

		$obj->Tasks_EmailFormatHTMLChecked
			= $obj->get('Tasks_EmailFormatHTML') ? 'checked' : '';
		$obj->Tasks_EmailFormatHTML
			= $obj->get('Tasks_EmailFormatHTML') ? 'on' : 'off';

		$obj->set('Tasks_EmailTemplate', htmlspecialchars($obj->get('Tasks_EmailTemplate')));

		$obj->Risks_NotifyOnStatusChangeChecked
			= $obj->get('Risks_NotifyOnStatusChange') ? 'checked' : '';
		$obj->Risks_NotifyOnStatusChange
			= $obj->get('Risks_NotifyOnStatusChange') ? 'on' : 'off';

		$obj->Risks_NotifyOnNewCommentChecked
			= $obj->get('Risks_NotifyOnNewComment') ? 'checked' : '';
		$obj->Risks_NotifyOnNewComment
			= $obj->get('Risks_NotifyOnNewComment') ? 'on' : 'off';

		$obj->Risks_EmailFormatHTMLChecked
			= $obj->get('Risks_EmailFormatHTML') ? 'checked' : '';
		$obj->Risks_EmailFormatHTML
			= $obj->get('Risks_EmailFormatHTML') ? 'on' : 'off';

		$obj->set('Risks_EmailTemplate', htmlspecialchars($obj->get('Risks_EmailTemplate')));

		$obj->UseTinyMCEChecked = $obj->get('UseTinyMCE') ? 'checked' : '';
		$obj->UseTinyMCE = $obj->get('UseTinyMCE') ? 'on' : 'off';

		$obj->set('TinyMCEConfig', htmlspecialchars($obj->get('TinyMCEConfig')));
		$obj->set('DefaultStyle', htmlspecialchars($obj->get('DefaultStyle')));
		$obj->set('SecretWord', htmlspecialchars($obj->get('SecretWord')));
		$obj->set('FileFolder', htmlspecialchars($obj->get('FileFolder')));
		$obj->set('NotLoggenInText', htmlspecialchars($obj->get('NotLoggenInText')));
		$obj->set('SendFrom', htmlspecialchars($obj->get('SendFrom')));
		$obj->set('NewCommentSubject', htmlspecialchars($obj->get('NewCommentSubject')));
		$obj->set('StatusChangeSubject', htmlspecialchars($obj->get('StatusChangeSubject')));

		$obj->helpLink = iProjectWebUtils::getHelpLink($obj->type);

		?>
		<input type='hidden' class='ufostddata' id='t' value='<?php echo $obj->type;?>'>
		<input type='hidden' class='ufostddata' id='oid' value='<?php echo $obj->getId();?>'>
		<?php

		require_once 'views/iprojectweb_applicationsettingsmainform.php';

	}

}
