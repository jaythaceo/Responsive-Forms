<?php
	////////////////////////////////////////////////////////////////////////
	////////////// CONFIGURATION SECTION STARTS BELOW //////////////////////
	////////////////////////////////////////////////////////////////////////

	// Texting information.
	$text = array(
		"LOGO" => "images/logo.png",
		"TITLE" => "Request a Grooming Appointment",
		"BACK" => "Back",
		"SUBMIT" => "Submit",
		"FIRSTNAME" => "First Name",
		"LASTNAME" => "Last Name",
		"CELLPHONE" => "Cell Phone Number",
		"PHONE" => "Phone Number",
		"EMAIL" => "Email Address",
		"COMMENTS" => "Please let us know the reason for your appointment and any special requests",
		"FIRSTDATETIME" => "Request Date & Time",
		"SECONDDATETIME" => "Alternative Date & Time - if above time is not available",
		"NEWCLIENT" => "New client",
		"EXISTINGCLIENT" => "Already a client",
		"PATIENTNAME" => "Patient Name",
		"CAT" => "Cat",
		"DOG" => "Dog",
		"SPECIES" => "Species: ",
		"OTHERSPECIES" => "Breed (please write in)",
		"CLINICTELEPHONE" => "(374) 94236979",
		"INFOLINE1" => "Please Note: For same day appointment requests, please call: ",
		"INFOLINE2" => "- While we will try to accommodate your request, all appointment days and times are subject to availability.",
		"INFOLINE3" => "- This is a request and you must receive confirmation from the clinic before the appointment is confirmed.",
		"TOPINFOLINE1" => "Please use the form below to request a specific day and time for your pet's grooming appointment.",
		"TOPINFOLINE2" => "Please Note: For same day appointment requests, please call: ",
	);
	
	// List of required fields, possible values are: firstname, lastname, cellnumber, phonenumber, emailaddress, patientname, otherspecies, comments, firstdatetime, seconddatetime.
	$requiredFields = array(
		"firstname",
		"lastname", 
		"cellnumber",
		"emailaddress"
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
		"MSG" => "Thank you!  Your form has been submitted, you will be redirected shortly", // Display message after form submission
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
			First date and time: ' . @$_POST["firstdatetime"] . ' 
			Second date and time: ' . @$_POST["seconddatetime"] . ' 
			First name : ' . @$_POST["firstname"] . ' 
			Last name : ' . @$_POST["lastname"] . ' 
			Email address : ' . @$_POST["emailaddress"] . ' 
			Phone number : ' . @$_POST["phonenumber"] . ' 
			Cell number : ' . @$_POST["cellnumber"] . ' 
			New or existing : ' . @$_POST["neworexisting"] . '
			Patient name : ' . @$_POST["patientname"] . '
			Cat : ' . ((@$_POST["cat"] == 'on')?"Yes":"No") . '
			Dog : ' . ((@$_POST["dog"] == 'on')?"Yes":"No") . '
			Other species specified : ' . @$_POST["otherspecies"] . '
			Comments : ' . @$_POST["comments"];
			
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
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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
				<div class="col-md-12">
					<div class="alert alert-info">
						<?php echo $text['TOPINFOLINE1']; ?><br/>
						<?php echo $text['TOPINFOLINE2']; ?><?php echo $text['CLINICTELEPHONE']; ?><br/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="input-group date form_datetime" data-date-format="dd MM yyyy - HH:ii p" data-link-field="firstdatetime">
						<input type="text" name="firstdatetime" class="form-control" placeholder="<?php echo $text['FIRSTDATETIME']; ?>" <?php echo (in_array("firstdatetime",$requiredFields)?'required':''); ?> readonly/>
						<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group date form_datetime" data-date-format="dd MM yyyy - HH:ii p" data-link-field="seconddatetime">
						<input type="text" name="seconddatetime" class="form-control" placeholder="<?php echo $text['SECONDDATETIME']; ?>" <?php echo (in_array("seconddatetime",$requiredFields)?'required':''); ?> readonly/>
						<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					</div>
				</div>
			</div>
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
			<center>
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-primary active">
						<input type="radio" name="neworexisting" id="existing" value="existing" checked> <?php echo $text['EXISTINGCLIENT']; ?>
					</label>
					<label class="btn btn-primary">
						<input type="radio" name="neworexisting" id="new" value="new"> <?php echo $text['NEWCLIENT']; ?>
					</label>
				</div>
			</center>
			<input type="text" name="patientname" class="form-control" placeholder="<?php echo $text['PATIENTNAME']; ?>" <?php echo (in_array("patientname",$requiredFields)?'required':''); ?>/>
			<center>
				<label><?php echo $text['SPECIES']; ?></label>
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-primary">
						<input type="checkbox" name="cat" id="cat" value="on"> <?php echo $text['CAT']; ?>
					</label>
					<label class="btn btn-primary">
						<input type="checkbox" name="dog" id="dog" value="on"> <?php echo $text['DOG']; ?>
					</label>
				</div>
			</center>
			<input type="text" name="otherspecies" class="form-control" placeholder="<?php echo $text['OTHERSPECIES']; ?>" <?php echo (in_array("otherspecies",$requiredFields)?'required':''); ?>/>
			<textarea name="comments" placeholder="<?php echo $text['COMMENTS']; ?>" class="form-control" <?php echo (in_array("comments",$requiredFields)?'required':''); ?>></textarea>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-info">
						<?php echo $text['INFOLINE1']; ?><?php echo $text['CLINICTELEPHONE']; ?><br/>
						<?php echo $text['INFOLINE2']; ?><br/>
						<?php echo $text['INFOLINE3']; ?>
					</div>
				</div>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $text['SUBMIT']; ?></button>
		</form>

		<script type="text/javascript">
			$(function () {
				$('.form_datetime').datetimepicker({
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					forceParse: 0,
					showMeridian: 1,
					pickerPosition: 'bottom-left'
				});
            });
        </script>

	</div> <!-- /container -->
<?php } ?>
  </body>
</html>
