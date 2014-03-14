<?php
	////////////////////////////////////////////////////////////////////////
	////////////// CONFIGURATION SECTION STARTS BELOW //////////////////////
	////////////////////////////////////////////////////////////////////////

	// Texting information.
	$text = array(
		"LOGO" => "images/logo.png",
		"TITLE" => "Medication Request Form",
		"BACK" => "Back",
		"SUBMIT" => "Submit",
		"FIRSTNAME" => "First Name",
		"LASTNAME" => "Last Name",
		"CELLPHONE" => "Cell Phone Number",
		"PHONE" => "Phone Number",
		"EMAIL" => "Email Address",
		"PATIENT" => "Patient Name",
		"MEDICATION" => "Please list all medication and/or food refill requests",
		"SPECIAL" => "Special requests",		
	);
	
	// List of required fields, possible values are: firstname, lastname, cellnumber, phonenumber, emailaddress, patientname, medfoodname, specialrequests.
	$requiredFields = array(
		"firstname",
		"lastname", 
		"cellnumber",
	);
	
	// Mailing info.
	$email = array(
		"TOEMAIL" => "mshields@in-touchmobile.com,bill@mowbi.com", // Email to send to.
		"SUBJECT" => "Medication Form Submission", // Subject of email.
		"FROMADDRESS" => "no-reply@you.com", // From address.
	);
	
	// Success info.
	$success = array(
		"REDIRECT" => "http://google.com", // Redirect address.
		"WAIT" => 4, // Number of seconds to wait before redirecting.
		"MSG" => "Thank you!  Your form has been submitted, you will be redirected shortly", // Display message after form submission.
	);

	////////////////////////////////////////////////////////////////////////
	////////////// CONFIGURATION SECTION END HERE //////////////////////////
	////////////////////////////////////////////////////////////////////////
		
	// You don't have to edit below this line.
	$readyToSubmit = true;
	foreach ($requiredFields as $requiredField) {
		if (!isset($_POST[$requiredField]) || $_POST[$requiredField] == "") {
			$readyToSubmit = false;
			break;
		}
	}

	if ($readyToSubmit) {
		$emailbody = '
			First name = ' . @$_POST["firstname"] . ' 
			Last name = ' . @$_POST["lastname"] . ' 
			Email address = ' . @$_POST["emailaddress"] . ' 
			Phone number = ' . @$_POST["phonenumber"] . '
			Cell number = ' . @$_POST["cellnumber"] . ' 
			Patient name : ' . @$_POST["patientname"] . '
			Med & Food List = ' . @$_POST["medfoodname"] . ' 
			Special Requests = ' . @$_POST["specialrequests"];
		
		$headers = "From: {$email['FROMADDRESS']}\r\nReply-To: {$email['FROMADDRESS']}\r\n";
		mail($email['TOEMAIL'], $email['SUBJECT'], $emailbody, $headers);
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $text['TITLE']; ?></title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
  </head>
  <body>  	
	<header class="row-fluid">
		<div class="col-lg-12">
			<h3 id="title"><?php echo $text['TITLE']; ?></h3>
		</div>
		<div class="clearfix"></div>
	</header>

	<section class="row-fluid">
        <div class="col-lg-12" id="logo">
            <img src="<?php echo $text['LOGO']; ?>" />
        </div>
    </section>

<?php 
	if ($readyToSubmit) {
?>
	<div class="container">
		<div class="alert alert-info">
			<?php echo $success['MSG']; ?>
		</div>
	</div>
	<script type="text/javascript">
	function redirect() {
		location.href = '<?php echo $success['REDIRECT']; ?>';
	}
	setTimeout(redirect, <?php echo $success['WAIT']; ?> * 1000);
	</script>
<?php
	} 
	else {
?>		
	<div class="container">		
		<form role="form" method="post" action="">
			<button class="btn btn-sm btn-default btn-block btn-back" type="button" onclick="history.go(-1)"><?php echo $text['BACK']; ?></button>
			<div class="row">
				<div class="col-md-6">
					<input type="text" name="firstname" class="form-control" placeholder="<?php echo $text['FIRSTNAME']; ?>" <?php echo (in_array("firstname",$requiredFields)?'required':''); ?>/>
				</div>
				<div class="col-md-6">
					<input type="text" name="lastname" class="form-control" placeholder="<?php echo $text['LASTNAME']; ?>" <?php echo (in_array("lastname",$requiredFields)?'required':''); ?>/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<input type="tel" name="cellnumber" class="form-control" placeholder="<?php echo $text['CELLPHONE']; ?>" <?php echo (in_array("cellnumber",$requiredFields)?'required':''); ?>/>
				</div>
				<div class="col-md-6">
					<input type="tel" name="phonenumber" class="form-control" placeholder="<?php echo $text['PHONE']; ?>" <?php echo (in_array("phonenumber",$requiredFields)?'required':''); ?>/>
				</div>
			</div>
			<input type="email" name="emailaddress" class="form-control" placeholder="<?php echo $text['EMAIL']; ?>" <?php echo (in_array("emailaddress",$requiredFields)?'required':''); ?>/>
			<input type="text" name="patientname" class="form-control" placeholder="<?php echo $text['PATIENT']; ?>" <?php echo (in_array("patientname",$requiredFields)?'required':''); ?>/>
			<textarea name="medfoodname" placeholder="<?php echo $text['MEDICATION']; ?>" class="form-control" <?php echo (in_array("medfoodname",$requiredFields)?'required':''); ?>></textarea>
			<textarea name="specialrequests" placeholder="<?php echo $text['SPECIAL']; ?>" class="form-control" <?php echo (in_array("specialrequests",$requiredFields)?'required':''); ?>></textarea>
			<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $text['SUBMIT']; ?></button>
		</form>

	</div> <!-- /container -->
<?php } ?>
  </body>
</html>
