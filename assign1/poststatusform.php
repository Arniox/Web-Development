<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<title>Post Status Form</title>
	</head>
	<body>
		<?php
			// classes
			$statusCodeClass='class="form-control"';
			$statusTextClass='class="form-control"';
			$sharingRadioButtonClass='class="custom-control-input"';
			$dateClass='class="form-control"';
			$permissionButtonClass='class="custom-control-input"';

			$notifcationClass='hidden';
			$notifcationSpacing = '';

			//Allow perm buttons
			$allPermsButNone = '';

			$mainHidden = '';
			$inputScreenHidden = 'hidden';
			$javaToRun = '';

			//form actions
			$mainFormAction='';

			// Are all fields fill
			if (isset($_POST['post'])) {
				//Check if each field is correct.
				//This means they both have to be not empty and also matching specific patterns
		        $isCodeCorrect = checkStatusCodeCorrect();
		        $isTextCorrect = checkStatusTextCorrect();
		        $isShareOptionCorrect = checkRadioButtonCorrect();
		        $isDateCorrect = checkDateCorrect();
		        $isPermissionsCorrect = checkPermissionsCorrect();

		        //Set the classes to is-valid or is-invalid based on if they're correct. This is for validation visual error for the user
		        $statusCodeClass = 'class="form-control '.($isCodeCorrect ? 'is-valid' : 'is-invalid').'" value="'.$_POST['statusCode'].'"';
		        $statusTextClass = 'class="form-control '.($isTextCorrect ? 'is-valid' : 'is-invalid').'" value="'.$_POST['statusText'].'"';
		        $sharingRadioButtonClass = 'class="custom-control-input '.($isShareOptionCorrect ? 'is-valid' : 'is-invalid').'"';
		        $dateClass = 'class="form-control '.($isDateCorrect ? 'is-valid': 'is-invalid').'" value="'.$_POST['date'].'"';
		        $permissionButtonClass = 'class="custom-control-input is-valid"';
		        if(!$isPermissionsCorrect){
		        	$isPermissionsCorrect=true;
		        }

		        //If all fields are correct then set the main form to hidden and show the final submission card which shows the user what he has selected
		        if($isCodeCorrect&&$isTextCorrect&&$isShareOptionCorrect&&$isDateCorrect&&$isPermissionsCorrect){
		        	$mainHidden = 'hidden';
		        	$inputScreenHidden = '';
		        	//Set the main form action to poststatusprocess.php
		        	//When the user clicks submit after he is happy that everything is ok, it will submit using this as an action
		        	$mainFormAction='action="poststatusprocess.php"';

		        	$javaToRun = '<script type="text/javascript">'.
		        				 	//'document.getElementById("formToSubmitOnJava").submit();'.
		        				 	'document.formToSubmitOnJava.submit();'.
		        				 '</script>';
		        }else{
		        	$notifcationClass = ' style="color: red;"';
		        	$notifcationSpacing = 'hidden';
		        }
			}

			//Check if status code is correct.
			//Status code must not be NULL and must match the pattern "/^S\d{4}$/" eg: S1344
		    function checkStatusCodeCorrect() {
		        if(!empty($_POST['statusCode'])){
		        	$str1 = $_POST['statusCode'];
					//Only S0001 style code
					$statusCodePattern = "/^S\d{4}$/";
		        	if(preg_match($statusCodePattern, $str1)){
		        		return true;
		        	}else return false;
		        }else return false;
		    }
		    //Check if status text is correct.
		    //Status text must not be NULL and must match the pattern: "/([a-z,!?'\.\s])/i" eg: Doing my assignement
		    function checkStatusTextCorrect() {
		    	if(!empty($_POST['statusText'])){
		    		$str2 = $_POST['statusText'];
					//Only a-z, A-Z, commas, explanation marks, question marks, apostraphese, and full stops. Case insensitive and global searching and any white space
					$statusTextPattern = "/([a-z,!?'\.\s])/i"; 
		    		if(preg_match($statusTextPattern, $str2)){
		    			return true;
		    		}else return false; 
		    	}else return false;
		    }
		    //Check if the radio buttons are correct.
		    //sharing option simply must not be NULL
		    function checkRadioButtonCorrect() {
		    	return !empty($_POST['shareOption']);
		    }
		    //Check if the date is correct
		    //Date must not be NULL and must match pattern: "/^((\d\d)+\-\d{2}\-\d{2})$/" eg: 2019-03-02 or 19-03-02
		    function checkDateCorrect() {
		    	if(!empty($_POST['date'])){
		    		$str3 = $_POST['date'];
					//Only 2 digits then forward slash, then 2 digits then forward slash and then only 2 or 4 digits for the year
					$datePattern = "/^((\d\d)+\-\d{2}\-\d{2})$/"; 
		    		if(preg_match($datePattern, $str3)){
		    			return true;
		    		}else return false;
		    	}else return false;
		    }
		    //Check if the checkboxes are correct
		    //Check boxes simply must not be NULL
		    function checkPermissionsCorrect(){
		    	if((!empty($_POST['allowLike']))||(!empty($_POST['allowComment']))||(!empty($_POST['allowShare']))||(!empty($_POST['allowNone']))){
		    		return true;
		    	}else return false;
		    }
		?>

		<!-- Navigation bar -->
		<div class="overlay-image">
			<img src="https://i.gyazo.com/2b3f17f140e933fd374b0597aa352921.jpg" class="img-fluid" alt="Responsive image">
		</div>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		 	<a class="navbar-brand" href="#">Navigation</a>
		 	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link" href="index.html">Home</a>
					<a class="nav-item nav-link active" href="#">Post a New Status<span class="sr-only">(current)</span></a>
					<a class="nav-item nav-link" href="searchstatusform.html">Search Status'</a>
					<a class="nav-item nav-link" href="about.html">About this Assignment</a>
		    	</div>
		  	</div>
		</nav><br><br>
		<!-- Page Content -->
		<div class="container-fluid px-lg-5">
			<form <?php echo $mainFormAction; ?> method="post" id="formToSubmitOnJava" name="formToSubmitOnJava">
				<!-- Status code group. This has the label and input -->
				<div class="form-group row" <?php echo $mainHidden; ?>>
					<label for="statusCodeInput" class="col-sm-2 col-form-label">Status Code (required):</label>
					<div class="col-sm-5">
						<input type="text" name="statusCode" <?php echo $statusCodeClass; ?> id="statusCodeInput" placeholder="eg: S0001">
					</div>
				</div>
				<!-- Status text group. This has the label and input-->
				<div class="form-group row" <?php echo $mainHidden; ?>>
					<label for="statusText" class="col-sm-2 col-form-label">Status (required):</label>
					<div class="col-sm-5">
						<input type="text" name="statusText" <?php echo $statusTextClass; ?> id="statusText" placeholder="eg: programming my first assignement">
					</div>
				</div>
				<!-- Sharing radio button fieldset. This has one share label and then 3 radio buttons
				each with their own label -->
				<fieldset class="form-group" <?php echo $mainHidden; ?>>
					<div class="row">
						<legend class="col-form-label col-sm-2">Share</legend>
						<div class="col-sm-8">
							<div class="custom-control custom-radio">
								<input type="radio" id="publicRadioShare" <?php echo $sharingRadioButtonClass; ?> name="shareOption" value="Public">
								<label class="custom-control-label" for="publicRadioShare">Public</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="friendsRadioShare" <?php echo $sharingRadioButtonClass; ?> name="shareOption" value="Friends">
								<label class="custom-control-label" for="friendsRadioShare">Friends</label>
							</div>
							<div class="custom-control custom-radio">
								<!-- Defualt checked radio button -->
								<input type="radio" id="onlyMeNotShare" <?php echo $sharingRadioButtonClass; ?> name="shareOption" value="Only me" checked> 
								<label class="custom-control-label" for="onlyMeNotShare">Only me</label>
							</div>
						</div>
					</div>
				</fieldset>
				<!-- Date text group. This has a label and date input type -->
				<div class="form-group row" <?php echo $mainHidden; ?>>
					<label for="dateInput" class="col-sm-2 col-form-label">Date:</label>
					<div class="col-sm-5">
						<input type="date" name="date" <?php echo $dateClass; ?> id="dateInput" value="<?php echo date('Y-m-d'); ?>" min="2019-01-01" max="2019-12-31">
					</div>
				</div>
				<!-- Permission type fieldset. This has one label and 3 checkboxes -->
				<fieldset class="form-group" <?php echo $mainHidden; ?>>
					<div class="row">
						<legend class="col-form-label col-sm-2">Permission Type</legend>
						<div class="col-sm-8">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" id="allowLike" <?php echo $permissionButtonClass.$allPermsButNone; ?> name="allowLike">
								<label class="custom-control-label" for="allowLike">Allow like</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" id="allowComment" <?php echo $permissionButtonClass.$allPermsButNone; ?> name="allowComment">
								<label class="custom-control-label" for="allowComment">Allow comment</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" id="allowShare" <?php echo $permissionButtonClass.$allPermsButNone; ?> name="allowShare">
								<label class="custom-control-label" for="allowShare">Allow Share</label>
							</div>
							<!-- This is a hidden button for no permissions. This is built to check if no other permission types are checked, it will then automatically check allow none -->
							<div hidden class="custom-control custom-checkbox">
								<input type="checkbox" id="allowNone" <?php echo $permissionButtonClass; ?> name="allowNone">
								<label class="custom-control-label" for="allowNone">No Permissions Allowed</label>
							</div>
						</div>
					</div>
				</fieldset>
				<div class="form-group row" <?php echo $mainHidden; ?>>
					<div <?php echo $notifcationClass; ?>>
						You have input your submission data incorrectly. Please try again!
					</div>
					<div <?php echo $notifcationSpacing; ?>>
						<!-- Spacing for the correct placement of the error text -->
						<br>
					</div>
				</div>
				<!-- Button Fields -->
				<div class="form-group row" <?php echo $mainHidden; ?>>
					<input type="submit" class="btn btn-primary" name="post" value="Post">&nbsp
					<input type="submit" class="btn btn-primary" name="reset" value="Reset">&nbsp
				</div>
				<!-- Hidden submission field -->
				<div class="text-center" <?php echo $inputScreenHidden; ?>>
				 	<div class="spinner-border" style="width: 10rem; height: 10rem;" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>
				<!-- Permanently hidden variables for submission into poststatusprocess.php 
					this hidden div and inputs are storage for all values of the form which get reset unless epcifically set when the post first happens with the post button-->
				<div class="form-group row" hidden>
					<div class="col-auto">
						<input type="text" name="statusCodeStorage" value="<?php echo $_POST['statusCode']; ?>">
						<input type="text" name="statusTextStorage" value="<?php echo $_POST['statusText']; ?>">
						<input type="text" name="shareOptionStorage" value="<?php echo $_POST['shareOption']; ?>">
						<input type="text" name="dateStorage" value="<?php echo $_POST['date']; ?>">

						<input type="text" name="allowLikeStorage" value="<?php echo (!isset($_POST['allowLike'])||isset($_POST['allowNone'])? 'off' : 'on'); ?>">
						<input type="text" name="allowCommentStorage" value="<?php echo (!isset($_POST['allowComment'])||isset($_POST['allowNone'])? 'off' : 'on'); ?>">
						<input type="text" name="allowShareStorage" value="<?php echo (!isset($_POST['allowShare'])||isset($_POST['allowNone'])? 'off' : 'on'); ?>">
						<input type="text" name="allowNoneStorage" value="<?php echo (isset($_POST['allowNone'])||(!isset($_POST['allowLike'])&&!isset($_POST['allowComment'])&&!isset($_POST['allowShare'])) ? 'on' : 'off'); ?>">
					</div>
				</div>

				<!-- Hidden Auto Submission -->
				<?php echo $javaToRun; ?>
			</form>
		</div>
	
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>