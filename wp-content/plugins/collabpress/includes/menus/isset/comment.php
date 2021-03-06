<?php

// Add Comment
if ( isset( $_POST['cp-add-comment'] ) && isset($_POST['cp-comment-content']) ) :

	check_admin_referer('cp-add-comment');

	global $cp_task;
	global $current_user;
	get_currentuserinfo();

	$time = current_time('mysql');

	$data = array(
	    'comment_post_ID' => $cp_task->id,
	    'comment_author' => $current_user->display_name,
	    'comment_author_email' => $current_user->user_email,
	    'comment_author_url' => $current_user->user_email,
	    'comment_content' => nl2br(esc_html($_POST['cp-comment-content'])),
	    'comment_type' => 'collabpress',
	    'comment_parent' => 0,
	    'user_id' => $current_user->ID,
	    'comment_author_IP' => preg_replace( '/[^0-9a-fA-F:., ]/', '',$_SERVER['REMOTE_ADDR'] ),
	    'comment_agent' => substr($_SERVER['HTTP_USER_AGENT'], 0, 254),
	    'comment_date' => $time,
	    'comment_approved' => 1,
	);

	wp_insert_comment($data);
	
	//check if email notification is checked
	if( isset( $_POST['notify'] ) ) {
	    //send email

	    //get user assigned to the task
	    $task_author_id = get_post_meta( $cp_task->id, '_cp-task-assign', true );
	    $task_author_data = get_userdata( $task_author_id );
	    $author_email = $task_author_data->user_email;

	    $subject = __('New comment on task ', 'collabpress') .get_the_title( $cp_task->id );
	    
	    $message = __("There is a new comment on your task from ", "collabpress") .$current_user->display_name. ": " .get_the_title( $cp_task->id ) ."\n\n";
	    $message .= __("Comment:", "collabpress") . "\n";
	    $message .= esc_html( $_POST['cp-comment-content'] );

	    cp_send_email( $author_email, $subject, $message );

	}

	// Add Activity
	cp_add_activity(__('added', 'collabpress'), __('comment', 'collabpress'), $current_user->ID, $cp_task->id);

endif;

// Delete Project
if ( isset( $_GET['cp-delete-comment-id'] ) ) :

    check_admin_referer( 'cp-action-delete_comment' );

    //verify user has permission to delete comments
    if ( cp_check_permissions( 'settings_user_role' ) ) {

		$cp_comment_id = absint( $_GET['cp-delete-comment-id'] );

		wp_delete_comment($cp_comment_id);
		
		//add activity log
		cp_add_activity(__('deleted', 'collabpress'), __('comment', 'collabpress'), $current_user->ID, $cp_task->id );

    }

endif;