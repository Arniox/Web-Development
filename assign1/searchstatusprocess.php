<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Search Status Process</title>
</head>
  <body>
    <?php
      //Require the config
      require_once("config/sqlinfo.php");
      //Just in case the markers remove the config file, the code will still connect
      if(empty($sql_host)){
        $sql_host = "cmslamp14.aut.ac.nz";
        $sql_user = "bjy5305";
        $sql_paswd = "Is!FoxIn@BoxStill#Fox4";
        $sql_dbnm = "bjy5305";
        $sql_tble = "Status_Posts";
      }

      //Set up string output
      $stringOutput = '';

      //Create connection
      $conn = @mysqli_connect($sql_host,
        $sql_user,
        $sql_paswd,
        $sql_dbnm
      );

      //Check if button clicked
      if(isset($_GET['search'])){
        //Check if search status text box is not empty
        if(!empty($_GET['searchStatus'])){
          if(!$conn){
            $stringOutput .= '<p>Database connection failure...</p>';
          }else{
            //Execute query
            $searchByStatus = strtolower($_GET['searchStatus']);


            $query = "SELECT * FROM $sql_tble WHERE LOWER(status_text) LIKE LOWER('%$searchByStatus%')";
            $result = mysqli_query($conn, $query);

            if(!$result){
              $stringOutput .= "<p>Something is wrong with with your query: ".$query."...</p>";
            }else{

              $numCount = 0;
              //display the retrived records
              $stringOutput .= '<div class="form-group row">';
              $numberOfResults = 0;

              //For each item in the associative array from the result
              while($row = mysqli_fetch_assoc($result)){
                $numberOfResults++;

                $stringOutput .= '<div class="col-3">';
                $stringOutput .= '<div class="card">';
                $stringOutput .= '<div class="card-header">Status Result: '.($numCount+1).'</div>';
                $stringOutput .= '<div class="card-body">';
                $stringOutput .= '<h5 class="card-title">'.$row["status_code"].'</h5>';
                $stringOutput .= '<p class="card-text"><ul>';

                //Bold and italic the $searchByStatus found in the string
                $stringStatusTextIn = $row["status_text"];
                $searchPosition = strpos(strtolower($stringStatusTextIn), $searchByStatus);
                $stringStatusTextOut = "";
                for($num = 0; $num<strlen($stringStatusTextIn); $num++){
                  if($num != $searchPosition){
                    $stringStatusTextOut .= substr($stringStatusTextIn, $num, 1);
                  }else{
                    $stringStatusTextOut .= '<b>'.substr($stringStatusTextIn, $num, strlen($searchByStatus)).'</b>';
                    $num+= strlen($searchByStatus)-1;
                  }
                }

                $stringOutput .= '<li>Status Text Written: <i>'.$stringStatusTextOut.'</i></li>';
                $stringOutput .= '<li>Sharing Option Chosen: <i>'.$row["share_option"].'</i></li>';
                $stringOutput .= '<li>Date Posted: <i>'.date("j/m/Y - l, F", strtotime($row["date_selection"])).'</i></li>';
                $stringOutput .= '<li>Permission Type(s) Given: <i>'.$row["permission_type"].'</i></li>';
                $stringOutput .= '</ul></p>';
                $stringOutput .= '</div>';
                $stringOutput .= '</div>';
                $stringOutput .= '</div>';

                //Count for number of cards
                $numCount++;

                //Every 3 cards, make a new row of cards
                if($numCount%4==0){
                  $stringOutput .= '</div>';
                  $stringOutput .= '<div class="form-group row">';
                }
              }
              $stringOutput .= '</div>';

              //Free memory
              mysqli_free_result($result);
            }
            //close connection
            mysqli_close($conn);
          }
        }else{
          $stringOutput .= "<p>You have not entered anything into the search bar</p>";
        }
      }

    ?>
    <!-- Output all the string from the php function -->
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
          <a class="nav-item nav-link" href="poststatusform.php">Post a New Status</a>
          <a class="nav-item nav-link" href="searchstatusform.html">Search Status'</a>
          <a class="nav-item nav-link" href="about.html">About this Assignment</a>
          </div>
        </div>
    </nav><br><br>
    <div class="container-fluid px-lg-5">
      <div class="form-group row">
        <div class="col-3">
          <?php echo "<h4>Number of Results: ".$numberOfResults."</h4>"; ?>
        </div>
      </div>
      <?php echo $stringOutput; ?>
    </div>
  
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


  </body>
</html>
