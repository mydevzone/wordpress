<?php
/**
 * @file
 * Install functions for the iprojectweb plugin.
 */

function iprojectweb_install() {
	global $wpdb;				
	$sqls = array();
	$sqls[] = "CREATE TABLE #wp__iprojectweb_applicationsettings (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Projects_NotifyOnStatusChange BOOLEAN,
				Projects_NotifyOnNewComment BOOLEAN,
				Projects_EmailTemplate TEXT,
				Tasks_NotifyOnStatusChange BOOLEAN,
				Tasks_NotifyOnNewComment BOOLEAN,
				Tasks_EmailTemplate TEXT,
				Risks_NotifyOnStatusChange BOOLEAN,
				Risks_NotifyOnNewComment BOOLEAN,
				Risks_EmailTemplate TEXT,
				TinyMCEConfig TEXT,
				UseTinyMCE BOOLEAN,
				Projects_EmailFormatHTML BOOLEAN,
				Tasks_EmailFormatHTML BOOLEAN,
				Risks_EmailFormatHTML BOOLEAN,
				ApplicationWidth INT(10),
				ApplicationWidth2 INT(10),
				DefaultStyle VARCHAR(50),
				DefaultStyle2 VARCHAR(50),
				SecretWord VARCHAR(50),
				NotLoggenInText TEXT,
				FileFolder VARCHAR(100),
				SendFrom VARCHAR(100),
				NewCommentSubject VARCHAR(100),
				StatusChangeSubject VARCHAR(100),
				PRIMARY KEY (id),
				INDEX propsearch (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_files (
				id INT(11) NOT NULL auto_increment ,
				Doctype VARCHAR(80),
				Docfield VARCHAR(80),
				Docid INT(10),
				Name VARCHAR(300),
				Type VARCHAR(80),
				Size INT(10),
				Protected BOOLEAN,
				Webdir BOOLEAN,
				Count INT(11),
				Storagename VARCHAR(300),
				ObjectOwner INT(11),
				PRIMARY KEY (id),
				INDEX Docid (Docid),
				INDEX typefieldid (Doctype, Docfield, Docid),
				INDEX ObjectOwner (ObjectOwner));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_priorities (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				ListPosition INT(10) NOT NULL DEFAULT 0,
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description),
				INDEX ListPosition (ListPosition));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_projectfield1 (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_projectfield2 (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_projectfiles (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Date INT(11),
				ObjectOwner INT(11) NOT NULL DEFAULT 0,
				Notes TEXT,
				Projects INT(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (id),
				INDEX ObjectOwner (ObjectOwner),
				INDEX Description (Description),
				INDEX Projects (Projects));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_projectroles (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_projects (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Status INT(11) NOT NULL DEFAULT 0,
				StartDate INT(11),
				FinishDate INT(11),
				ObjectOwner INT(11) NOT NULL DEFAULT 0,
				ProjectField1 INT(11) NOT NULL DEFAULT 0,
				ProjectField2 INT(11) NOT NULL DEFAULT 0,
				ProjectDescription TEXT,
				History TEXT,
				Comment TEXT,
				ProjectField3 TEXT,
				ProjectField4 TEXT,
				PRIMARY KEY (id),
				INDEX ObjectOwner (ObjectOwner),
				INDEX Status (Status),
				INDEX ProjectField1 (ProjectField1),
				INDEX Description (Description),
				INDEX ProjectField2 (ProjectField2));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_projects_mailinglists (
				id INT(11) NOT NULL auto_increment ,
				Projects INT(11) NOT NULL DEFAULT 0,
				Contacts INT(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (id),
				INDEX Contacts (Contacts),
				INDEX Projects (Projects));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_projects_teams (
				id INT(11) NOT NULL auto_increment ,
				Projects INT(11) NOT NULL DEFAULT 0,
				Members INT(11) NOT NULL DEFAULT 0,
				Role INT(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (id),
				INDEX Role (Role),
				INDEX Projects (Projects),
				INDEX Members (Members));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_projectstatuses (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				ListPosition INT(10) NOT NULL DEFAULT 0,
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description),
				INDEX ListPosition (ListPosition));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_riskimpacts (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				ListPosition INT(10) NOT NULL DEFAULT 0,
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description),
				INDEX ListPosition (ListPosition));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_riskprobabilities (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				ListPosition INT(10) NOT NULL DEFAULT 0,
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description),
				INDEX ListPosition (ListPosition));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_risks (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Type INT(11) NOT NULL DEFAULT 0,
				Status INT(11) NOT NULL DEFAULT 0,
				Impact INT(11) NOT NULL DEFAULT 0,
				MitigationStrategy INT(11) NOT NULL DEFAULT 0,
				Probability INT(11) NOT NULL DEFAULT 0,
				RiskDescription TEXT,
				MitigationPlan TEXT,
				Comment TEXT,
				History TEXT,
				Projects INT(11) NOT NULL DEFAULT 0,
				ObjectOwner INT(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (id),
				INDEX Status (Status),
				INDEX Probability (Probability),
				INDEX ObjectOwner (ObjectOwner),
				INDEX Projects (Projects),
				INDEX MitigationStrategy (MitigationStrategy),
				INDEX Impact (Impact),
				INDEX Type (Type),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_risks_mailinglists (
				id INT(11) NOT NULL auto_increment ,
				Risks INT(11) NOT NULL DEFAULT 0,
				Contacts INT(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (id),
				INDEX Contacts (Contacts),
				INDEX Risks (Risks));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_riskstatuses (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				ListPosition INT(10) NOT NULL DEFAULT 0,
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description),
				INDEX ListPosition (ListPosition));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_riskstrategies (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_risktypes (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				ListPosition INT(10) NOT NULL DEFAULT 0,
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description),
				INDEX ListPosition (ListPosition));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_roles (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				PRIMARY KEY (id),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_taskfiles (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Date INT(11),
				ObjectOwner INT(11) NOT NULL DEFAULT 0,
				Notes TEXT,
				Tasks INT(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (id),
				INDEX ObjectOwner (ObjectOwner),
				INDEX Description (Description),
				INDEX Tasks (Tasks));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_tasks (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Projects INT(11) NOT NULL DEFAULT 0,
				Priority INT(11) NOT NULL DEFAULT 0,
				Status INT(11) NOT NULL DEFAULT 0,
				Type INT(11) NOT NULL DEFAULT 0,
				ObjectOwner INT(11) NOT NULL DEFAULT 0,
				PlannedDeadline INT(11),
				PlannedEffort INT(10),
				ActualDeadline INT(11),
				ActualEffort INT(10),
				Notes TEXT,
				History TEXT,
				Comment TEXT,
				PRIMARY KEY (id),
				INDEX Priority (Priority),
				INDEX ObjectOwner (ObjectOwner),
				INDEX Description (Description),
				INDEX Status (Status),
				INDEX Type (Type),
				INDEX Projects (Projects));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_tasks_mailinglists (
				id INT(11) NOT NULL auto_increment ,
				Tasks INT(11) NOT NULL DEFAULT 0,
				Contacts INT(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (id),
				INDEX Contacts (Contacts),
				INDEX Tasks (Tasks));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_taskstatuses (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				ListPosition INT(10) NOT NULL DEFAULT 0,
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description),
				INDEX ListPosition (ListPosition));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_tasktypes (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				ListPosition INT(10) NOT NULL DEFAULT 0,
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description),
				INDEX ListPosition (ListPosition));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_userfield1 (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_userfield2 (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_users (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Name VARCHAR(100),
				ObjectOwner INT(11) NOT NULL DEFAULT 0,
				Birthday INT(11),
				Role INT(11) NOT NULL DEFAULT 0,
				CMSId INT(11),
				About TEXT,
				Notes TEXT,
				email VARCHAR(100),
				email2 VARCHAR(100),
				UserType INT(11) NOT NULL DEFAULT 0,
				Cell VARCHAR(30),
				Phone VARCHAR(30),
				SkypeId VARCHAR(100),
				UserField1 INT(11) NOT NULL DEFAULT 0,
				UserField2 INT(11) NOT NULL DEFAULT 0,
				UserField3 TEXT,
				UserField4 TEXT,
				PRIMARY KEY (id),
				INDEX UserField1 (UserField1),
				INDEX ObjectOwner (ObjectOwner),
				INDEX UserField2 (UserField2),
				INDEX Role (Role),
				INDEX UserType (UserType),
				INDEX CMSId (CMSId),
				INDEX descriptionname (Description, Name),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_usertypes (
				id INT(11) NOT NULL auto_increment ,
				Description VARCHAR(200) NOT NULL DEFAULT '',
				Notes TEXT,
				PRIMARY KEY (id),
				INDEX Description (Description));";
				
	$sqls[] = "CREATE TABLE #wp__iprojectweb_acl(
				
				id INT(11) NOT NULL auto_increment,
				objtype VARCHAR(50) NOT NULL,
				method VARCHAR(50) NOT NULL,
				name VARCHAR(50) NOT NULL,
				role VARCHAR(50) NOT NULL,
				
				PRIMARY KEY(id)
				
				);";
	$sqls[] = "INSERT INTO #wp__iprojectweb_acl (id ,objtype ,method ,name ,role) VALUES
				( NULL , 'Projects_Teams', 'view', 'Guest', 'Guest'),
				( NULL , 'Users', 'show', 'Guest', 'Guest'),
				( NULL , 'Priorities', 'show', 'main', 'Owner'),
				( NULL , 'ProjectField1', 'show', 'main', 'Owner'),
				( NULL , 'ProjectField2', 'show', 'main', 'Owner'),
				( NULL , 'ProjectFiles', 'show', 'main', 'Owner'),
				( NULL , 'ProjectFiles', 'viewDetailed', 'detailedMain', 'Owner'),
				( NULL , 'ProjectRoles', 'show', 'main', 'Owner'),
				( NULL , 'Projects', 'show', 'main', 'Owner'),
				( NULL , 'Projects_MailingLists', 'view', 'main', 'Owner'),
				( NULL , 'Projects_Teams', 'view', 'main', 'Owner'),
				( NULL , 'ProjectStatuses', 'show', 'main', 'Owner'),
				( NULL , 'RiskImpacts', 'show', 'main', 'Owner'),
				( NULL , 'RiskProbabilities', 'show', 'main', 'Owner'),
				( NULL , 'Risks', 'show', 'main', 'Owner'),
				( NULL , 'Risks', 'viewDetailed', 'detailedMain', 'Owner'),
				( NULL , 'Risks_MailingLists', 'view', 'main', 'Owner'),
				( NULL , 'RiskStatuses', 'show', 'main', 'Owner'),
				( NULL , 'RiskStrategies', 'show', 'main', 'Owner'),
				( NULL , 'RiskTypes', 'show', 'main', 'Owner'),
				( NULL , 'TaskFiles', 'show', 'main', 'Owner'),
				( NULL , 'TaskFiles', 'viewDetailed', 'detailedMain', 'Owner'),
				( NULL , 'Tasks', 'show', 'main', 'Owner'),
				( NULL , 'Tasks', 'viewDetailed', 'detailedMain', 'Owner'),
				( NULL , 'Tasks_MailingLists', 'view', 'main', 'Owner'),
				( NULL , 'TaskStatuses', 'show', 'main', 'Owner'),
				( NULL , 'TaskTypes', 'show', 'main', 'Owner'),
				( NULL , 'UserField1', 'show', 'main', 'Owner'),
				( NULL , 'UserField2', 'show', 'main', 'Owner'),
				( NULL , 'Users', 'view', 'main', 'Owner'),
				( NULL , 'Users', 'show', 'TeamMember', 'Owner'),
				( NULL , 'UserTypes', 'show', 'main', 'Owner'),
				( NULL , 'Priorities', 'view', 'readonly', 'PM'),
				( NULL , 'ProjectField1', 'view', 'readonly', 'PM'),
				( NULL , 'ProjectField2', 'view', 'readonly', 'PM'),
				( NULL , 'ProjectFiles', 'new', 'main', 'PM'),
				( NULL , 'ProjectFiles', 'show', 'readonly', 'PM'),
				( NULL , 'ProjectFiles', 'viewDetailed', 'detailedMain', 'PM'),
				( NULL , 'ProjectRoles', 'view', 'readonly', 'PM'),
				( NULL , 'Projects', 'view', 'PM', 'PM'),
				( NULL , 'Projects', 'show', 'readonly', 'PM'),
				( NULL , 'Projects_MailingLists', 'view', 'main', 'PM'),
				( NULL , 'Projects_Teams', 'view', 'readonly', 'PM'),
				( NULL , 'ProjectStatuses', 'view', 'readonly', 'PM'),
				( NULL , 'RiskImpacts', 'view', 'readonly', 'PM'),
				( NULL , 'RiskProbabilities', 'view', 'readonly', 'PM'),
				( NULL , 'Risks', 'new', 'main', 'PM'),
				( NULL , 'Risks', 'show', 'readonly', 'PM'),
				( NULL , 'Risks', 'viewDetailed', 'detailedMain', 'PM'),
				( NULL , 'Risks_MailingLists', 'view', 'main', 'PM'),
				( NULL , 'RiskStatuses', 'view', 'readonly', 'PM'),
				( NULL , 'RiskStrategies', 'view', 'readonly', 'PM'),
				( NULL , 'RiskTypes', 'view', 'readonly', 'PM'),
				( NULL , 'TaskFiles', 'new', 'main', 'PM'),
				( NULL , 'TaskFiles', 'show', 'readonly', 'PM'),
				( NULL , 'TaskFiles', 'viewDetailed', 'detailedMain', 'PM'),
				( NULL , 'Tasks', 'view', 'TeamMember', 'PM'),
				( NULL , 'Tasks', 'new', 'main', 'PM'),
				( NULL , 'Tasks', 'show', 'readonly', 'PM'),
				( NULL , 'Tasks', 'viewDetailed', 'detailedMain', 'PM'),
				( NULL , 'Tasks_MailingLists', 'view', 'main', 'PM'),
				( NULL , 'TaskStatuses', 'view', 'readonly', 'PM'),
				( NULL , 'TaskTypes', 'view', 'readonly', 'PM'),
				( NULL , 'UserField1', 'view', 'readonly', 'PM'),
				( NULL , 'UserField2', 'view', 'readonly', 'PM'),
				( NULL , 'Users', 'view', 'readonly', 'PM'),
				( NULL , 'Users', 'show', 'readonly', 'PM'),
				( NULL , 'UserTypes', 'view', 'readonly', 'PM'),
				( NULL , 'Files', 'view', 'main', 'SuperAdmin'),
				( NULL , 'Files', 'new', 'main', 'SuperAdmin'),
				( NULL , 'Files', 'show', 'main', 'SuperAdmin'),
				( NULL , 'Priorities', 'view', 'main', 'SuperAdmin'),
				( NULL , 'Priorities', 'new', 'main', 'SuperAdmin'),
				( NULL , 'Priorities', 'show', 'main', 'SuperAdmin'),
				( NULL , 'ProjectField1', 'view', 'main', 'SuperAdmin'),
				( NULL , 'ProjectField1', 'new', 'main', 'SuperAdmin'),
				( NULL , 'ProjectField1', 'show', 'main', 'SuperAdmin'),
				( NULL , 'ProjectField2', 'view', 'main', 'SuperAdmin'),
				( NULL , 'ProjectField2', 'new', 'main', 'SuperAdmin'),
				( NULL , 'ProjectField2', 'show', 'main', 'SuperAdmin'),
				( NULL , 'ProjectFiles', 'view', 'main', 'SuperAdmin'),
				( NULL , 'ProjectFiles', 'new', 'main', 'SuperAdmin'),
				( NULL , 'ProjectFiles', 'show', 'main', 'SuperAdmin'),
				( NULL , 'ProjectFiles', 'viewDetailed', 'detailedMain', 'SuperAdmin'),
				( NULL , 'ProjectRoles', 'view', 'main', 'SuperAdmin'),
				( NULL , 'ProjectRoles', 'new', 'main', 'SuperAdmin'),
				( NULL , 'ProjectRoles', 'show', 'main', 'SuperAdmin'),
				( NULL , 'Projects', 'view', 'main', 'SuperAdmin'),
				( NULL , 'Projects', 'new', 'main', 'SuperAdmin'),
				( NULL , 'Projects', 'show', 'main', 'SuperAdmin'),
				( NULL , 'Projects_MailingLists', 'view', 'main', 'SuperAdmin'),
				( NULL , 'Projects_Teams', 'view', 'main', 'SuperAdmin'),
				( NULL , 'ProjectStatuses', 'view', 'main', 'SuperAdmin'),
				( NULL , 'ProjectStatuses', 'new', 'main', 'SuperAdmin'),
				( NULL , 'ProjectStatuses', 'show', 'main', 'SuperAdmin'),
				( NULL , 'RiskImpacts', 'view', 'main', 'SuperAdmin'),
				( NULL , 'RiskImpacts', 'new', 'main', 'SuperAdmin'),
				( NULL , 'RiskImpacts', 'show', 'main', 'SuperAdmin'),
				( NULL , 'RiskProbabilities', 'view', 'main', 'SuperAdmin'),
				( NULL , 'RiskProbabilities', 'new', 'main', 'SuperAdmin'),
				( NULL , 'RiskProbabilities', 'show', 'main', 'SuperAdmin'),
				( NULL , 'Risks', 'view', 'main', 'SuperAdmin'),
				( NULL , 'Risks', 'new', 'main', 'SuperAdmin'),
				( NULL , 'Risks', 'show', 'main', 'SuperAdmin'),
				( NULL , 'Risks', 'viewDetailed', 'detailedMain', 'SuperAdmin'),
				( NULL , 'Risks_MailingLists', 'view', 'main', 'SuperAdmin'),
				( NULL , 'RiskStatuses', 'view', 'main', 'SuperAdmin'),
				( NULL , 'RiskStatuses', 'new', 'main', 'SuperAdmin'),
				( NULL , 'RiskStatuses', 'show', 'main', 'SuperAdmin'),
				( NULL , 'RiskStrategies', 'view', 'main', 'SuperAdmin'),
				( NULL , 'RiskStrategies', 'new', 'main', 'SuperAdmin'),
				( NULL , 'RiskStrategies', 'show', 'main', 'SuperAdmin'),
				( NULL , 'RiskTypes', 'view', 'main', 'SuperAdmin'),
				( NULL , 'RiskTypes', 'new', 'main', 'SuperAdmin'),
				( NULL , 'RiskTypes', 'show', 'main', 'SuperAdmin'),
				( NULL , 'TaskFiles', 'view', 'main', 'SuperAdmin'),
				( NULL , 'TaskFiles', 'new', 'main', 'SuperAdmin'),
				( NULL , 'TaskFiles', 'show', 'main', 'SuperAdmin'),
				( NULL , 'TaskFiles', 'viewDetailed', 'detailedMain', 'SuperAdmin'),
				( NULL , 'Tasks', 'view', 'main', 'SuperAdmin'),
				( NULL , 'Tasks', 'new', 'main', 'SuperAdmin'),
				( NULL , 'Tasks', 'show', 'main', 'SuperAdmin'),
				( NULL , 'Tasks', 'viewDetailed', 'detailedMain', 'SuperAdmin'),
				( NULL , 'Tasks_MailingLists', 'view', 'main', 'SuperAdmin'),
				( NULL , 'TaskStatuses', 'view', 'main', 'SuperAdmin'),
				( NULL , 'TaskStatuses', 'new', 'main', 'SuperAdmin'),
				( NULL , 'TaskStatuses', 'show', 'main', 'SuperAdmin'),
				( NULL , 'TaskTypes', 'view', 'main', 'SuperAdmin'),
				( NULL , 'TaskTypes', 'new', 'main', 'SuperAdmin'),
				( NULL , 'TaskTypes', 'show', 'main', 'SuperAdmin'),
				( NULL , 'UserField1', 'view', 'main', 'SuperAdmin'),
				( NULL , 'UserField1', 'new', 'main', 'SuperAdmin'),
				( NULL , 'UserField1', 'show', 'main', 'SuperAdmin'),
				( NULL , 'UserField2', 'view', 'main', 'SuperAdmin'),
				( NULL , 'UserField2', 'new', 'main', 'SuperAdmin'),
				( NULL , 'UserField2', 'show', 'main', 'SuperAdmin'),
				( NULL , 'Users', 'view', 'main', 'SuperAdmin'),
				( NULL , 'Users', 'new', 'main', 'SuperAdmin'),
				( NULL , 'Users', 'show', 'main', 'SuperAdmin'),
				( NULL , 'UserTypes', 'view', 'main', 'SuperAdmin'),
				( NULL , 'UserTypes', 'new', 'main', 'SuperAdmin'),
				( NULL , 'UserTypes', 'show', 'main', 'SuperAdmin'),
				( NULL , 'ApplicationSettings', 'show', 'main', 'SuperAdmin'),
				( NULL , 'Priorities', 'view', 'readonly', 'TeamMember'),
				( NULL , 'ProjectField1', 'view', 'readonly', 'TeamMember'),
				( NULL , 'ProjectField2', 'view', 'readonly', 'TeamMember'),
				( NULL , 'ProjectFiles', 'new', 'main', 'TeamMember'),
				( NULL , 'ProjectFiles', 'show', 'readonly', 'TeamMember'),
				( NULL , 'ProjectFiles', 'viewDetailed', 'detailedMain', 'TeamMember'),
				( NULL , 'ProjectRoles', 'view', 'readonly', 'TeamMember'),
				( NULL , 'Projects', 'view', 'TeamMember', 'TeamMember'),
				( NULL , 'Projects', 'show', 'readonly', 'TeamMember'),
				( NULL , 'Projects_MailingLists', 'view', 'main', 'TeamMember'),
				( NULL , 'Projects_Teams', 'view', 'readonly', 'TeamMember'),
				( NULL , 'ProjectStatuses', 'view', 'readonly', 'TeamMember'),
				( NULL , 'RiskImpacts', 'view', 'readonly', 'TeamMember'),
				( NULL , 'RiskProbabilities', 'view', 'readonly', 'TeamMember'),
				( NULL , 'Risks', 'new', 'readonly', 'TeamMember'),
				( NULL , 'Risks', 'show', 'readonly', 'TeamMember'),
				( NULL , 'Risks', 'viewDetailed', 'detailedMain', 'TeamMember'),
				( NULL , 'Risks_MailingLists', 'view', 'main', 'TeamMember'),
				( NULL , 'RiskStatuses', 'view', 'readonly', 'TeamMember'),
				( NULL , 'RiskStrategies', 'view', 'readonly', 'TeamMember'),
				( NULL , 'RiskTypes', 'view', 'readonly', 'TeamMember'),
				( NULL , 'TaskFiles', 'new', 'main', 'TeamMember'),
				( NULL , 'TaskFiles', 'show', 'readonly', 'TeamMember'),
				( NULL , 'TaskFiles', 'viewDetailed', 'detailedMain', 'TeamMember'),
				( NULL , 'Tasks', 'view', 'TeamMember', 'TeamMember'),
				( NULL , 'Tasks', 'new', 'main', 'TeamMember'),
				( NULL , 'Tasks', 'show', 'readonly', 'TeamMember'),
				( NULL , 'Tasks', 'viewDetailed', 'detailedMain', 'TeamMember'),
				( NULL , 'Tasks_MailingLists', 'view', 'main', 'TeamMember'),
				( NULL , 'TaskStatuses', 'view', 'readonly', 'TeamMember'),
				( NULL , 'TaskTypes', 'view', 'readonly', 'TeamMember'),
				( NULL , 'UserField1', 'view', 'readonly', 'TeamMember'),
				( NULL , 'UserField2', 'view', 'readonly', 'TeamMember'),
				( NULL , 'Users', 'view', 'readonly', 'TeamMember'),
				( NULL , 'Users', 'show', 'readonly', 'TeamMember'),
				( NULL , 'UserTypes', 'view', 'readonly', 'TeamMember');";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	require_once dirName(__FILE__) . DIRECTORY_SEPARATOR . 'iprojectweb_database.php';
	foreach ($sqls as $sql){
		$sql = iProjectWebDB::wptn($sql);
		dbDelta($sql);
	}
}
function iprojectweb_install_data() {
	global $current_user, $wpdb;
	$userid = $current_user->ID;

	$rows = array(
		array(
			'id' => 10,
			'Description' => 'Project Risk 1. Project 1',
			'Type' => 10,
			'Status' => 16,
			'Impact' => 9,
			'MitigationStrategy' => 11,
			'Probability' => 10,
			'Projects' => 5,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 11,
			'Description' => 'Project Risk 2. Project 1',
			'Type' => 10,
			'Status' => 19,
			'Impact' => 11,
			'MitigationStrategy' => 14,
			'Probability' => 11,
			'Projects' => 5,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 12,
			'Description' => 'Contract Risk 3. Project 1',
			'Type' => 11,
			'Status' => 15,
			'Impact' => 10,
			'MitigationStrategy' => 13,
			'Probability' => 10,
			'Projects' => 5,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 13,
			'Description' => 'Project Risk 4. Project 1',
			'Type' => 10,
			'Status' => 18,
			'Impact' => 10,
			'MitigationStrategy' => 13,
			'Probability' => 10,
			'Projects' => 5,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 14,
			'Description' => 'Project Risk 5. Project 1',
			'Type' => 10,
			'Status' => 18,
			'Impact' => 10,
			'MitigationStrategy' => 13,
			'Probability' => 10,
			'Projects' => 5,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 20,
			'Description' => 'Project Risk 2. Project 3',
			'Type' => 10,
			'Status' => 19,
			'Impact' => 10,
			'MitigationStrategy' => 14,
			'Probability' => 10,
			'Projects' => 7,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 15,
			'Description' => 'Contract Risk 1. Project 2',
			'Type' => 11,
			'Status' => 17,
			'Impact' => 10,
			'MitigationStrategy' => 13,
			'Probability' => 10,
			'Projects' => 6,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 16,
			'Description' => 'Technical Risk 2. Project 2',
			'Type' => 9,
			'Status' => 18,
			'Impact' => 9,
			'MitigationStrategy' => 12,
			'Probability' => 9,
			'Projects' => 6,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 21,
			'Description' => 'Technical Risk 3. Project 3',
			'Type' => 9,
			'Status' => 15,
			'Impact' => 9,
			'MitigationStrategy' => 11,
			'Probability' => 9,
			'Projects' => 7,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 17,
			'Description' => 'Project Risk 3. Project 2',
			'Type' => 10,
			'Status' => 16,
			'Impact' => 10,
			'MitigationStrategy' => 12,
			'Probability' => 10,
			'Projects' => 6,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 22,
			'Description' => 'Technical Risk 4. Project 3',
			'Type' => 9,
			'Status' => 16,
			'Impact' => 9,
			'MitigationStrategy' => 12,
			'Probability' => 9,
			'Projects' => 7,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 18,
			'Description' => 'Project Risk 4. Project 2',
			'Type' => 10,
			'Status' => 15,
			'Impact' => 10,
			'MitigationStrategy' => 11,
			'Probability' => 10,
			'Projects' => 6,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 23,
			'Description' => 'Technical Risk 1. Project 4',
			'Type' => 9,
			'Status' => 15,
			'Impact' => 10,
			'MitigationStrategy' => 13,
			'Probability' => 9,
			'Projects' => 8,
			'ObjectOwner' => 67,
		),
		array(
			'id' => 19,
			'Description' => 'Contract Risk 1. Project 3',
			'Type' => 11,
			'Status' => 17,
			'Impact' => 11,
			'MitigationStrategy' => 12,
			'Probability' => 11,
			'Projects' => 7,
			'ObjectOwner' => 67,
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_risks');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 88,
			'Description' => 'female',
			'Notes' => 'Aliquam facilisis dolor id diam tempus sed vestibulum magna varius. Duis quis libero libero. Pellentesque elementum dictum lorem, ut sagittis orci adipiscing sed. Donec elementum nisl a odio consequat accumsan. Nam sagittis scelerisque purus in eleifend. Curabitur eget quam lorem, vitae tristique tortor. Vestibulum pretium ante sit amet velit pharetra at rhoncus lorem interdum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
		),
		array(
			'id' => 86,
			'Description' => 'unknown',
			'Notes' => 'Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.<br /><br />Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.',
		),
		array(
			'id' => 87,
			'Description' => 'male',
			'Notes' => 'Aliquam facilisis dolor id diam tempus sed vestibulum magna varius. Duis quis libero libero. Pellentesque elementum dictum lorem, ut sagittis orci adipiscing sed. Donec elementum nisl a odio consequat accumsan. Nam sagittis scelerisque purus in eleifend. Curabitur eget quam lorem, vitae tristique tortor. Vestibulum pretium ante sit amet velit pharetra at rhoncus lorem interdum. <br /><br />Aliquam facilisis dolor id diam tempus sed vestibulum magna varius. Duis quis libero libero. Pellentesque elementum dictum lorem, ut sagittis orci adipiscing sed. Donec elementum nisl a odio consequat accumsan. Nam sagittis scelerisque purus in eleifend. Curabitur eget quam lorem, vitae tristique tortor. Vestibulum pretium ante sit amet velit pharetra at rhoncus lorem interdum.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_userfield1');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 6,
			'Description' => 'Custom value 3',
			'Notes' => 'Nulla facilisi. Sed lobortis, sem in tincidunt pharetra, nulla velit malesuada orci, at molestie turpis justo eu felis. Aenean turpis ante, eleifend eget tempor at, dictum vitae felis. Proin feugiat posuere libero et porta. Curabitur varius scelerisque turpis, ut aliquam metus ornare in.<br /><br />Nulla facilisi. Sed lobortis, sem in tincidunt pharetra, nulla velit malesuada orci, at molestie turpis justo eu felis. Aenean turpis ante, eleifend eget tempor at, dictum vitae felis. Proin feugiat posuere libero et porta. Curabitur varius scelerisque turpis, ut aliquam metus ornare in.',
		),
		array(
			'id' => 4,
			'Description' => 'Custom value 1',
			'Notes' => 'Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien. <br /><br />Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien.',
		),
		array(
			'id' => 5,
			'Description' => 'Custom value 2',
			'Notes' => 'Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.<br /><br />Aliquam facilisis dolor id diam tempus sed vestibulum magna varius. Duis quis libero libero. Pellentesque elementum dictum lorem, ut sagittis orci adipiscing sed. Donec elementum nisl a odio consequat accumsan. Nam sagittis scelerisque purus in eleifend. Curabitur eget quam lorem, vitae tristique tortor. Vestibulum pretium ante sit amet velit pharetra at rhoncus lorem interdum.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_projectfield2');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array('id' => 1, 'Description' => 'SuperAdmin'),
		array('id' => 2, 'Description' => 'Owner'),
		array('id' => 3, 'Description' => 'TeamMember'),
		array('id' => 4, 'Description' => 'Guest'),
		array('id' => 6, 'Description' => 'PM'),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_roles');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 8,
			'Description' => 'Project 4',
			'Status' => 9,
			'StartDate' => 1332021600,
			'FinishDate' => 1340488800,
			'ObjectOwner' => 66,
			'ProjectField1' => 4,
			'ProjectField2' => 4,
			'ProjectDescription' => 'Praesent vel quam nunc. Aliquam cursus blandit semper.<br /><br />Praesent vel quam nunc. Aliquam cursus blandit semper.<br /><br />Quisque nec est ut velit commodo interdum. Sed vel metus nec elit sagittis tempus.',
		),
		array(
			'id' => 5,
			'Description' => 'Project 1',
			'Status' => 10,
			'StartDate' => 1367100000,
			'FinishDate' => 1340229600,
			'ObjectOwner' => 65,
			'ProjectField1' => 5,
			'ProjectField2' => 4,
			'ProjectDescription' => 'Aliquam erat volutpat. Maecenas ultricies feugiat dui vitae pulvinar. Integer convallis ultrices tempor. Ut consequat nunc eget tellus ultrices sollicitudin. Phasellus mattis scelerisque vestibulum. Nulla facilisi. Pellentesque imperdiet vestibulum mauris, in condimentum arcu dignissim sed. Suspendisse potenti. Nulla pretium ultricies erat, vitae scelerisque tortor semper et. <br /><br />Aliquam erat volutpat. Maecenas ultricies feugiat dui vitae pulvinar. Integer convallis ultrices tempor. Ut consequat nunc eget tellus ultrices sollicitudin. Phasellus mattis scelerisque vestibulum. Nulla facilisi. Pellentesque imperdiet vestibulum mauris, in condimentum arcu dignissim sed. Suspendisse potenti. Nulla pretium ultricies erat, vitae scelerisque tortor semper et. <br /><br />Nam est nunc, rhoncus non tincidunt vitae, ultricies quis nunc. Nulla eu ipsum nec nunc fringilla sagittis.',
		),
		array(
			'id' => 6,
			'Description' => 'Project 2',
			'Status' => 10,
			'StartDate' => 1358805600,
			'FinishDate' => 1340834400,
			'ObjectOwner' => 67,
			'ProjectField1' => 5,
			'ProjectField2' => 5,
			'ProjectDescription' => 'Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien. <br /><br />Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien. <br /><br />Morbi pulvinar malesuada risus in tempor. Fusce eu sapien a sem aliquet pulvinar. Nullam elementum facilisis quam, sed sollicitudin tortor gravida et. Nam elit arcu, imperdiet eu rhoncus eget, molestie vitae augue. Sed posuere fermentum ultricies. Duis non odio in urna tempor elementum vitae consequat nibh. Suspendisse commodo, lacus eleifend tempus lacinia, enim odio consequat enim, eget posuere ipsum erat suscipit nisi. Ut mi justo, aliquet euismod luctus et, posuere quis enim. Aliquam sollicitudin nunc ut ante dictum sed convallis lectus feugiat.',
		),
		array(
			'id' => 7,
			'Description' => 'Project 3',
			'Status' => 10,
			'StartDate' => 1365976800,
			'FinishDate' => 1339452000,
			'ObjectOwner' => 65,
			'ProjectField1' => 4,
			'ProjectField2' => 6,
			'ProjectDescription' => 'Aenean in arcu arcu. Curabitur non fringilla augue. Quisque euismod augue ac massa accumsan ornare. Aliquam egestas egestas ligula nec vestibulum. Phasellus a neque at justo porttitor placerat. Phasellus at nisl sapien. Nam laoreet lacus ut ligula convallis quis sollicitudin sem convallis. Vestibulum vel magna lectus. Nam fringilla convallis eros, sed hendrerit dolor fringilla id. <br /><br />Aenean in arcu arcu. Curabitur non fringilla augue. Quisque euismod augue ac massa accumsan ornare. Aliquam egestas egestas ligula nec vestibulum. Phasellus a neque at justo porttitor placerat. Phasellus at nisl sapien. Nam laoreet lacus ut ligula convallis quis sollicitudin sem convallis. Vestibulum vel magna lectus. Nam fringilla convallis eros, sed hendrerit dolor fringilla id. <br /><br />Aenean in arcu arcu. Curabitur non fringilla augue. Quisque euismod augue ac massa accumsan ornare. Aliquam egestas egestas ligula nec vestibulum. Phasellus a neque at justo porttitor placerat. Phasellus at nisl sapien. Nam laoreet lacus ut ligula convallis quis sollicitudin sem convallis. Vestibulum vel magna lectus. Nam fringilla convallis eros, sed hendrerit dolor fringilla id.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_projects');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 18,
			'Description' => 'Monitored',
			'ListPosition' => 18,
			'Notes' => 'Morbi quis magna urna, id viverra ipsum. Fusce nibh orci, interdum id pharetra ut, ultricies vel metus. Donec eget justo augue, vel semper tellus. Morbi venenatis turpis eget eros imperdiet fringilla. Donec eu tincidunt felis. Sed nec nunc id nibh vestibulum tempor eu ac lectus. Maecenas eu tincidunt turpis. Nunc mollis laoreet quam hendrerit dictum. Nulla blandit neque quis magna rutrum tincidunt. Etiam turpis ante, cursus a sagittis non, vehicula in odio. Nullam sed velit odio.<br /><br />Morbi quis magna urna, id viverra ipsum. Fusce nibh orci, interdum id pharetra ut, ultricies vel metus. Donec eget justo augue, vel semper tellus. Morbi venenatis turpis eget eros imperdiet fringilla. Donec eu tincidunt felis. Sed nec nunc id nibh vestibulum tempor eu ac lectus. Maecenas eu tincidunt turpis. Nunc mollis laoreet quam hendrerit dictum. Nulla blandit neque quis magna rutrum tincidunt. Etiam turpis ante, cursus a sagittis non, vehicula in odio. Nullam sed velit odio.',
		),
		array(
			'id' => 19,
			'Description' => 'Closed',
			'ListPosition' => 19,
			'Notes' => 'Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.<br /><br />Nulla facilisi. Sed lobortis, sem in tincidunt pharetra, nulla velit malesuada orci, at molestie turpis justo eu felis. Aenean turpis ante, eleifend eget tempor at, dictum vitae felis. Proin feugiat posuere libero et porta. Curabitur varius scelerisque turpis, ut aliquam metus ornare in.',
		),
		array(
			'id' => 15,
			'Description' => 'Indentified',
			'ListPosition' => 15,
			'Notes' => 'Nulla tincidunt justo nec diam molestie feugiat. Aenean et est non sapien ultrices posuere id a odio. <br /><br />Nulla tincidunt justo nec diam molestie feugiat. Aenean et est non sapien ultrices posuere id a odio.',
		),
		array(
			'id' => 16,
			'Description' => 'Analyzed',
			'ListPosition' => 16,
			'Notes' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis. <br /><br />Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.',
		),
		array(
			'id' => 17,
			'Description' => 'Planned',
			'ListPosition' => 17,
			'Notes' => 'Praesent ut facilisis odio. Maecenas congue neque ut nisi placerat vitae suscipit mauris fermentum. Praesent non sem tincidunt odio placerat tincidunt. Nulla gravida lectus sed urna mollis lacinia. Ut egestas viverra volutpat. Vestibulum quis nunc erat. Donec faucibus magna at quam condimentum convallis lobortis ante aliquet. Mauris tempor, ipsum a sollicitudin molestie, orci dui laoreet nulla, non accumsan erat libero a nisl. Quisque id luctus enim. Pellentesque id purus odio. Sed cursus pharetra enim eget tempor.<br /><br />Praesent ut facilisis odio. Maecenas congue neque ut nisi placerat vitae suscipit mauris fermentum. Praesent non sem tincidunt odio placerat tincidunt. Nulla gravida lectus sed urna mollis lacinia. Ut egestas viverra volutpat. Vestibulum quis nunc erat. Donec faucibus magna at quam condimentum convallis lobortis ante aliquet. Mauris tempor, ipsum a sollicitudin molestie, orci dui laoreet nulla, non accumsan erat libero a nisl. Quisque id luctus enim. Pellentesque id purus odio. Sed cursus pharetra enim eget tempor.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_riskstatuses');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 9,
			'Description' => 'Assigned',
			'ListPosition' => 9,
			'Notes' => 'Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.<br /><br />Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.',
		),
		array(
			'id' => 11,
			'Description' => 'Done',
			'ListPosition' => 11,
			'Notes' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis. <br /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis.',
		),
		array(
			'id' => 10,
			'Description' => 'In Progress',
			'ListPosition' => 10,
			'Notes' => 'In ut tristique erat. Vestibulum sodales mollis metus a lacinia. Quisque non nibh turpis. Phasellus posuere elit vitae nunc tristique volutpat. Fusce eu diam ligula, sit amet egestas ante.<br /><br />Duis purus ipsum, consectetur quis scelerisque in, fringilla id nunc. In bibendum eros quis nulla tempus vitae iaculis ante euismod. Proin condimentum mi eu felis consequat sollicitudin consequat arcu luctus. Nullam eros mauris, vulputate imperdiet cursus ut, porttitor ut risus. Vestibulum nec est non justo blandit mollis. Phasellus condimentum nulla felis, nec gravida lacus. Curabitur urna nunc, consequat vel pharetra nec, rhoncus eu nisl. Donec tincidunt sollicitudin libero, et fringilla urna feugiat in. In viverra elementum augue quis laoreet. Maecenas eget dui felis. Quisque rhoncus sodales bibendum.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_taskstatuses');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 9,
			'Description' => 'High',
			'Notes' => 'Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci. <br /><br />Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci. <br /><br />Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci.',
		),
		array(
			'id' => 11,
			'Description' => 'Low',
			'Notes' => 'Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna. <br /><br />Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna. <br /><br />Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.',
		),
		array(
			'id' => 10,
			'Description' => 'Med',
			'Notes' => 'Quisque tincidunt magna id magna scelerisque tempor. <br /><br />Quisque tincidunt magna id magna scelerisque tempor. <br /><br />Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_userfield2');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 6,
			'Description' => 'QA Manager',
			'Notes' => 'Nullam a neque dolor. Pellentesque elementum, magna quis interdum volutpat, libero ipsum scelerisque turpis, porta pretium dolor lectus ac risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam quam est, malesuada vitae accumsan ut, dapibus condimentum ligula. Integer eget feugiat velit. Duis ut tortor quis enim convallis consectetur ut posuere metus.<br /><br />Nullam a neque dolor. Pellentesque elementum, magna quis interdum volutpat, libero ipsum scelerisque turpis, porta pretium dolor lectus ac risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam quam est, malesuada vitae accumsan ut, dapibus condimentum ligula. Integer eget feugiat velit. Duis ut tortor quis enim convallis consectetur ut posuere metus.',
		),
		array(
			'id' => 4,
			'Description' => 'Designer',
			'Notes' => 'Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
		),
		array(
			'id' => 5,
			'Description' => 'Engineer',
			'Notes' => 'Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_projectroles');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 70,
			'Description' => 'Byrd',
			'Name' => 'Thelma',
			'ObjectOwner' => 66,
			'Birthday' => 285717600,
			'About' => 'Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
			'email' => 'thelma@taskmanweb.example.com',
			'email2' => 'thelma2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+22 277-7722',
			'Phone' => '+22 666-6887',
		),
		array(
			'id' => 65,
			'Description' => 'pm',
			'Name' => 'PM',
			'ObjectOwner' => 65,
			'Birthday' => 222040800,
			'Role' => 6,
			'CMSId' => 7,
			'About' => 'Praesent vel quam nunc. Aliquam cursus blandit semper.<br /><br />Praesent vel quam nunc. Aliquam cursus blandit semper.',
			'email' => 'pm@taskmanweb.example.com',
			'email2' => 'pm2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+88 006-6669',
			'Phone' => '+99 555-5555',
		),
		array(
			'id' => 71,
			'Description' => 'Rowe',
			'Name' => 'Leona',
			'ObjectOwner' => 66,
			'Birthday' => 158277600,
			'About' => 'Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.<br /><br />Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.',
			'email' => 'leona@taskmanweb.example.com',
			'email2' => 'leona2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+74 444-9999',
			'Phone' => '+00 066-6333',
		),
		array(
			'id' => 66,
			'Description' => 'superadmin',
			'Name' => 'SuperAdmin',
			'ObjectOwner' => 66,
			'Birthday' => 221349600,
			'Role' => 1,
			'CMSId' => $userid,
			'About' => 'Aliquam eu nisi vel lorem ultricies laoreet. Nulla eget mi ac leo porttitor luctus a nec purus. Phasellus in erat at nulla feugiat aliquam. Vivamus non eros quis tellus consectetur condimentum eget eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris commodo magna vitae libero blandit ultrices eu vulputate nisl. <br /><br />Aliquam eu nisi vel lorem ultricies laoreet. Nulla eget mi ac leo porttitor luctus a nec purus. Phasellus in erat at nulla feugiat aliquam. Vivamus non eros quis tellus consectetur condimentum eget eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris commodo magna vitae libero blandit ultrices eu vulputate nisl.',
			'email' => 'superadmin@taskmanweb.example.com',
			'email2' => 'superadmin2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+11 114-4440',
			'Phone' => '+00 066-6655',
		),
		array(
			'id' => 67,
			'Description' => 'teammember',
			'Name' => 'TeamMember',
			'ObjectOwner' => 67,
			'Birthday' => 127692000,
			'Role' => 3,
			'CMSId' => 9,
			'About' => 'Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
			'email' => 'teammember@taskmanweb.example.com',
			'email2' => 'teammember2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+58 888-9993',
			'Phone' => '+33 555-5442',
		),
		array(
			'id' => 72,
			'Description' => 'Little',
			'Name' => 'Pedro',
			'ObjectOwner' => 66,
			'Birthday' => 127519200,
			'About' => 'Nam est nunc, rhoncus non tincidunt vitae, ultricies quis nunc. Nulla eu ipsum nec nunc fringilla sagittis. <br /><br />Nam est nunc, rhoncus non tincidunt vitae, ultricies quis nunc. Nulla eu ipsum nec nunc fringilla sagittis.',
			'email' => 'pedro@taskmanweb.example.com',
			'email2' => 'pedro2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+44 444-4440',
			'Phone' => '+05 555-2222',
		),
		array(
			'id' => 68,
			'Description' => 'Johnson',
			'Name' => 'Robert',
			'ObjectOwner' => 66,
			'Birthday' => 317340000,
			'About' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis. <br /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis.',
			'email' => 'robert@taskmanweb.example.com',
			'email2' => 'robert2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+66 667-0099',
			'Phone' => '+96 666-3333',
		),
		array(
			'id' => 73,
			'Description' => 'Lowe',
			'Name' => 'Debbie',
			'ObjectOwner' => 66,
			'Birthday' => 348962400,
			'About' => 'Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam. <br /><br />Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam.',
			'email' => 'debbie@taskmanweb.example.com',
			'email2' => 'debbie2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+80 000-7777',
			'Phone' => '+88 886-6699',
		),
		array(
			'id' => 69,
			'Description' => 'Patton',
			'Name' => 'Molly',
			'ObjectOwner' => 66,
			'Birthday' => 95551200,
			'About' => 'Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna. <br /><br />Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna.',
			'email' => 'molly@taskmanweb.example.com',
			'email2' => 'molly2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+88 666-1111',
			'Phone' => '+11 177-7711',
		),
		array(
			'id' => 74,
			'Description' => 'Mccoy',
			'Name' => 'Julie',
			'ObjectOwner' => 66,
			'Birthday' => 65397600,
			'About' => 'Phasellus in metus in magna vestibulum ultricies. In nec metus mauris, vitae semper justo. Suspendisse posuere leo vel velit pellentesque ornare eget vitae libero. Sed feugiat augue nec metus pulvinar eget porttitor nunc sollicitudin. Proin mattis, dolor vitae vehicula sagittis, justo tellus adipiscing leo, quis sagittis risus eros vel quam. Morbi id nisl purus. Nulla porta leo elit.<br /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc varius ipsum a orci semper a lobortis mi fermentum.',
			'email' => 'julie@taskmanweb.example.com',
			'email2' => 'julie2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+33 555-5999',
			'Phone' => '+91 111-0000',
		),
		array(
			'id' => 80,
			'Description' => 'Parks',
			'Name' => 'Kristen',
			'ObjectOwner' => 66,
			'Birthday' => 254354400,
			'About' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis. <br /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis.',
			'email' => 'kristen@taskmanweb.example.com',
			'email2' => 'kristen2@taskmanweb.example.com',
			'UserType' => 2,
			'Cell' => '+06 666-2222',
			'Phone' => '+55 544-4466',
		),
		array(
			'id' => 75,
			'Description' => 'Lloyd',
			'Name' => 'Elvira',
			'ObjectOwner' => 66,
			'Birthday' => 96328800,
			'About' => 'Nam est nunc, rhoncus non tincidunt vitae, ultricies quis nunc. Nulla eu ipsum nec nunc fringilla sagittis. <br /><br />Nam est nunc, rhoncus non tincidunt vitae, ultricies quis nunc. Nulla eu ipsum nec nunc fringilla sagittis.',
			'email' => 'elvira@taskmanweb.example.com',
			'email2' => 'elvira2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+43 333-3330',
			'Phone' => '+03 339-9991',
		),
		array(
			'id' => 81,
			'Description' => 'Francis',
			'Name' => 'Sandy',
			'ObjectOwner' => 66,
			'Birthday' => 160005600,
			'About' => 'Nulla tincidunt justo nec diam molestie feugiat. Aenean et est non sapien ultrices posuere id a odio. <br /><br />Nulla tincidunt justo nec diam molestie feugiat. Aenean et est non sapien ultrices posuere id a odio.',
			'email' => 'sandy@taskmanweb.example.com',
			'email2' => 'sandy2@taskmanweb.example.com',
			'UserType' => 3,
			'Cell' => '+19 999-9555',
			'Phone' => '+53 333-6663',
		),
		array(
			'id' => 76,
			'Description' => 'Washington',
			'Name' => 'Lena',
			'ObjectOwner' => 66,
			'Birthday' => 95292000,
			'About' => 'Nulla tincidunt justo nec diam molestie feugiat. Aenean et est non sapien ultrices posuere id a odio. <br /><br />Nulla tincidunt justo nec diam molestie feugiat. Aenean et est non sapien ultrices posuere id a odio.',
			'email' => 'lena@taskmanweb.example.com',
			'email2' => 'lena2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+17 777-8888',
			'Phone' => '+88 889-9991',
		),
		array(
			'id' => 77,
			'Description' => 'West',
			'Name' => 'Dustin',
			'ObjectOwner' => 66,
			'Birthday' => 191628000,
			'About' => 'Praesent ut facilisis odio. Maecenas congue neque ut nisi placerat vitae suscipit mauris fermentum. Praesent non sem tincidunt odio placerat tincidunt. Nulla gravida lectus sed urna mollis lacinia. Ut egestas viverra volutpat. Vestibulum quis nunc erat. Donec faucibus magna at quam condimentum convallis lobortis ante aliquet. Mauris tempor, ipsum a sollicitudin molestie, orci dui laoreet nulla, non accumsan erat libero a nisl. Quisque id luctus enim. Pellentesque id purus odio. Sed cursus pharetra enim eget tempor.<br /><br />Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam.',
			'email' => 'dustin@taskmanweb.example.com',
			'email2' => 'dustin2@taskmanweb.example.com',
			'UserType' => 4,
			'Cell' => '+88 844-4433',
			'Phone' => '+33 000-0000',
		),
		array(
			'id' => 82,
			'Description' => 'Lowe',
			'Name' => 'April',
			'ObjectOwner' => 66,
			'Birthday' => 64965600,
			'About' => 'Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.<br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.',
			'email' => 'april@taskmanweb.example.com',
			'email2' => 'april2@taskmanweb.example.com',
			'UserType' => 3,
			'Cell' => '+22 257-7799',
			'Phone' => '+99 111-1000',
		),
		array(
			'id' => 78,
			'Description' => 'Malone',
			'Name' => 'Kristine',
			'ObjectOwner' => 66,
			'Birthday' => 189468000,
			'About' => 'Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam. <br /><br />Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci.',
			'email' => 'kristine@taskmanweb.example.com',
			'email2' => 'kristine2@taskmanweb.example.com',
			'UserType' => 2,
			'Cell' => '+66 999-9777',
			'Phone' => '+78 888-6666',
		),
		array(
			'id' => 83,
			'Description' => 'Gregory',
			'Name' => 'Jodi',
			'ObjectOwner' => 66,
			'Birthday' => 190072800,
			'About' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. <br /><br />Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
			'email' => 'jodi@taskmanweb.example.com',
			'email2' => 'jodi2@taskmanweb.example.com',
			'UserType' => 3,
			'Cell' => '+58 888-7777',
			'Phone' => '+00 033-3344',
		),
		array(
			'id' => 79,
			'Description' => 'Fitzgerald',
			'Name' => 'Patty',
			'ObjectOwner' => 66,
			'Birthday' => 348616800,
			'About' => 'Praesent vel quam nunc. Aliquam cursus blandit semper.<br /><br />Praesent vel quam nunc. Aliquam cursus blandit semper.',
			'email' => 'patty@taskmanweb.example.com',
			'email2' => 'patty2@taskmanweb.example.com',
			'UserType' => 2,
			'Cell' => '+11 166-6666',
			'Phone' => '+66 000-0999',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_users');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array('Projects' => 6, 'Members' => 67, 'Role' => 4),
		array('Projects' => 8, 'Members' => 66, 'Role' => 4),
		array('Projects' => 6, 'Members' => 76, 'Role' => 6),
		array('Projects' => 7, 'Members' => 77, 'Role' => 6),
		array('Projects' => 5, 'Members' => 73, 'Role' => 5),
		array('Projects' => 5, 'Members' => 76, 'Role' => 6),
		array('Projects' => 5, 'Members' => 68, 'Role' => 4),
		array('Projects' => 5, 'Members' => 69, 'Role' => 5),
		array('Projects' => 8, 'Members' => 71, 'Role' => 4),
		array('Projects' => 5, 'Members' => 70, 'Role' => 5),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_projects_teams');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 9,
			'Description' => 'High',
			'ListPosition' => 9,
			'Notes' => 'Nulla dui ipsum, bibendum vel ultricies eu, dapibus sit amet eros. Nam augue lectus, dapibus rutrum mattis bibendum, porttitor quis orci. Cras est nulla, dictum quis auctor ut, bibendum vitae diam. Nulla dui tortor, pulvinar id lacinia a, condimentum ut ipsum. Mauris sagittis, arcu eu auctor egestas, purus justo posuere quam, ac porttitor ante tellus eget lorem. In hac habitasse platea dictumst. <br /><br />Nulla dui ipsum, bibendum vel ultricies eu, dapibus sit amet eros. Nam augue lectus, dapibus rutrum mattis bibendum, porttitor quis orci. Cras est nulla, dictum quis auctor ut, bibendum vitae diam. Nulla dui tortor, pulvinar id lacinia a, condimentum ut ipsum. Mauris sagittis, arcu eu auctor egestas, purus justo posuere quam, ac porttitor ante tellus eget lorem. In hac habitasse platea dictumst.',
		),
		array(
			'id' => 11,
			'Description' => 'Low',
			'ListPosition' => 11,
			'Notes' => 'Maecenas lacinia arcu nec nisl elementum nec cursus massa consequat. <br /><br />Maecenas lacinia arcu nec nisl elementum nec cursus massa consequat.',
		),
		array(
			'id' => 10,
			'Description' => 'Medium',
			'ListPosition' => 10,
			'Notes' => 'Morbi quis magna urna, id viverra ipsum. Fusce nibh orci, interdum id pharetra ut, ultricies vel metus. Donec eget justo augue, vel semper tellus. Morbi venenatis turpis eget eros imperdiet fringilla. Donec eu tincidunt felis. Sed nec nunc id nibh vestibulum tempor eu ac lectus. Maecenas eu tincidunt turpis. Nunc mollis laoreet quam hendrerit dictum. Nulla blandit neque quis magna rutrum tincidunt. Etiam turpis ante, cursus a sagittis non, vehicula in odio. Nullam sed velit odio.<br /><br />Morbi quis magna urna, id viverra ipsum. Fusce nibh orci, interdum id pharetra ut, ultricies vel metus. Donec eget justo augue, vel semper tellus. Morbi venenatis turpis eget eros imperdiet fringilla. Donec eu tincidunt felis. Sed nec nunc id nibh vestibulum tempor eu ac lectus. Maecenas eu tincidunt turpis. Nunc mollis laoreet quam hendrerit dictum. Nulla blandit neque quis magna rutrum tincidunt. Etiam turpis ante, cursus a sagittis non, vehicula in odio. Nullam sed velit odio.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_riskimpacts');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 9,
			'Description' => 'Technical Risk',
			'ListPosition' => 9,
			'Notes' => 'Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien.',
		),
		array(
			'id' => 11,
			'Description' => 'Contract Risk',
			'ListPosition' => 11,
			'Notes' => 'Phasellus in metus in magna vestibulum ultricies. In nec metus mauris, vitae semper justo. Suspendisse posuere leo vel velit pellentesque ornare eget vitae libero. Sed feugiat augue nec metus pulvinar eget porttitor nunc sollicitudin. Proin mattis, dolor vitae vehicula sagittis, justo tellus adipiscing leo, quis sagittis risus eros vel quam. Morbi id nisl purus. Nulla porta leo elit.<br /><br />Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien.',
		),
		array(
			'id' => 10,
			'Description' => 'Project Risk',
			'ListPosition' => 10,
			'Notes' => 'Maecenas lacinia arcu nec nisl elementum nec cursus massa consequat. <br /><br />Maecenas lacinia arcu nec nisl elementum nec cursus massa consequat.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_risktypes');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 1,
			'Description' => 'Application Settings',
			'Projects_NotifyOnStatusChange' => 1,
			'Projects_NotifyOnNewComment' => 1,
			'Projects_EmailTemplate' => 'Project:{Title}
Status:{Status}

{messagebody}',
			'Tasks_NotifyOnStatusChange' => 1,
			'Tasks_NotifyOnNewComment' => 1,
			'Tasks_EmailTemplate' => 'Task: {Title}
Project: {Project}
Status: {Status}
Priority: {Priority}

{messagebody}',
			'Risks_NotifyOnStatusChange' => 1,
			'Risks_NotifyOnNewComment' => 1,
			'Risks_EmailTemplate' => 'Risk :{Title}
Project: {Project}
Status: {Status}

{messagebody}',
			'TinyMCEConfig' => '{theme_advanced_buttons4:"",mode:"exact",theme_advanced_statusbar_location:"",theme_advanced_toolbar_align:"left",theme_advanced_resizing:"true",plugins:"fullscreen",theme_advanced_toolbar_location:"top",theme_advanced_buttons1:"bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",theme_advanced_buttons2:"bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,|,forecolor,backcolor,|,fullscreen",theme_advanced_buttons3:"",theme:"advanced"}',
			'UseTinyMCE' => 1,
			'Projects_EmailFormatHTML' => 0,
			'Tasks_EmailFormatHTML' => 0,
			'Risks_EmailFormatHTML' => 0,
			'ApplicationWidth' => 800,
			'ApplicationWidth2' => 900,
			'DefaultStyle' => 'std',
			'DefaultStyle2' => 'std',
			'NotLoggenInText' => 'Please log in.',
			'FileFolder' => 'files',
			'NewCommentSubject' => '%1$s. %2$s. [%3$s]. New comment',
			'StatusChangeSubject' => '%1$s. %2$s. [%3$s]. Status changed',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_applicationsettings');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 9,
			'Description' => 'Development',
			'ListPosition' => 9,
			'Notes' => 'Quisque nec est ut velit commodo interdum. Sed vel metus nec elit sagittis tempus. <br /><br />Quisque nec est ut velit commodo interdum. Sed vel metus nec elit sagittis tempus.',
		),
		array(
			'id' => 8,
			'Description' => 'Planning',
			'ListPosition' => 8,
			'Notes' => 'Aliquam eu nisi vel lorem ultricies laoreet. Nulla eget mi ac leo porttitor luctus a nec purus. Phasellus in erat at nulla feugiat aliquam. Vivamus non eros quis tellus consectetur condimentum eget eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris commodo magna vitae libero blandit ultrices eu vulputate nisl. <br /><br />Aliquam eu nisi vel lorem ultricies laoreet. Nulla eget mi ac leo porttitor luctus a nec purus. Phasellus in erat at nulla feugiat aliquam. Vivamus non eros quis tellus consectetur condimentum eget eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris commodo magna vitae libero blandit ultrices eu vulputate nisl.',
		),
		array(
			'id' => 10,
			'Description' => 'Finalizing',
			'ListPosition' => 10,
			'Notes' => 'In ut tristique erat. Vestibulum sodales mollis metus a lacinia. Quisque non nibh turpis. Phasellus posuere elit vitae nunc tristique volutpat. Fusce eu diam ligula, sit amet egestas ante.<br /><br />In ut tristique erat. Vestibulum sodales mollis metus a lacinia. Quisque non nibh turpis. Phasellus posuere elit vitae nunc tristique volutpat. Fusce eu diam ligula, sit amet egestas ante.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_tasktypes');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 76,
			'Description' => 'Development 13 for Project 3',
			'Projects' => 7,
			'Priority' => 14,
			'Status' => 10,
			'Type' => 9,
			'ObjectOwner' => 70,
			'PlannedDeadline' => 1359842400,
			'PlannedEffort' => 16,
			'ActualDeadline' => 1363816800,
			'ActualEffort' => 16,
			'Notes' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc varius ipsum a orci semper a lobortis mi fermentum. <br /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc varius ipsum a orci semper a lobortis mi fermentum. <br /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc varius ipsum a orci semper a lobortis mi fermentum.',
		),
		array(
			'id' => 77,
			'Description' => 'Finalizing 14 for Project 3',
			'Projects' => 7,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 10,
			'ObjectOwner' => 72,
			'PlannedDeadline' => 1363903200,
			'PlannedEffort' => 10,
			'ActualDeadline' => 1367100000,
			'ActualEffort' => 10,
			'Notes' => 'Nunc molestie hendrerit arcu, non dapibus nulla suscipit ac. Nam eget nulla sit amet ante mollis pharetra. Fusce tincidunt diam vitae libero venenatis posuere. Nullam luctus rhoncus turpis in lacinia. Vestibulum pellentesque, erat id pretium consequat, est mauris interdum dolor, sit amet elementum urna neque ac neque. Nam dapibus lacinia est, nec rhoncus magna convallis id. Sed at accumsan metus. <br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.<br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.',
		),
		array(
			'id' => 78,
			'Description' => 'Planning 0 for Project 4',
			'Projects' => 8,
			'Priority' => 15,
			'Status' => 9,
			'Type' => 8,
			'ObjectOwner' => 71,
			'PlannedDeadline' => 1325541600,
			'PlannedEffort' => 8,
			'ActualDeadline' => 1329948000,
			'ActualEffort' => 8,
			'Notes' => 'Nulla facilisi. Sed lobortis, sem in tincidunt pharetra, nulla velit malesuada orci, at molestie turpis justo eu felis. Aenean turpis ante, eleifend eget tempor at, dictum vitae felis. Proin feugiat posuere libero et porta. Curabitur varius scelerisque turpis, ut aliquam metus ornare in.<br /><br />Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.<br /><br />Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.',
		),
		array(
			'id' => 79,
			'Description' => 'Development 1 for Project 4',
			'Projects' => 8,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 9,
			'ObjectOwner' => 77,
			'PlannedDeadline' => 1329170400,
			'PlannedEffort' => 2,
			'ActualDeadline' => 1332540000,
			'ActualEffort' => 2,
			'Notes' => 'Duis purus ipsum, consectetur quis scelerisque in, fringilla id nunc. In bibendum eros quis nulla tempus vitae iaculis ante euismod. Proin condimentum mi eu felis consequat sollicitudin consequat arcu luctus. Nullam eros mauris, vulputate imperdiet cursus ut, porttitor ut risus. Vestibulum nec est non justo blandit mollis. Phasellus condimentum nulla felis, nec gravida lacus. Curabitur urna nunc, consequat vel pharetra nec, rhoncus eu nisl. Donec tincidunt sollicitudin libero, et fringilla urna feugiat in. In viverra elementum augue quis laoreet. Maecenas eget dui felis. Quisque rhoncus sodales bibendum.<br /><br />Duis purus ipsum, consectetur quis scelerisque in, fringilla id nunc. In bibendum eros quis nulla tempus vitae iaculis ante euismod. Proin condimentum mi eu felis consequat sollicitudin consequat arcu luctus. Nullam eros mauris, vulputate imperdiet cursus ut, porttitor ut risus. Vestibulum nec est non justo blandit mollis. Phasellus condimentum nulla felis, nec gravida lacus. Curabitur urna nunc, consequat vel pharetra nec, rhoncus eu nisl. Donec tincidunt sollicitudin libero, et fringilla urna feugiat in. In viverra elementum augue quis laoreet. Maecenas eget dui felis. Quisque rhoncus sodales bibendum.<br /><br />Duis purus ipsum, consectetur quis scelerisque in, fringilla id nunc. In bibendum eros quis nulla tempus vitae iaculis ante euismod. Proin condimentum mi eu felis consequat sollicitudin consequat arcu luctus. Nullam eros mauris, vulputate imperdiet cursus ut, porttitor ut risus. Vestibulum nec est non justo blandit mollis. Phasellus condimentum nulla felis, nec gravida lacus. Curabitur urna nunc, consequat vel pharetra nec, rhoncus eu nisl. Donec tincidunt sollicitudin libero, et fringilla urna feugiat in. In viverra elementum augue quis laoreet. Maecenas eget dui felis. Quisque rhoncus sodales bibendum.',
		),
		array(
			'id' => 40,
			'Description' => 'Development 4 for Project 1',
			'Projects' => 5,
			'Priority' => 14,
			'Status' => 10,
			'Type' => 9,
			'ObjectOwner' => 71,
			'PlannedDeadline' => 1336168800,
			'PlannedEffort' => 21,
			'ActualDeadline' => 1340056800,
			'ActualEffort' => 16,
			'Notes' => 'Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
		),
		array(
			'id' => 36,
			'Description' => 'Finalizing 0 for Project 1',
			'Projects' => 5,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 10,
			'ObjectOwner' => 72,
			'PlannedDeadline' => 1327010400,
			'PlannedEffort' => 29,
			'ActualDeadline' => 1328047200,
			'ActualEffort' => 29,
			'Notes' => 'Nunc molestie hendrerit arcu, non dapibus nulla suscipit ac. Nam eget nulla sit amet ante mollis pharetra. Fusce tincidunt diam vitae libero venenatis posuere. Nullam luctus rhoncus turpis in lacinia. Vestibulum pellentesque, erat id pretium consequat, est mauris interdum dolor, sit amet elementum urna neque ac neque. Nam dapibus lacinia est, nec rhoncus magna convallis id. Sed at accumsan metus. <br /><br />Nunc molestie hendrerit arcu, non dapibus nulla suscipit ac. Nam eget nulla sit amet ante mollis pharetra. Fusce tincidunt diam vitae libero venenatis posuere. Nullam luctus rhoncus turpis in lacinia. Vestibulum pellentesque, erat id pretium consequat, est mauris interdum dolor, sit amet elementum urna neque ac neque. Nam dapibus lacinia est, nec rhoncus magna convallis id. Sed at accumsan metus. <br /><br />Nunc molestie hendrerit arcu, non dapibus nulla suscipit ac. Nam eget nulla sit amet ante mollis pharetra. Fusce tincidunt diam vitae libero venenatis posuere. Nullam luctus rhoncus turpis in lacinia. Vestibulum pellentesque, erat id pretium consequat, est mauris interdum dolor, sit amet elementum urna neque ac neque. Nam dapibus lacinia est, nec rhoncus magna convallis id. Sed at accumsan metus.',
		),
		array(
			'id' => 41,
			'Description' => 'Finalizing 5 for Project 1',
			'Projects' => 5,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 10,
			'ObjectOwner' => 72,
			'PlannedDeadline' => 1338501600,
			'PlannedEffort' => 31,
			'ActualDeadline' => 1341266400,
			'ActualEffort' => 31,
			'Notes' => 'Nulla facilisi. Sed lobortis, sem in tincidunt pharetra, nulla velit malesuada orci, at molestie turpis justo eu felis. Aenean turpis ante, eleifend eget tempor at, dictum vitae felis. Proin feugiat posuere libero et porta. Curabitur varius scelerisque turpis, ut aliquam metus ornare in.<br /><br />Nulla facilisi. Sed lobortis, sem in tincidunt pharetra, nulla velit malesuada orci, at molestie turpis justo eu felis. Aenean turpis ante, eleifend eget tempor at, dictum vitae felis. Proin feugiat posuere libero et porta. Curabitur varius scelerisque turpis, ut aliquam metus ornare in.<br /><br />Nulla facilisi. Sed lobortis, sem in tincidunt pharetra, nulla velit malesuada orci, at molestie turpis justo eu felis. Aenean turpis ante, eleifend eget tempor at, dictum vitae felis. Proin feugiat posuere libero et porta. Curabitur varius scelerisque turpis, ut aliquam metus ornare in.',
		),
		array(
			'id' => 37,
			'Description' => 'Development 1 for Project 1',
			'Projects' => 5,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 9,
			'ObjectOwner' => 71,
			'PlannedDeadline' => 1329948000,
			'PlannedEffort' => 25,
			'ActualDeadline' => 1332626400,
			'ActualEffort' => 25,
			'Notes' => 'Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.<br /><br />Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.<br /><br />Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.',
		),
		array(
			'id' => 42,
			'Description' => 'Development 6 for Project 1',
			'Projects' => 5,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 9,
			'ObjectOwner' => 75,
			'PlannedDeadline' => 1342908000,
			'PlannedEffort' => 4,
			'ActualDeadline' => 1343944800,
			'ActualEffort' => 4,
			'Notes' => 'Morbi quis magna urna, id viverra ipsum. Fusce nibh orci, interdum id pharetra ut, ultricies vel metus. Donec eget justo augue, vel semper tellus. Morbi venenatis turpis eget eros imperdiet fringilla. Donec eu tincidunt felis. Sed nec nunc id nibh vestibulum tempor eu ac lectus. Maecenas eu tincidunt turpis. Nunc mollis laoreet quam hendrerit dictum. Nulla blandit neque quis magna rutrum tincidunt. Etiam turpis ante, cursus a sagittis non, vehicula in odio. Nullam sed velit odio.<br /><br />Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.<br /><br />Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.',
		),
		array(
			'id' => 43,
			'Description' => 'Development 7 for Project 1',
			'Projects' => 5,
			'Priority' => 13,
			'Status' => 9,
			'Type' => 9,
			'ObjectOwner' => 76,
			'PlannedDeadline' => 1346104800,
			'PlannedEffort' => 9,
			'ActualDeadline' => 1347141600,
			'ActualEffort' => 6,
			'Notes' => 'Maecenas eget lectus ut odio mattis fringilla. Nunc sem leo, interdum id euismod sit amet, varius vel lorem. Nam quis augue a lectus ultrices suscipit a facilisis lacus. Morbi at nisl sit amet nunc porttitor posuere id id risus. Vestibulum eget enim ornare augue venenatis placerat sed vitae mi. Nam elit justo, tincidunt id venenatis et, ullamcorper non tellus. Phasellus quis lorem tortor. <br /><br />Maecenas eget lectus ut odio mattis fringilla. Nunc sem leo, interdum id euismod sit amet, varius vel lorem. Nam quis augue a lectus ultrices suscipit a facilisis lacus. Morbi at nisl sit amet nunc porttitor posuere id id risus. Vestibulum eget enim ornare augue venenatis placerat sed vitae mi. Nam elit justo, tincidunt id venenatis et, ullamcorper non tellus. Phasellus quis lorem tortor. <br /><br />Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna.',
		),
		array(
			'id' => 38,
			'Description' => 'Development 2 for Project 1',
			'Projects' => 5,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 9,
			'ObjectOwner' => 71,
			'PlannedDeadline' => 1331416800,
			'PlannedEffort' => 25,
			'ActualDeadline' => 1335391200,
			'ActualEffort' => 16,
			'Notes' => 'Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.<br /><br />Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.<br /><br />Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.',
		),
		array(
			'id' => 44,
			'Description' => 'Finalizing 8 for Project 1',
			'Projects' => 5,
			'Priority' => 12,
			'Status' => 11,
			'Type' => 10,
			'ObjectOwner' => 75,
			'PlannedDeadline' => 1348610400,
			'PlannedEffort' => 30,
			'ActualDeadline' => 1349128800,
			'ActualEffort' => 30,
			'Notes' => 'Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam. <br /><br />Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam. <br /><br />Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam.',
		),
		array(
			'id' => 39,
			'Description' => 'Planning 3 for Project 1',
			'Projects' => 5,
			'Priority' => 13,
			'Status' => 10,
			'Type' => 8,
			'ObjectOwner' => 70,
			'PlannedDeadline' => 1333836000,
			'PlannedEffort' => 16,
			'ActualDeadline' => 1336687200,
			'ActualEffort' => 16,
			'Notes' => 'Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.<br /><br />Nullam a neque dolor. Pellentesque elementum, magna quis interdum volutpat, libero ipsum scelerisque turpis, porta pretium dolor lectus ac risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam quam est, malesuada vitae accumsan ut, dapibus condimentum ligula. Integer eget feugiat velit. Duis ut tortor quis enim convallis consectetur ut posuere metus.<br /><br />Nullam a neque dolor. Pellentesque elementum, magna quis interdum volutpat, libero ipsum scelerisque turpis, porta pretium dolor lectus ac risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam quam est, malesuada vitae accumsan ut, dapibus condimentum ligula. Integer eget feugiat velit. Duis ut tortor quis enim convallis consectetur ut posuere metus.',
		),
		array(
			'id' => 45,
			'Description' => 'Planning 9 for Project 1',
			'Projects' => 5,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 8,
			'ObjectOwner' => 71,
			'PlannedDeadline' => 1349128800,
			'PlannedEffort' => 1,
			'ActualDeadline' => 1352066400,
			'ActualEffort' => 1,
			'Notes' => 'Duis purus ipsum, consectetur quis scelerisque in, fringilla id nunc. In bibendum eros quis nulla tempus vitae iaculis ante euismod. Proin condimentum mi eu felis consequat sollicitudin consequat arcu luctus. Nullam eros mauris, vulputate imperdiet cursus ut, porttitor ut risus. Vestibulum nec est non justo blandit mollis. Phasellus condimentum nulla felis, nec gravida lacus. Curabitur urna nunc, consequat vel pharetra nec, rhoncus eu nisl. Donec tincidunt sollicitudin libero, et fringilla urna feugiat in. In viverra elementum augue quis laoreet. Maecenas eget dui felis. Quisque rhoncus sodales bibendum.<br /><br />Duis purus ipsum, consectetur quis scelerisque in, fringilla id nunc. In bibendum eros quis nulla tempus vitae iaculis ante euismod. Proin condimentum mi eu felis consequat sollicitudin consequat arcu luctus. Nullam eros mauris, vulputate imperdiet cursus ut, porttitor ut risus. Vestibulum nec est non justo blandit mollis. Phasellus condimentum nulla felis, nec gravida lacus. Curabitur urna nunc, consequat vel pharetra nec, rhoncus eu nisl. Donec tincidunt sollicitudin libero, et fringilla urna feugiat in. In viverra elementum augue quis laoreet. Maecenas eget dui felis. Quisque rhoncus sodales bibendum.<br /><br />Nam est nunc, rhoncus non tincidunt vitae, ultricies quis nunc. Nulla eu ipsum nec nunc fringilla sagittis.',
		),
		array(
			'id' => 50,
			'Description' => 'Planning 14 for Project 1',
			'Projects' => 5,
			'Priority' => 12,
			'Status' => 11,
			'Type' => 8,
			'ObjectOwner' => 71,
			'PlannedDeadline' => 1363903200,
			'PlannedEffort' => 28,
			'ActualDeadline' => 1365026400,
			'ActualEffort' => 28,
			'Notes' => 'Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
		),
		array(
			'id' => 46,
			'Description' => 'Finalizing 10 for Project 1',
			'Projects' => 5,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 10,
			'ObjectOwner' => 76,
			'PlannedDeadline' => 1353189600,
			'PlannedEffort' => 2,
			'ActualDeadline' => 1354485600,
			'ActualEffort' => 2,
			'Notes' => 'Quisque nec est ut velit commodo interdum. Sed vel metus nec elit sagittis tempus. <br /><br />Praesent vel quam nunc. Aliquam cursus blandit semper.<br /><br />Praesent vel quam nunc. Aliquam cursus blandit semper.',
		),
		array(
			'id' => 51,
			'Description' => 'Finalizing 0 for Project 2',
			'Projects' => 6,
			'Priority' => 14,
			'Status' => 10,
			'Type' => 10,
			'ObjectOwner' => 66,
			'PlannedDeadline' => 1327269600,
			'PlannedEffort' => 4,
			'ActualDeadline' => 1329516000,
			'ActualEffort' => 4,
			'Notes' => 'Nulla dui ipsum, bibendum vel ultricies eu, dapibus sit amet eros. Nam augue lectus, dapibus rutrum mattis bibendum, porttitor quis orci. Cras est nulla, dictum quis auctor ut, bibendum vitae diam. Nulla dui tortor, pulvinar id lacinia a, condimentum ut ipsum. Mauris sagittis, arcu eu auctor egestas, purus justo posuere quam, ac porttitor ante tellus eget lorem. In hac habitasse platea dictumst. <br /><br />Nulla dui ipsum, bibendum vel ultricies eu, dapibus sit amet eros. Nam augue lectus, dapibus rutrum mattis bibendum, porttitor quis orci. Cras est nulla, dictum quis auctor ut, bibendum vitae diam. Nulla dui tortor, pulvinar id lacinia a, condimentum ut ipsum. Mauris sagittis, arcu eu auctor egestas, purus justo posuere quam, ac porttitor ante tellus eget lorem. In hac habitasse platea dictumst. <br /><br />Nulla dui ipsum, bibendum vel ultricies eu, dapibus sit amet eros. Nam augue lectus, dapibus rutrum mattis bibendum, porttitor quis orci. Cras est nulla, dictum quis auctor ut, bibendum vitae diam. Nulla dui tortor, pulvinar id lacinia a, condimentum ut ipsum. Mauris sagittis, arcu eu auctor egestas, purus justo posuere quam, ac porttitor ante tellus eget lorem. In hac habitasse platea dictumst.',
		),
		array(
			'id' => 47,
			'Description' => 'Planning 11 for Project 1',
			'Projects' => 5,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 8,
			'ObjectOwner' => 72,
			'PlannedDeadline' => 1355522400,
			'PlannedEffort' => 19,
			'ActualDeadline' => 1359151200,
			'ActualEffort' => 19,
			'Notes' => 'Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.<br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.<br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.',
		),
		array(
			'id' => 52,
			'Description' => 'Development 1 for Project 2',
			'Projects' => 6,
			'Priority' => 13,
			'Status' => 10,
			'Type' => 9,
			'ObjectOwner' => 71,
			'PlannedDeadline' => 1328652000,
			'PlannedEffort' => 11,
			'ActualDeadline' => 1331416800,
			'ActualEffort' => 15,
			'Notes' => 'Aenean in arcu arcu. Curabitur non fringilla augue. Quisque euismod augue ac massa accumsan ornare. Aliquam egestas egestas ligula nec vestibulum. Phasellus a neque at justo porttitor placerat. Phasellus at nisl sapien. Nam laoreet lacus ut ligula convallis quis sollicitudin sem convallis. Vestibulum vel magna lectus. Nam fringilla convallis eros, sed hendrerit dolor fringilla id. <br /><br />Aenean in arcu arcu. Curabitur non fringilla augue. Quisque euismod augue ac massa accumsan ornare. Aliquam egestas egestas ligula nec vestibulum. Phasellus a neque at justo porttitor placerat. Phasellus at nisl sapien. Nam laoreet lacus ut ligula convallis quis sollicitudin sem convallis. Vestibulum vel magna lectus. Nam fringilla convallis eros, sed hendrerit dolor fringilla id. <br /><br />Aliquam euismod tincidunt velit, in lobortis velit aliquam id. Morbi risus eros, fringilla et blandit at, semper sit amet magna. Duis auctor convallis ultricies. Fusce pharetra leo sed libero porttitor condimentum. Nulla tempus ligula et nulla cursus in ornare dui tempor. Integer tincidunt laoreet lectus vitae sodales.',
		),
		array(
			'id' => 53,
			'Description' => 'Development 2 for Project 2',
			'Projects' => 6,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 9,
			'ObjectOwner' => 65,
			'PlannedDeadline' => 1331503200,
			'PlannedEffort' => 24,
			'ActualDeadline' => 1334008800,
			'ActualEffort' => 24,
			'Notes' => 'Vestibulum lorem enim, accumsan ac volutpat eu, tristique id leo. Sed ornare augue massa. Nam sed libero sed diam volutpat gravida. Sed ac massa nisi. Etiam dapibus libero non sapien iaculis ac elementum ipsum convallis. Curabitur sodales ultricies erat a iaculis. Suspendisse sit amet nibh vitae dolor varius malesuada. Mauris consequat, dolor ac auctor faucibus, tortor purus euismod ipsum, vel accumsan magna dolor vel nisl. Aenean elementum eleifend sapien vel dignissim.<br /><br />Vestibulum lorem enim, accumsan ac volutpat eu, tristique id leo. Sed ornare augue massa. Nam sed libero sed diam volutpat gravida. Sed ac massa nisi. Etiam dapibus libero non sapien iaculis ac elementum ipsum convallis. Curabitur sodales ultricies erat a iaculis. Suspendisse sit amet nibh vitae dolor varius malesuada. Mauris consequat, dolor ac auctor faucibus, tortor purus euismod ipsum, vel accumsan magna dolor vel nisl. Aenean elementum eleifend sapien vel dignissim.<br /><br />Vestibulum lorem enim, accumsan ac volutpat eu, tristique id leo. Sed ornare augue massa. Nam sed libero sed diam volutpat gravida. Sed ac massa nisi. Etiam dapibus libero non sapien iaculis ac elementum ipsum convallis. Curabitur sodales ultricies erat a iaculis. Suspendisse sit amet nibh vitae dolor varius malesuada. Mauris consequat, dolor ac auctor faucibus, tortor purus euismod ipsum, vel accumsan magna dolor vel nisl. Aenean elementum eleifend sapien vel dignissim.',
		),
		array(
			'id' => 48,
			'Description' => 'Planning 12 for Project 1',
			'Projects' => 5,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 8,
			'ObjectOwner' => 68,
			'PlannedDeadline' => 1357336800,
			'PlannedEffort' => 3,
			'ActualDeadline' => 1359669600,
			'ActualEffort' => 3,
			'Notes' => 'Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
		),
		array(
			'id' => 54,
			'Description' => 'Development 3 for Project 2',
			'Projects' => 6,
			'Priority' => 15,
			'Status' => 10,
			'Type' => 9,
			'ObjectOwner' => 75,
			'PlannedDeadline' => 1334700000,
			'PlannedEffort' => 13,
			'ActualDeadline' => 1337637600,
			'ActualEffort' => 4,
			'Notes' => 'Morbi quis magna urna, id viverra ipsum. Fusce nibh orci, interdum id pharetra ut, ultricies vel metus. Donec eget justo augue, vel semper tellus. Morbi venenatis turpis eget eros imperdiet fringilla. Donec eu tincidunt felis. Sed nec nunc id nibh vestibulum tempor eu ac lectus. Maecenas eu tincidunt turpis. Nunc mollis laoreet quam hendrerit dictum. Nulla blandit neque quis magna rutrum tincidunt. Etiam turpis ante, cursus a sagittis non, vehicula in odio. Nullam sed velit odio.<br /><br />Morbi quis magna urna, id viverra ipsum. Fusce nibh orci, interdum id pharetra ut, ultricies vel metus. Donec eget justo augue, vel semper tellus. Morbi venenatis turpis eget eros imperdiet fringilla. Donec eu tincidunt felis. Sed nec nunc id nibh vestibulum tempor eu ac lectus. Maecenas eu tincidunt turpis. Nunc mollis laoreet quam hendrerit dictum. Nulla blandit neque quis magna rutrum tincidunt. Etiam turpis ante, cursus a sagittis non, vehicula in odio. Nullam sed velit odio.<br /><br />Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam.',
		),
		array(
			'id' => 49,
			'Description' => 'Planning 13 for Project 1',
			'Projects' => 5,
			'Priority' => 13,
			'Status' => 10,
			'Type' => 8,
			'ObjectOwner' => 69,
			'PlannedDeadline' => 1360101600,
			'PlannedEffort' => 11,
			'ActualDeadline' => 1363125600,
			'ActualEffort' => 11,
			'Notes' => 'Morbi pulvinar malesuada risus in tempor. Fusce eu sapien a sem aliquet pulvinar. Nullam elementum facilisis quam, sed sollicitudin tortor gravida et. Nam elit arcu, imperdiet eu rhoncus eget, molestie vitae augue. Sed posuere fermentum ultricies. Duis non odio in urna tempor elementum vitae consequat nibh. Suspendisse commodo, lacus eleifend tempus lacinia, enim odio consequat enim, eget posuere ipsum erat suscipit nisi. Ut mi justo, aliquet euismod luctus et, posuere quis enim. Aliquam sollicitudin nunc ut ante dictum sed convallis lectus feugiat.<br /><br />Morbi pulvinar malesuada risus in tempor. Fusce eu sapien a sem aliquet pulvinar. Nullam elementum facilisis quam, sed sollicitudin tortor gravida et. Nam elit arcu, imperdiet eu rhoncus eget, molestie vitae augue. Sed posuere fermentum ultricies. Duis non odio in urna tempor elementum vitae consequat nibh. Suspendisse commodo, lacus eleifend tempus lacinia, enim odio consequat enim, eget posuere ipsum erat suscipit nisi. Ut mi justo, aliquet euismod luctus et, posuere quis enim. Aliquam sollicitudin nunc ut ante dictum sed convallis lectus feugiat.<br /><br />Morbi pulvinar malesuada risus in tempor. Fusce eu sapien a sem aliquet pulvinar. Nullam elementum facilisis quam, sed sollicitudin tortor gravida et. Nam elit arcu, imperdiet eu rhoncus eget, molestie vitae augue. Sed posuere fermentum ultricies. Duis non odio in urna tempor elementum vitae consequat nibh. Suspendisse commodo, lacus eleifend tempus lacinia, enim odio consequat enim, eget posuere ipsum erat suscipit nisi. Ut mi justo, aliquet euismod luctus et, posuere quis enim. Aliquam sollicitudin nunc ut ante dictum sed convallis lectus feugiat.',
		),
		array(
			'id' => 55,
			'Description' => 'Development 4 for Project 2',
			'Projects' => 6,
			'Priority' => 14,
			'Status' => 9,
			'Type' => 9,
			'ObjectOwner' => 72,
			'PlannedDeadline' => 1337464800,
			'PlannedEffort' => 5,
			'ActualDeadline' => 1340229600,
			'ActualEffort' => 5,
			'Notes' => 'Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.<br /><br />Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.<br /><br />Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.',
		),
		array(
			'id' => 60,
			'Description' => 'Development 9 for Project 2',
			'Projects' => 6,
			'Priority' => 13,
			'Status' => 10,
			'Type' => 9,
			'ObjectOwner' => 74,
			'PlannedDeadline' => 1350252000,
			'PlannedEffort' => 2,
			'ActualDeadline' => 1352757600,
			'ActualEffort' => 2,
			'Notes' => 'Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur.',
		),
		array(
			'id' => 56,
			'Description' => 'Planning 5 for Project 2',
			'Projects' => 6,
			'Priority' => 14,
			'Status' => 10,
			'Type' => 8,
			'ObjectOwner' => 76,
			'PlannedDeadline' => 1340834400,
			'PlannedEffort' => 19,
			'ActualDeadline' => 1342130400,
			'ActualEffort' => 19,
			'Notes' => 'Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur.',
		),
		array(
			'id' => 61,
			'Description' => 'Development 10 for Project 2',
			'Projects' => 6,
			'Priority' => 13,
			'Status' => 10,
			'Type' => 9,
			'ObjectOwner' => 67,
			'PlannedDeadline' => 1353621600,
			'PlannedEffort' => 15,
			'ActualDeadline' => 1354399200,
			'ActualEffort' => 20,
			'Notes' => 'Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci. <br /><br />Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci. <br /><br />Morbi quis magna urna, id viverra ipsum. Fusce nibh orci, interdum id pharetra ut, ultricies vel metus. Donec eget justo augue, vel semper tellus. Morbi venenatis turpis eget eros imperdiet fringilla. Donec eu tincidunt felis. Sed nec nunc id nibh vestibulum tempor eu ac lectus. Maecenas eu tincidunt turpis. Nunc mollis laoreet quam hendrerit dictum. Nulla blandit neque quis magna rutrum tincidunt. Etiam turpis ante, cursus a sagittis non, vehicula in odio. Nullam sed velit odio.',
		),
		array(
			'id' => 57,
			'Description' => 'Planning 6 for Project 2',
			'Projects' => 6,
			'Priority' => 13,
			'Status' => 9,
			'Type' => 8,
			'ObjectOwner' => 72,
			'PlannedDeadline' => 1343167200,
			'PlannedEffort' => 9,
			'ActualDeadline' => 1345672800,
			'ActualEffort' => 9,
			'Notes' => 'Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
		),
		array(
			'id' => 62,
			'Description' => 'Finalizing 11 for Project 2',
			'Projects' => 6,
			'Priority' => 14,
			'Status' => 9,
			'Type' => 10,
			'ObjectOwner' => 67,
			'PlannedDeadline' => 1356386400,
			'PlannedEffort' => 8,
			'ActualDeadline' => 1358287200,
			'ActualEffort' => 11,
			'Notes' => 'Morbi pulvinar malesuada risus in tempor. Fusce eu sapien a sem aliquet pulvinar. Nullam elementum facilisis quam, sed sollicitudin tortor gravida et. Nam elit arcu, imperdiet eu rhoncus eget, molestie vitae augue. Sed posuere fermentum ultricies. Duis non odio in urna tempor elementum vitae consequat nibh. Suspendisse commodo, lacus eleifend tempus lacinia, enim odio consequat enim, eget posuere ipsum erat suscipit nisi. Ut mi justo, aliquet euismod luctus et, posuere quis enim. Aliquam sollicitudin nunc ut ante dictum sed convallis lectus feugiat.<br /><br />Morbi pulvinar malesuada risus in tempor. Fusce eu sapien a sem aliquet pulvinar. Nullam elementum facilisis quam, sed sollicitudin tortor gravida et. Nam elit arcu, imperdiet eu rhoncus eget, molestie vitae augue. Sed posuere fermentum ultricies. Duis non odio in urna tempor elementum vitae consequat nibh. Suspendisse commodo, lacus eleifend tempus lacinia, enim odio consequat enim, eget posuere ipsum erat suscipit nisi. Ut mi justo, aliquet euismod luctus et, posuere quis enim. Aliquam sollicitudin nunc ut ante dictum sed convallis lectus feugiat.<br /><br />Maecenas eget lectus ut odio mattis fringilla. Nunc sem leo, interdum id euismod sit amet, varius vel lorem. Nam quis augue a lectus ultrices suscipit a facilisis lacus. Morbi at nisl sit amet nunc porttitor posuere id id risus. Vestibulum eget enim ornare augue venenatis placerat sed vitae mi. Nam elit justo, tincidunt id venenatis et, ullamcorper non tellus. Phasellus quis lorem tortor.',
		),
		array(
			'id' => 58,
			'Description' => 'Finalizing 7 for Project 2',
			'Projects' => 6,
			'Priority' => 13,
			'Status' => 9,
			'Type' => 10,
			'ObjectOwner' => 77,
			'PlannedDeadline' => 1344722400,
			'PlannedEffort' => 9,
			'ActualDeadline' => 1346882400,
			'ActualEffort' => 9,
			'Notes' => 'Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur.',
		),
		array(
			'id' => 63,
			'Description' => 'Planning 0 for Project 3',
			'Projects' => 7,
			'Priority' => 14,
			'Status' => 9,
			'Type' => 8,
			'ObjectOwner' => 76,
			'PlannedDeadline' => 1326146400,
			'PlannedEffort' => 10,
			'ActualDeadline' => 1329429600,
			'ActualEffort' => 10,
			'Notes' => 'Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna. <br /><br />Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna. <br /><br />Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna.',
		),
		array(
			'id' => 59,
			'Description' => 'Finalizing 8 for Project 2',
			'Projects' => 6,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 10,
			'ObjectOwner' => 70,
			'PlannedDeadline' => 1347055200,
			'PlannedEffort' => 6,
			'ActualDeadline' => 1349388000,
			'ActualEffort' => 21,
			'Notes' => 'Aliquam eu nisi vel lorem ultricies laoreet. Nulla eget mi ac leo porttitor luctus a nec purus. Phasellus in erat at nulla feugiat aliquam. Vivamus non eros quis tellus consectetur condimentum eget eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris commodo magna vitae libero blandit ultrices eu vulputate nisl. <br /><br />Aliquam eu nisi vel lorem ultricies laoreet. Nulla eget mi ac leo porttitor luctus a nec purus. Phasellus in erat at nulla feugiat aliquam. Vivamus non eros quis tellus consectetur condimentum eget eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris commodo magna vitae libero blandit ultrices eu vulputate nisl. <br /><br />Aliquam facilisis dolor id diam tempus sed vestibulum magna varius. Duis quis libero libero. Pellentesque elementum dictum lorem, ut sagittis orci adipiscing sed. Donec elementum nisl a odio consequat accumsan. Nam sagittis scelerisque purus in eleifend. Curabitur eget quam lorem, vitae tristique tortor. Vestibulum pretium ante sit amet velit pharetra at rhoncus lorem interdum.',
		),
		array(
			'id' => 64,
			'Description' => 'Development 1 for Project 3',
			'Projects' => 7,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 9,
			'ObjectOwner' => 77,
			'PlannedDeadline' => 1329602400,
			'PlannedEffort' => 6,
			'ActualDeadline' => 1331071200,
			'ActualEffort' => 6,
			'Notes' => 'Maecenas eget lectus ut odio mattis fringilla. Nunc sem leo, interdum id euismod sit amet, varius vel lorem. Nam quis augue a lectus ultrices suscipit a facilisis lacus. Morbi at nisl sit amet nunc porttitor posuere id id risus. Vestibulum eget enim ornare augue venenatis placerat sed vitae mi. Nam elit justo, tincidunt id venenatis et, ullamcorper non tellus. Phasellus quis lorem tortor. <br /><br />Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien. <br /><br />Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien.',
		),
		array(
			'id' => 70,
			'Description' => 'Finalizing 7 for Project 3',
			'Projects' => 7,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 10,
			'ObjectOwner' => 67,
			'PlannedDeadline' => 1345068000,
			'ActualDeadline' => 1346450400,
			'ActualEffort' => 17,
			'Notes' => 'Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Maecenas eget lectus ut odio mattis fringilla. Nunc sem leo, interdum id euismod sit amet, varius vel lorem. Nam quis augue a lectus ultrices suscipit a facilisis lacus. Morbi at nisl sit amet nunc porttitor posuere id id risus. Vestibulum eget enim ornare augue venenatis placerat sed vitae mi. Nam elit justo, tincidunt id venenatis et, ullamcorper non tellus. Phasellus quis lorem tortor.',
		),
		array(
			'id' => 65,
			'Description' => 'Development 2 for Project 3',
			'Projects' => 7,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 9,
			'ObjectOwner' => 74,
			'PlannedDeadline' => 1330552800,
			'PlannedEffort' => 26,
			'ActualDeadline' => 1335304800,
			'ActualEffort' => 26,
			'Notes' => 'Praesent vel quam nunc. Aliquam cursus blandit semper.<br /><br />Quisque tincidunt magna id magna scelerisque tempor. <br /><br />Quisque tincidunt magna id magna scelerisque tempor.',
		),
		array(
			'id' => 71,
			'Description' => 'Development 8 for Project 3',
			'Projects' => 7,
			'Priority' => 13,
			'Status' => 10,
			'Type' => 9,
			'ObjectOwner' => 72,
			'PlannedDeadline' => 1348264800,
			'PlannedEffort' => 15,
			'ActualDeadline' => 1349992800,
			'ActualEffort' => 15,
			'Notes' => 'Aenean in arcu arcu. Curabitur non fringilla augue. Quisque euismod augue ac massa accumsan ornare. Aliquam egestas egestas ligula nec vestibulum. Phasellus a neque at justo porttitor placerat. Phasellus at nisl sapien. Nam laoreet lacus ut ligula convallis quis sollicitudin sem convallis. Vestibulum vel magna lectus. Nam fringilla convallis eros, sed hendrerit dolor fringilla id. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum. <br /><br />Donec euismod tincidunt enim sed cursus. Curabitur quis lacus massa, eu congue erat. Curabitur ullamcorper volutpat lacus, quis dapibus nunc placerat non. Donec vel nunc at sem euismod volutpat ac sit amet justo. Etiam scelerisque vulputate quam. Donec mi sapien, fringilla mollis commodo ut, posuere faucibus nisi. Donec in felis a arcu ultricies rutrum. Praesent sollicitudin tempus augue, nec ultrices velit mattis ac. Mauris at nibh sed lectus dignissim condimentum.',
		),
		array(
			'id' => 66,
			'Description' => 'Development 3 for Project 3',
			'Projects' => 7,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 9,
			'ObjectOwner' => 68,
			'PlannedDeadline' => 1334095200,
			'PlannedEffort' => 29,
			'ActualDeadline' => 1336082400,
			'ActualEffort' => 22,
			'Notes' => 'Fusce massa odio, aliquam ac ullamcorper congue, rutrum sed felis. In nunc purus, volutpat vitae pharetra non, mattis vel quam. Mauris sit amet sem sit amet mauris dignissim scelerisque. Nullam ac orci nisl. Donec convallis quam eget sapien pretium in tempor quam commodo. Ut consectetur tellus vitae lorem tempus id tristique ipsum tempus. Donec eget justo magna, at commodo augue. Phasellus venenatis nisl lectus. Praesent accumsan iaculis massa et pretium. Fusce fringilla, lectus nec aliquet bibendum, felis augue aliquam libero, a vestibulum magna mauris at magna. Fusce nunc arcu, pellentesque quis facilisis sit amet, tempor sit amet tellus. In hac habitasse platea dictumst.<br /><br />Fusce massa odio, aliquam ac ullamcorper congue, rutrum sed felis. In nunc purus, volutpat vitae pharetra non, mattis vel quam. Mauris sit amet sem sit amet mauris dignissim scelerisque. Nullam ac orci nisl. Donec convallis quam eget sapien pretium in tempor quam commodo. Ut consectetur tellus vitae lorem tempus id tristique ipsum tempus. Donec eget justo magna, at commodo augue. Phasellus venenatis nisl lectus. Praesent accumsan iaculis massa et pretium. Fusce fringilla, lectus nec aliquet bibendum, felis augue aliquam libero, a vestibulum magna mauris at magna. Fusce nunc arcu, pellentesque quis facilisis sit amet, tempor sit amet tellus. In hac habitasse platea dictumst.<br /><br />Fusce massa odio, aliquam ac ullamcorper congue, rutrum sed felis. In nunc purus, volutpat vitae pharetra non, mattis vel quam. Mauris sit amet sem sit amet mauris dignissim scelerisque. Nullam ac orci nisl. Donec convallis quam eget sapien pretium in tempor quam commodo. Ut consectetur tellus vitae lorem tempus id tristique ipsum tempus. Donec eget justo magna, at commodo augue. Phasellus venenatis nisl lectus. Praesent accumsan iaculis massa et pretium. Fusce fringilla, lectus nec aliquet bibendum, felis augue aliquam libero, a vestibulum magna mauris at magna. Fusce nunc arcu, pellentesque quis facilisis sit amet, tempor sit amet tellus. In hac habitasse platea dictumst.',
		),
		array(
			'id' => 72,
			'Description' => 'Planning 9 for Project 3',
			'Projects' => 7,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 8,
			'ObjectOwner' => 72,
			'PlannedDeadline' => 1349992800,
			'PlannedEffort' => 31,
			'ActualDeadline' => 1351893600,
			'ActualEffort' => 31,
			'Notes' => 'Nunc molestie hendrerit arcu, non dapibus nulla suscipit ac. Nam eget nulla sit amet ante mollis pharetra. Fusce tincidunt diam vitae libero venenatis posuere. Nullam luctus rhoncus turpis in lacinia. Vestibulum pellentesque, erat id pretium consequat, est mauris interdum dolor, sit amet elementum urna neque ac neque. Nam dapibus lacinia est, nec rhoncus magna convallis id. Sed at accumsan metus. <br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.<br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.',
		),
		array(
			'id' => 67,
			'Description' => 'Planning 4 for Project 3',
			'Projects' => 7,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 8,
			'ObjectOwner' => 69,
			'PlannedDeadline' => 1337810400,
			'PlannedEffort' => 4,
			'ActualDeadline' => 1340316000,
			'ActualEffort' => 17,
			'Notes' => 'Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.<br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.<br /><br />Etiam neque nunc, fermentum sit amet fermentum ut, ultrices vitae neque. Maecenas nibh enim, dictum a semper et, sagittis viverra purus. Nunc ullamcorper, orci et facilisis congue, velit diam luctus mauris, dapibus iaculis lorem sapien eu lacus. Aliquam eget turpis odio. Ut felis nunc, sodales ultricies egestas ac, euismod et urna.',
		),
		array(
			'id' => 68,
			'Description' => 'Development 5 for Project 3',
			'Projects' => 7,
			'Priority' => 15,
			'Status' => 11,
			'Type' => 9,
			'ObjectOwner' => 65,
			'PlannedDeadline' => 1340316000,
			'PlannedEffort' => 27,
			'ActualDeadline' => 1343080800,
			'ActualEffort' => 22,
			'Notes' => 'Fusce massa odio, aliquam ac ullamcorper congue, rutrum sed felis. In nunc purus, volutpat vitae pharetra non, mattis vel quam. Mauris sit amet sem sit amet mauris dignissim scelerisque. Nullam ac orci nisl. Donec convallis quam eget sapien pretium in tempor quam commodo. Ut consectetur tellus vitae lorem tempus id tristique ipsum tempus. Donec eget justo magna, at commodo augue. Phasellus venenatis nisl lectus. Praesent accumsan iaculis massa et pretium. Fusce fringilla, lectus nec aliquet bibendum, felis augue aliquam libero, a vestibulum magna mauris at magna. Fusce nunc arcu, pellentesque quis facilisis sit amet, tempor sit amet tellus. In hac habitasse platea dictumst.<br /><br />Fusce massa odio, aliquam ac ullamcorper congue, rutrum sed felis. In nunc purus, volutpat vitae pharetra non, mattis vel quam. Mauris sit amet sem sit amet mauris dignissim scelerisque. Nullam ac orci nisl. Donec convallis quam eget sapien pretium in tempor quam commodo. Ut consectetur tellus vitae lorem tempus id tristique ipsum tempus. Donec eget justo magna, at commodo augue. Phasellus venenatis nisl lectus. Praesent accumsan iaculis massa et pretium. Fusce fringilla, lectus nec aliquet bibendum, felis augue aliquam libero, a vestibulum magna mauris at magna. Fusce nunc arcu, pellentesque quis facilisis sit amet, tempor sit amet tellus. In hac habitasse platea dictumst.<br /><br />Nullam a neque dolor. Pellentesque elementum, magna quis interdum volutpat, libero ipsum scelerisque turpis, porta pretium dolor lectus ac risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam quam est, malesuada vitae accumsan ut, dapibus condimentum ligula. Integer eget feugiat velit. Duis ut tortor quis enim convallis consectetur ut posuere metus.',
		),
		array(
			'id' => 73,
			'Description' => 'Planning 10 for Project 3',
			'Projects' => 7,
			'Priority' => 12,
			'Status' => 9,
			'Type' => 8,
			'ObjectOwner' => 71,
			'PlannedDeadline' => 1352930400,
			'PlannedEffort' => 9,
			'ActualDeadline' => 1354572000,
			'ActualEffort' => 9,
			'Notes' => 'Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Quisque tincidunt magna id magna scelerisque tempor. <br /><br />Quisque tincidunt magna id magna scelerisque tempor.',
		),
		array(
			'id' => 69,
			'Description' => 'Finalizing 6 for Project 3',
			'Projects' => 7,
			'Priority' => 13,
			'Status' => 9,
			'Type' => 10,
			'ObjectOwner' => 76,
			'PlannedDeadline' => 1342908000,
			'PlannedEffort' => 8,
			'ActualDeadline' => 1344117600,
			'ActualEffort' => 8,
			'Notes' => 'Suspendisse potenti. <br /><br />Suspendisse potenti. <br /><br />Suspendisse potenti.',
		),
		array(
			'id' => 74,
			'Description' => 'Planning 11 for Project 3',
			'Projects' => 7,
			'Priority' => 13,
			'Status' => 10,
			'Type' => 8,
			'ObjectOwner' => 76,
			'PlannedDeadline' => 1355090400,
			'PlannedEffort' => 17,
			'ActualDeadline' => 1357682400,
			'ActualEffort' => 17,
			'Notes' => 'Praesent vel quam nunc. Aliquam cursus blandit semper.<br /><br />Praesent vel quam nunc. Aliquam cursus blandit semper.<br /><br />Praesent vel quam nunc. Aliquam cursus blandit semper.',
		),
		array(
			'id' => 75,
			'Description' => 'Finalizing 12 for Project 3',
			'Projects' => 7,
			'Priority' => 14,
			'Status' => 10,
			'Type' => 10,
			'ObjectOwner' => 74,
			'PlannedDeadline' => 1358373600,
			'PlannedEffort' => 19,
			'ActualDeadline' => 1360015200,
			'ActualEffort' => 19,
			'Notes' => 'Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.<br /><br />Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.<br /><br />Aliquam erat volutpat. Maecenas ultricies feugiat dui vitae pulvinar. Integer convallis ultrices tempor. Ut consequat nunc eget tellus ultrices sollicitudin. Phasellus mattis scelerisque vestibulum. Nulla facilisi. Pellentesque imperdiet vestibulum mauris, in condimentum arcu dignissim sed. Suspendisse potenti. Nulla pretium ultricies erat, vitae scelerisque tortor semper et.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_tasks');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 9,
			'Description' => 'Planned',
			'ListPosition' => 9,
			'Notes' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis. <br /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis tincidunt tortor, non bibendum risus lobortis ac. Fusce at eros sed dolor aliquam vestibulum. Mauris eget ante sapien. Donec eu justo ac purus consectetur faucibus. Nullam consectetur scelerisque massa et scelerisque. Ut a eros justo, et pellentesque felis. Duis at mi erat, nec dapibus nulla. Nam laoreet, eros et tempor convallis, arcu ante fermentum eros, sit amet luctus tellus lorem id nisi. Phasellus tempus, tortor et lacinia fringilla, magna metus dignissim dolor, vel vulputate purus massa non turpis.',
		),
		array(
			'id' => 11,
			'Description' => 'Finished',
			'ListPosition' => 11,
			'Notes' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc varius ipsum a orci semper a lobortis mi fermentum. <br /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc varius ipsum a orci semper a lobortis mi fermentum.',
		),
		array(
			'id' => 10,
			'Description' => 'Started',
			'ListPosition' => 10,
			'Notes' => 'Nulla dui ipsum, bibendum vel ultricies eu, dapibus sit amet eros. Nam augue lectus, dapibus rutrum mattis bibendum, porttitor quis orci. Cras est nulla, dictum quis auctor ut, bibendum vitae diam. Nulla dui tortor, pulvinar id lacinia a, condimentum ut ipsum. Mauris sagittis, arcu eu auctor egestas, purus justo posuere quam, ac porttitor ante tellus eget lorem. In hac habitasse platea dictumst. <br /><br />Nam viverra vehicula purus, vel ultricies orci faucibus a. Integer venenatis fermentum justo, quis ultrices turpis fermentum vel. Suspendisse potenti. Fusce posuere, risus eu lobortis pretium, neque velit fermentum ante, non volutpat urna mauris in diam. Vestibulum convallis consequat nibh id pellentesque. Donec ultrices, velit ut vehicula facilisis, metus est pellentesque ante, ac mattis turpis urna quis nisi. In dolor lacus, tincidunt vel dictum sed, semper vel eros. Aliquam ornare pretium vestibulum.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_projectstatuses');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 1,
			'Description' => 'Client',
			'Notes' => 'Suspendisse potenti. <br /><br />Aliquam facilisis dolor id diam tempus sed vestibulum magna varius. Duis quis libero libero. Pellentesque elementum dictum lorem, ut sagittis orci adipiscing sed. Donec elementum nisl a odio consequat accumsan. Nam sagittis scelerisque purus in eleifend. Curabitur eget quam lorem, vitae tristique tortor. Vestibulum pretium ante sit amet velit pharetra at rhoncus lorem interdum.',
		),
		array(
			'id' => 2,
			'Description' => 'PM',
			'Notes' => 'Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci. <br /><br />Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur.',
		),
		array(
			'id' => 3,
			'Description' => 'Vendor',
			'Notes' => 'Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur. <br /><br />Cras lectus ipsum, lobortis ut iaculis sed, porta id lectus. Sed nec justo sed urna venenatis consectetur.',
		),
		array(
			'id' => 4,
			'Description' => 'Employee',
			'Notes' => 'Aliquam facilisis dolor id diam tempus sed vestibulum magna varius. Duis quis libero libero. Pellentesque elementum dictum lorem, ut sagittis orci adipiscing sed. Donec elementum nisl a odio consequat accumsan. Nam sagittis scelerisque purus in eleifend. Curabitur eget quam lorem, vitae tristique tortor. Vestibulum pretium ante sit amet velit pharetra at rhoncus lorem interdum. <br /><br />Maecenas egestas consectetur nisl quis convallis. Maecenas nisi sapien, molestie ac rutrum et, vehicula sed orci.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_usertypes');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array('Projects' => 6, 'Contacts' => 69),
		array('Projects' => 8, 'Contacts' => 73),
		array('Projects' => 6, 'Contacts' => 66),
		array('Projects' => 7, 'Contacts' => 65),
		array('Projects' => 5, 'Contacts' => 71),
		array('Projects' => 5, 'Contacts' => 66),
		array('Projects' => 5, 'Contacts' => 77),
		array('Projects' => 5, 'Contacts' => 65),
		array('Projects' => 8, 'Contacts' => 74),
		array('Projects' => 5, 'Contacts' => 75),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_projects_mailinglists');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 9,
			'Description' => 'High',
			'ListPosition' => 9,
			'Notes' => 'Quisque nec est ut velit commodo interdum. Sed vel metus nec elit sagittis tempus. <br /><br />Quisque nec est ut velit commodo interdum. Sed vel metus nec elit sagittis tempus.',
		),
		array(
			'id' => 11,
			'Description' => 'Low',
			'ListPosition' => 11,
			'Notes' => 'Nullam quis eros quis enim vehicula aliquet. Nulla pharetra condimentum libero ac tristique. Duis elit lorem, faucibus vitae porttitor in, fermentum eget eros. Sed accumsan cursus elit, eget iaculis est dapibus et. Fusce nulla turpis, sodales ac lobortis in, commodo at neque. Ut semper placerat ipsum, venenatis bibendum tellus volutpat in. Etiam ut est diam, ac adipiscing quam. <br /><br />Cras massa libero, laoreet non semper id, vulputate nec neque. Mauris a ultrices sem. Donec euismod, justo a tempus mollis, leo felis mollis arcu, ut pulvinar odio sem a risus. Aliquam condimentum, leo et sagittis tristique, urna libero dignissim odio, ut luctus ipsum elit vel turpis. Fusce in tempor nunc. Ut ultricies consequat enim, a condimentum enim tincidunt eu. Morbi ac ligula id leo laoreet ullamcorper eu et magna.',
		),
		array(
			'id' => 10,
			'Description' => 'Medium',
			'ListPosition' => 10,
			'Notes' => 'Phasellus in metus in magna vestibulum ultricies. In nec metus mauris, vitae semper justo. Suspendisse posuere leo vel velit pellentesque ornare eget vitae libero. Sed feugiat augue nec metus pulvinar eget porttitor nunc sollicitudin. Proin mattis, dolor vitae vehicula sagittis, justo tellus adipiscing leo, quis sagittis risus eros vel quam. Morbi id nisl purus. Nulla porta leo elit.<br /><br />Phasellus in metus in magna vestibulum ultricies. In nec metus mauris, vitae semper justo. Suspendisse posuere leo vel velit pellentesque ornare eget vitae libero. Sed feugiat augue nec metus pulvinar eget porttitor nunc sollicitudin. Proin mattis, dolor vitae vehicula sagittis, justo tellus adipiscing leo, quis sagittis risus eros vel quam. Morbi id nisl purus. Nulla porta leo elit.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_riskprobabilities');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 12,
			'Description' => 'Very High',
			'ListPosition' => 12,
			'Notes' => 'Duis purus ipsum, consectetur quis scelerisque in, fringilla id nunc. In bibendum eros quis nulla tempus vitae iaculis ante euismod. Proin condimentum mi eu felis consequat sollicitudin consequat arcu luctus. Nullam eros mauris, vulputate imperdiet cursus ut, porttitor ut risus. Vestibulum nec est non justo blandit mollis. Phasellus condimentum nulla felis, nec gravida lacus. Curabitur urna nunc, consequat vel pharetra nec, rhoncus eu nisl. Donec tincidunt sollicitudin libero, et fringilla urna feugiat in. In viverra elementum augue quis laoreet. Maecenas eget dui felis. Quisque rhoncus sodales bibendum.<br /><br />Nulla tincidunt justo nec diam molestie feugiat. Aenean et est non sapien ultrices posuere id a odio.',
		),
		array(
			'id' => 13,
			'Description' => 'High',
			'ListPosition' => 13,
			'Notes' => 'Aenean in arcu arcu. Curabitur non fringilla augue. Quisque euismod augue ac massa accumsan ornare. Aliquam egestas egestas ligula nec vestibulum. Phasellus a neque at justo porttitor placerat. Phasellus at nisl sapien. Nam laoreet lacus ut ligula convallis quis sollicitudin sem convallis. Vestibulum vel magna lectus. Nam fringilla convallis eros, sed hendrerit dolor fringilla id. <br /><br />Aenean in arcu arcu. Curabitur non fringilla augue. Quisque euismod augue ac massa accumsan ornare. Aliquam egestas egestas ligula nec vestibulum. Phasellus a neque at justo porttitor placerat. Phasellus at nisl sapien. Nam laoreet lacus ut ligula convallis quis sollicitudin sem convallis. Vestibulum vel magna lectus. Nam fringilla convallis eros, sed hendrerit dolor fringilla id.',
		),
		array(
			'id' => 14,
			'Description' => 'Medium',
			'ListPosition' => 14,
			'Notes' => 'Duis purus ipsum, consectetur quis scelerisque in, fringilla id nunc. In bibendum eros quis nulla tempus vitae iaculis ante euismod. Proin condimentum mi eu felis consequat sollicitudin consequat arcu luctus. Nullam eros mauris, vulputate imperdiet cursus ut, porttitor ut risus. Vestibulum nec est non justo blandit mollis. Phasellus condimentum nulla felis, nec gravida lacus. Curabitur urna nunc, consequat vel pharetra nec, rhoncus eu nisl. Donec tincidunt sollicitudin libero, et fringilla urna feugiat in. In viverra elementum augue quis laoreet. Maecenas eget dui felis. Quisque rhoncus sodales bibendum.<br /><br />Aliquam erat volutpat. Maecenas ultricies feugiat dui vitae pulvinar. Integer convallis ultrices tempor. Ut consequat nunc eget tellus ultrices sollicitudin. Phasellus mattis scelerisque vestibulum. Nulla facilisi. Pellentesque imperdiet vestibulum mauris, in condimentum arcu dignissim sed. Suspendisse potenti. Nulla pretium ultricies erat, vitae scelerisque tortor semper et.',
		),
		array(
			'id' => 15,
			'Description' => 'Low',
			'ListPosition' => 15,
			'Notes' => 'Praesent ut facilisis odio. Maecenas congue neque ut nisi placerat vitae suscipit mauris fermentum. Praesent non sem tincidunt odio placerat tincidunt. Nulla gravida lectus sed urna mollis lacinia. Ut egestas viverra volutpat. Vestibulum quis nunc erat. Donec faucibus magna at quam condimentum convallis lobortis ante aliquet. Mauris tempor, ipsum a sollicitudin molestie, orci dui laoreet nulla, non accumsan erat libero a nisl. Quisque id luctus enim. Pellentesque id purus odio. Sed cursus pharetra enim eget tempor.<br /><br />Praesent ut facilisis odio. Maecenas congue neque ut nisi placerat vitae suscipit mauris fermentum. Praesent non sem tincidunt odio placerat tincidunt. Nulla gravida lectus sed urna mollis lacinia. Ut egestas viverra volutpat. Vestibulum quis nunc erat. Donec faucibus magna at quam condimentum convallis lobortis ante aliquet. Mauris tempor, ipsum a sollicitudin molestie, orci dui laoreet nulla, non accumsan erat libero a nisl. Quisque id luctus enim. Pellentesque id purus odio. Sed cursus pharetra enim eget tempor.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_priorities');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 6,
			'Description' => 'Custom value 3',
			'Notes' => 'Aliquam eu nisi vel lorem ultricies laoreet. Nulla eget mi ac leo porttitor luctus a nec purus. Phasellus in erat at nulla feugiat aliquam. Vivamus non eros quis tellus consectetur condimentum eget eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris commodo magna vitae libero blandit ultrices eu vulputate nisl. <br /><br />Aliquam eu nisi vel lorem ultricies laoreet. Nulla eget mi ac leo porttitor luctus a nec purus. Phasellus in erat at nulla feugiat aliquam. Vivamus non eros quis tellus consectetur condimentum eget eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris commodo magna vitae libero blandit ultrices eu vulputate nisl.',
		),
		array(
			'id' => 4,
			'Description' => 'Custom value 1',
			'Notes' => 'Maecenas eget lectus ut odio mattis fringilla. Nunc sem leo, interdum id euismod sit amet, varius vel lorem. Nam quis augue a lectus ultrices suscipit a facilisis lacus. Morbi at nisl sit amet nunc porttitor posuere id id risus. Vestibulum eget enim ornare augue venenatis placerat sed vitae mi. Nam elit justo, tincidunt id venenatis et, ullamcorper non tellus. Phasellus quis lorem tortor. <br /><br />Ut auctor ultrices elementum. Donec quis velit quam, ac mattis turpis. Praesent venenatis auctor sagittis. Duis feugiat, diam sit amet aliquet tempus, mi libero sodales mi, vitae eleifend velit risus vel sapien.',
		),
		array(
			'id' => 5,
			'Description' => 'Custom value 2',
			'Notes' => 'Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.<br /><br />Praesent egestas pretium nisl vulputate blandit. Suspendisse sit amet commodo mauris. Duis vel pellentesque massa. Morbi dignissim accumsan viverra. Duis et velit quam, at viverra tortor. Maecenas lacinia euismod sollicitudin. Morbi nisl mi, vehicula ac molestie vitae, cursus sed sem. Vivamus at nulla eget arcu hendrerit consequat. Mauris vulputate volutpat felis eu elementum. Ut tristique congue metus et rhoncus. Suspendisse nec pellentesque urna. Nulla laoreet sem sit amet dui pretium nec mattis nibh pretium. Mauris sagittis ornare risus, in aliquet elit pretium a. Vestibulum nisi nulla, porttitor at tempus ac, dapibus in lorem.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_projectfield1');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}


	$rows = array(
		array(
			'id' => 11,
			'Description' => 'Mitigate',
			'Notes' => 'In ut tristique erat. Vestibulum sodales mollis metus a lacinia. Quisque non nibh turpis. Phasellus posuere elit vitae nunc tristique volutpat. Fusce eu diam ligula, sit amet egestas ante.<br /><br />In ut tristique erat. Vestibulum sodales mollis metus a lacinia. Quisque non nibh turpis. Phasellus posuere elit vitae nunc tristique volutpat. Fusce eu diam ligula, sit amet egestas ante.',
		),
		array(
			'id' => 12,
			'Description' => 'Transfer',
			'Notes' => 'Morbi pulvinar malesuada risus in tempor. Fusce eu sapien a sem aliquet pulvinar. Nullam elementum facilisis quam, sed sollicitudin tortor gravida et. Nam elit arcu, imperdiet eu rhoncus eget, molestie vitae augue. Sed posuere fermentum ultricies. Duis non odio in urna tempor elementum vitae consequat nibh. Suspendisse commodo, lacus eleifend tempus lacinia, enim odio consequat enim, eget posuere ipsum erat suscipit nisi. Ut mi justo, aliquet euismod luctus et, posuere quis enim. Aliquam sollicitudin nunc ut ante dictum sed convallis lectus feugiat.<br /><br />Morbi pulvinar malesuada risus in tempor. Fusce eu sapien a sem aliquet pulvinar. Nullam elementum facilisis quam, sed sollicitudin tortor gravida et. Nam elit arcu, imperdiet eu rhoncus eget, molestie vitae augue. Sed posuere fermentum ultricies. Duis non odio in urna tempor elementum vitae consequat nibh. Suspendisse commodo, lacus eleifend tempus lacinia, enim odio consequat enim, eget posuere ipsum erat suscipit nisi. Ut mi justo, aliquet euismod luctus et, posuere quis enim. Aliquam sollicitudin nunc ut ante dictum sed convallis lectus feugiat.',
		),
		array(
			'id' => 13,
			'Description' => 'Accept',
			'Notes' => 'Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.<br /><br />Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.',
		),
		array(
			'id' => 14,
			'Description' => 'Monitor',
			'Notes' => 'Nulla facilisi. Sed lobortis, sem in tincidunt pharetra, nulla velit malesuada orci, at molestie turpis justo eu felis. Aenean turpis ante, eleifend eget tempor at, dictum vitae felis. Proin feugiat posuere libero et porta. Curabitur varius scelerisque turpis, ut aliquam metus ornare in.<br /><br />Donec est nisi, ornare id pretium non, ullamcorper nec massa. Vivamus commodo tristique ornare. Nullam vestibulum vulputate vestibulum.',
		),
	);

	$table_name = iProjectWebDB::wptn('#wp__iprojectweb_riskstrategies');
	foreach ($rows as $row) {
		$wpdb->insert($table_name, $row);
	}
}

function iprojectweb_uninstall() {

	global $wpdb;
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_applicationsettings;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_files;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_priorities;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_projectfield1;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_projectfield2;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_projectfiles;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_projectroles;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_projects;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_projects_mailinglists;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_projects_teams;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_projectstatuses;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_riskimpacts;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_riskprobabilities;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_risks;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_risks_mailinglists;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_riskstatuses;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_riskstrategies;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_risktypes;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_roles;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_taskfiles;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_tasks;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_tasks_mailinglists;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_taskstatuses;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_tasktypes;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_userfield1;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_userfield2;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_users;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_usertypes;";
	$sqls[] = "DROP TABLE IF EXISTS #wp__iprojectweb_acl;";

	require_once dirName(__FILE__) . DIRECTORY_SEPARATOR . 'iprojectweb_database.php';
	foreach ($sqls as $sql){
		$sql = iProjectWebDB::wptn($sql);
		$wpdb->query($sql);
	}
}
