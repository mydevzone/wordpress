<?php
function addcontact($post){
global $wpdb;
$sql1 ="select count(*) as counttotal from  ".$wpdb->prefix."contact_me 
       where email = '".$post['email']."'";	
$result = $wpdb->get_results($sql1);
if($result[0]->counttotal==0){
$sql ="insert into ".$wpdb->prefix."contact_me 
       (name,email,comment) values('".$post['contactName']."','".$post['email']."','".$post['comments']."')";	

$wpdb->query($sql);
}
}

?>



<h1>Contact us</h1>
<p>Hello Welcome to contact us page</p>
<?php
if(isset($_POST['submitted'])) {
	if(trim($_POST['contactName']) === '') {
		$nameError = 'Please enter your name.';
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = 'Please enter your email address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['comments']) === '') {
		$commentError = 'Please enter a message.';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}

	if(!isset($hasError)) {
		$emailTo = "sumit.grover1@gmail.com"; //get_option('tz_email');
		
		if (!isset($emailTo) || ($emailTo == '') ){
			$emailTo = get_option('admin_email');
		}
		$subject = '[PHP Snippets] From '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
	
		//echo "mail error on localhost";	
		wp_mail($emailTo, $subject, $body, $headers);
		addcontact($_POST);
		$emailSent = true;
	}

} ?>

<form action="<?php the_permalink(); ?>" name="frmaction" id="frmaction" method="post">
<?php if(isset($emailSent) && $emailSent == true) { ?>
							<div class="thanks">
								<p>Thanks, your email was sent successfully.</p>
							</div>
						<?php } else { ?>
							<?php //the_content(); ?>
							<?php if(isset($hasError) || isset($captchaError)) { ?>
								<p class="error">Sorry, an error occured.<p>
							<?php } }?>
<div>
	<div>
		<div>Name : </div>
		<div><input type="text" name="contactName" value="" id="contactName"/></div>

	</div>
	<div>
		<div>Email : </div>
		<div><input type="text" name="email" value="" id="email"/></div>

	</div>
	
	
	<div>
		<div>Message : </div>
		<div><textarea name="comments"  id="comments"/></textarea></div>

	</div>
	<div>
		<div></div>
		<div style="float:right"><input type="submit" name="submitted" value="submitted" /></div>

	</div>

</div>


</form>
