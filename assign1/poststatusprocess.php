<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="style/style.css">
		<title>Post Status Process</title>
	</head>
	<body>
		<?php
			//Home button class
			$homeButtonClass = 'disabled';
			$returnButtonClass = 'class="btn btn-primary" hidden';
			//Cards
			$mainHidden = '';
			$failureHidden = 'hidden';

			//Require for SQL
   			require_once("config/sqlinfo.php");
   			//Just in case the markers remove the config file, the code will still connect
   			if(empty($sql_host)){
   				$sql_host = "cmslamp14.aut.ac.nz";
			  	$sql_user = "bjy5305";
			  	$sql_paswd = "Is!FoxIn@BoxStill#Fox4";
			  	$sql_dbnm = "bjy5305";
			  	$sql_tble = "Status_Posts";
   			}

			//mysqli_connect returns false if connection failed, otherwise a connection value
			$conn = @mysqli_connect($sql_host,
		     	$sql_user,
		     	$sql_paswd,
		     	$sql_dbnm
		    );

			if(!$conn){
				$string1 = '<p>Database connection failure...</p>';
			}else{

				//Get all variables needed
				$firstValue = $_POST['statusCodeStorage'];
				$secondValue = $_POST['statusTextStorage'];
				$thirdValue = $_POST['shareOptionStorage'];
				$fourthValue = $_POST['dateStorage'];
				$fifthValue = array($_POST['allowLikeStorage'], $_POST['allowCommentStorage'], $_POST['allowShareStorage'], $_POST['allowNoneStorage']);

				//Execute query
				$query = "SELECT * FROM $sql_tble";
				$result = mysqli_query($conn, $query);

				//Check if query worked. If not, the table doesn't exist
				if(!$result){
					$string2 = "<p>Table does not exist. Created $sql_tble for you...</p>";
					$query = "CREATE TABLE $sql_tble(
								status_code VARCHAR(5) PRIMARY KEY,
								status_text VARCHAR(200) NOT NULL,
								share_option VARCHAR(20),
								date_selection DATE NOT NULL,
								permission_type VARCHAR(100)
							)";

					$result = mysqli_query($conn, $query);
				}

				//Adding the new status. But first check if the status input already exists
				$query = "SELECT status_code FROM $sql_tble WHERE status_code = '$firstValue'";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_assoc($result);

				if($row["status_code"]===null){
					//Status code does not previously exist
					//First name home button enabled and make return button visable
					$homeButtonClass = '';
					$returnButtonClass = 'class="btn btn-primary"';

					//Check which permission type was checked
					if(!($fifthValue[0]==="off")){
						$permissionString .= "Allow Liking, ";
					}
					if(!($fifthValue[1]==="off")){
						$permissionString .= "Allow Commenting, ";
					}
					if(!($fifthValue[2]==="off")){
						$permissionString .= "Allow Sharing, ";
					}
					if(!($fifthValue[3]==="off")){
						$permissionString .= "No Permissions Allowed";
					}

					$query = "INSERT INTO $sql_tble (status_code, status_text, share_option, date_selection, permission_type)
								VALUES ('$firstValue','$secondValue','$thirdValue','$fourthValue','$permissionString')";
					$result = mysqli_query($conn, $query);

				}else{
					//Make the return button visable and keep the home button disabled
					$returnButtonClass = 'class="btn btn-primary"';
					//Hide the main box and unhide the failure box
					$mainHidden = 'hidden';
					$failureHidden = '';
				}

				//Clear and clean all connections
				mysqli_free_result($result);
				mysqli_close($conn);
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
					<a class="nav-item nav-link <?php echo $homeButtonClass; ?>" href="index.html">Home</a>
					<a class="nav-item nav-link <?php echo $homeButtonClass; ?>" href="poststatusform.php">Post a New Status</a>
					<a class="nav-item nav-link <?php echo $homeButtonClass; ?>" href="searchstatusform.html">Search Status'</a>
					<a class="nav-item nav-link <?php echo $homeButtonClass; ?>" href="about.html">About this Assignment</a>
		    	</div>
		  	</div>
		</nav><br><br>
		<!-- Page Content -->
		<div class="container-fluid px-lg-5">
			<div class="form-group row" <?php echo $mainHidden; ?>>
				<div class="col-5">
					<div class="card">
						<div class="card-body">
							<p class="card-text">
								<?php echo $string1.$string2 ?>
								Your submission entry: <?php echo $_POST['statusCodeStorage']; ?> has been validated and has been entered into the database
								Click <i>Home</i> to go back to index.html or click <i>Return</i> or <i>Post a New Status</i> to go back to the posting page
							</p>
							<a href="poststatusform.php" <?php echo $returnButtonClass; ?>>Return</a>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row" <?php echo $failureHidden; ?>>
				<div class="col-5">
					<div class="card">
						<div class="card-body">
							<p class="card-text">
								Your submission entry: <?php echo $_POST['statusCodeStorage']; ?> already exists within the database. Please click the <i>Return</i> button to try again.
							</p>
							<a href="poststatusform.php" <?php echo $returnButtonClass; ?>>Return</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>