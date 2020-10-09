<?php
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/functions.inc.php'); // functions
?>

<?php 
  include('includes/head.inc.php'); 
  // include global css, javascript, end the head and open the body
?>

<?php
  // We'll need a database connection both for retrieving records and for 
  // inserting them.  Let's get it up front and use it for both processes
  // to avoid opening the connection twice.  If we make a good connection, 
  // we'll change the $dbOk flag.
  $dbOk = false;
  
  /* Create a new database connection object, passing in the host, username,
     password, and database to use. The "@" suppresses errors. */
  @ $db = new mysqli('localhost', 'root', '', 'itproject');
  
  if ($db->connect_error) {
    echo '<div class="messages">Could not connect to the database. Error: ';
    echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
  } else {
    $dbOk = true; 
  }

  // Now let's process our form:
  // Have we posted?
  $havePost = isset($_POST["save"]);
  
  // Let's do some basic validation
  $errors = '';
  if ($havePost) {
    
    // Get the output and clean it for output on-screen.
    // First, let's get the output one param at a time.
    // Could also output escape with htmlentities()
    $name = htmlspecialchars(trim($_POST["name"]));  
    $description = htmlspecialchars(trim($_POST["description"]));
    $difficulty = htmlspecialchars(trim($_POST["difficulty"]));
    $deadline = htmlspecialchars(trim($_POST["deadline"]));
    $etc = htmlspecialchars(trim($_POST["etc"]));
    
  
    
    $focusId = ''; // trap the first field that needs updating, better would be to save errors in an array
    
    if ($name == '') {
      $errors .= '<li> Assignment name may not be blank</li>';
      if ($focusId == '') $focusId = '#name';
    }
    if ($description == '') {
      if ($focusId == '') $focusId = '#description';
    }

    if ($difficulty == '') {
      $errors .= '<li> Assignment difficulty may not be blank</li>';
      if ($focusId == '') $focusId = '#difficulty';
    }

    if ($deadline == '') {
      $errors .= '<li>Deadline may not be blank</li>';
      if ($focusId == '') $focusId = '#deadline';
    }


    if ($etc == '') {
      if ($focusId == '') $focusId = '#etc';
    }

    
    if ($_POST) {
      if ($errors != '') {
        echo '<div class="messages"><h4>Please correct the following errors:</h4><ul>';
        echo $errors;
        echo '</ul></div>';
        echo '<script type="text/javascript">';
        echo '  $(document).ready(function() {';
        echo '    $("' . $focusId . '").focus();';
        echo '  });';
        echo '</script>';
      } else { 
        if ($dbOk) {

          $nameForDb = trim($_POST["name"]);  
          $descriptionForDb = trim($_POST["description"]);
          $difficultyForDb = trim($_POST["difficulty"]);
          $deadlineForDb = trim($_POST["deadline"]);
          $etcForDb = trim($_POST["etc"]);

          $insQuery = "insert into assignment (name, description, difficulty, deadline, Etc, completion, deletion)
          VALUES ('".$nameForDb."', '".$descriptionForDb."', ".$difficulty.",'".$deadlineForDb."', '".$etcForDb."', 0, 0)";
          $db->query($insQuery);
         
        }
      }
      header("Location: " . $_SERVER['REQUEST_URI']);
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://kit.fontawesome.com/84a8bd98d0.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta name="google-signin-client_id" content="53849745924-juhnu10128pnt2ma7mklu6i8mpldjru6.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="home.js"></script>
    <script src="resources/sortable.js"></script>

    <title>Plan.IT</title>
    <link rel="icon" href="resources/Logo.png">
    <link rel="stylesheet" type='text/css' href="index.css" />
  </head>
  <body>
    <div id="navbar">
      <a class = "active" href="#home">Home</a>
      
      <div id = "projectName" style="display: inline-block; margin-left: 700px; margin-top: 12px; color:white; font-size: 24px;">
        <p> Plan.IT </p>
      </div>
      
      <div id="userInfo" style="margin-top: 0px;">
        <img id="pic" width ="30" height="30" style="display: inline-block;">
        <h4 id="email" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;"></h4>
        <a href="#" class="profileData" id = "logoutButton" onclick="signOut()" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;">Logout <i class="fa fa-sign-out"></i></a>
      </div>
    </div>
        
    <div id="slider" class="slideIn">
      <div id="slideOutTab">
        <div>
          <p>Add Task</p>
        </div>
      </div>
      <div class="modal-content">
        <div class="modal-header"> 
          <h4 class="modal-title"> Add Task </h4> </div>
        <div class="modal-body">
          <form id="addForm" name="addForm" action="home.php" method="post" onsubmit="return validate(this);">
            <fieldset> 
              <div class="formData">
                <label class="field" for="name">Name: </label>
                <div class="value"><input type="text" size="30" placeholder="Assignment Name..." maxlength="33" value="<?php if($havePost && $errors != '') { echo $name; } ?>" name="name" id="name"/></div>
                <br/>
                <label class="field" for="description">Description:</label>
                <div class="value"><input type="text" size="30" placeholder="Assignment Description..." maxlength="150" value="<?php if($havePost && $errors != '') { echo $description; } ?>" name="description" id="description"/></div>
                <br/>
                <label class="field" for="difficulty">Difficulty:</label>
                <div class="value"><input type="text" size="30" placeholder="Difficulty 1-3..." maxlength="1" value="<?php if($havePost && $errors != '') { echo $difficulty; } ?>" name="difficulty" id="difficulty"/></div>
                <br/>
                <label class="field" for="deadline">Date:</label>
                <div class="value">
                  <input type="datetime-local" size="20" maxlength="19" value="<?php if($havePost && $errors != '') { echo $deadline; } ?>" name="deadline" id="deadline" />
                </div>
                <br/>
                <label class="field" for="etc">Etc:</label>
                <div class="value"><input type="text" size="30"  placeholder="Optional Additives..." maxlength="120" value="<?php if($havePost && $errors != '') { echo $etc; } ?>" name="etc" id="etc"/></div>

               <input type="submit" value="Add Task" id="save" name="save"/>

              </div>
            </fieldset>
          </form>
        </div>
        <div class="modal-footer"> </div>
      </div>
    </div>


    <br/>
    
    <table class = "sortable assignmentTable" >
     
        <?php
        if ($dbOk) {

            $query = "select * from assignment where deletion = 0 AND NOT completion = 100 order by deadline";
            $result = $db->query($query);
            $numRecords = $result->num_rows;
            
            echo '<tr class="topSelectors"><td class="spacer"></td><th>Name:</th><th>Difficulty:</th><th>Date:</th><th>Completion:</th></tr>';
            for ($i=0; $i < $numRecords; $i++) {
            $record = $result->fetch_assoc();
            
            if($record['difficulty'] == 1) {
              echo "\n".'<tr class="easy" id="assignment-' . $record['assignmentid'] . '"><td><i class="fas fa-clipboard-list"></i></td><td class ="taskName">';
            }
            else if($record['difficulty'] == 2) {
              echo "\n".'<tr class="med" id="assignment-' . $record['assignmentid'] . '"><td><i class="fas fa-clipboard-list"></i></td><td class ="taskName">';
            }
            else if($record['difficulty'] == 3) {
              echo "\n".'<tr class="hard" id="assignment-' . $record['assignmentid'] . '"><td><i class="fas fa-clipboard-list"></i></td><td class ="taskName">';
            }

            echo htmlspecialchars($record['name']);
            echo '</td><td class="taskDescription">';
            echo htmlspecialchars($record['description']);
            echo '</td><td class="taskDifficulty">';
            if($record['difficulty'] == 1) {echo htmlspecialchars("Easy");}
            else if($record['difficulty'] == 2) {echo htmlspecialchars("Medium");}
            else if($record['difficulty'] == 3) {echo htmlspecialchars("Hard");}
            echo '</td><td class="taskDeadline">';
            $date = strtotime($record['deadline']);
            $date = date('m-d H:i A', $date);
            echo $date;

            // echo htmlspecialchars($record['deadline']);
            echo '</td><td class="taskEtc">';
            echo htmlspecialchars($record['Etc']);
            echo '</td><td class="taskCompletion"><div class="plus"><i class="fas fa-plus"></i></div><div class="amount">';
        
            echo htmlspecialchars($record['completion']);
            
            // echo '</p><p class="plus">+</>';
            echo '</div><div class="minus"><i class="fas fa-minus"></i></div>';
            echo '</td><td>';
            echo '</td><td class="taskDeletion">';
            echo '<i class="fas fa-trash-alt deleteAssignment" alt="delete assignment"></i>';
            // echo '<img src="resources/check.jpg" class="deleteAssignment" width="16" height="16" alt="delete assignment"/>';

            echo '</td></tr>';
            }
            
            $result->free();
        }
        
        ?>
    </table>
    <br/>


    <br/>
    <br/>

    <table class = "sortable assignmentTable">
     
      <?php
      if ($dbOk) {

          $query = "select * from assignment where deletion = 1 OR completion = 100 order by deadline";
          $result = $db->query($query);
          $numRecords = $result->num_rows;
          
          // echo '<tr><th>Name:</th><th class="sorttable_nosort">Description:</th><th>Difficulty</th><th>Date:</th><th class="sorttable_nosort">Etc:</th><th>Completion</th><th class="sorttable_nosort">Finish</th></tr>';
          echo '<tr class="topSelectors"><td class="spacer2"></td><th>Name:</th><th>Difficulty:</th><th>Date:</th></tr>';
          for ($i=0; $i < $numRecords; $i++) {
          $record = $result->fetch_assoc();
          
          if($record['difficulty'] == 1) {
            echo "\n".'<tr class="easy" id="assignment-' . $record['assignmentid'] . '"><td><i class="fas fa-clipboard-check"></i></td><td class ="taskName">';
          }
          else if($record['difficulty'] == 2) {
            echo "\n".'<tr class="med" id="assignment-' . $record['assignmentid'] . '"><td><i class="fas fa-clipboard-check"></i></td><td class ="taskName">';
          }
          else if($record['difficulty'] == 3) {
            echo "\n".'<tr class="hard" id="assignment-' . $record['assignmentid'] . '"><td><i class="fas fa-clipboard-check"></i></td><td class ="taskName">';
          }

          echo htmlspecialchars($record['name']);
          echo '</td><td class="taskDescription">';
          echo htmlspecialchars($record['description']);
          echo '</td><td class="taskDifficulty">';
          if($record['difficulty'] == 1) {echo htmlspecialchars("Easy");}
          else if($record['difficulty'] == 2) {echo htmlspecialchars("Medium");}
          else if($record['difficulty'] == 3) {echo htmlspecialchars("Hard");}
          echo '</td><td class="taskDeadline">';
          $date = strtotime($record['deadline']);
          $date = date('m-d H:i A', $date);
          echo $date;

          // echo htmlspecialchars($record['deadline']);
          echo '</td><td class="taskEtc">';
          echo htmlspecialchars($record['Etc']);
          echo '</td><td class="taskCompletion"><div class="plus" style="pointer-events:none"><i class="fas fa-plus"></i></div><div class="amount">';
      
          echo htmlspecialchars($record['completion']);
          
          // echo '</p><p class="plus">+</>';
          echo '</div><div class="minus"><i class="fas fa-minus"></i></div>';
          echo '</td><td>';
          echo '</td><td class="taskDeletion">';
          echo '<i class="fas fa-trash-restore returnAssignment" alt="return assignment"></i>';
          // echo '<img src="resources/check.jpg" class="deleteAssignment" width="16" height="16" alt="delete assignment"/>';

          echo '</td></tr>';
          }
          
          $result->free();
      }
     
     ?>

    </table>


    <br/>
    <br/>
    <br/>
    <br/>

    <div id="slider2" class="slideIn2">
      <div id="slideOutTab2">
        <div>
          <p> Check Stats </p>
        </div>
      </div>
      <div class="modal-content">
        <div class="modal-header"> 
          <h4 class="modal-title"> Check Stats Here </h4> </div>
        <div class="modal-body">
          <?php 
            @ $db = new mysqli('localhost', 'root', '', 'itproject');
            if ($db->connect_error) {
              echo '<div class="messages">Could not connect to the database. Error: ';
              echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
            } 
            date_default_timezone_set('America/New_York');
            
            $today = new DateTime('now');
            $endDate = new DateTime('now');

            $basicQuery = 'select * from assignment where deadline > "' . $today->format('Y-m-d H:i:s') . '"';
            
            // gets assignments due before now
            $query = 'select * from assignment where deadline < "' . $today->format('Y-m-d H:i:s') . '"';
            $result = $db->query($query);
            $numOver = $result->num_rows;

            $overDifficulty = 0;
            for ($i=0; $i < $numOver; $i++) {
              $record = $result->fetch_assoc();
              $overDifficulty += $record['difficulty'];
            }

            if($numOver > 0){
              $overDifficulty /= $numOver;
              $overDifficulty = floatval($overDifficulty);
            }
            else{
              $overDifficulty = 0;
            }
            $overDifficulty = number_format((float)$overDifficulty, 1, '.', '');

            

            // gets assignments due within a day
            $endDate->modify('+1 day');

            $query = $basicQuery . ' && deadline < "' . $endDate->format('Y-m-d H:i:s') . '"';
            $result = $db->query($query);
            $numToday = $result->num_rows;

            $todayDifficulty = 0;
            for ($i=0; $i < $numToday; $i++) {
              $record = $result->fetch_assoc();
              $todayDifficulty += $record['difficulty'];
            }
            
            if($numToday > 0){
              $todayDifficulty /= $numToday;
              $todayDifficulty = floatval($todayDifficulty);
            }
            else{
              $todayDifficulty = 0;
            }
            $todayDifficulty = number_format((float)$todayDifficulty, 1, '.', '');


            // gets assignments due within a week
            $endDate->modify('+6 day');

            $query = $basicQuery . ' && deadline < "' . $endDate->format('Y-m-d H:i:s') . '"';
            $result = $db->query($query);
            $numWeek = $result->num_rows;

            $weekDifficulty = 0;
            for ($i=0; $i < $numWeek; $i++) {
              $record = $result->fetch_assoc();
              $weekDifficulty += $record['difficulty'];
            }
            
            if($numWeek > 0){
              $weekDifficulty /= $numWeek;
              $weekDifficulty = floatval($weekDifficulty);
            }
            else{
              $weekDifficulty = 0;
            }
            $weekDifficulty = number_format((float)$weekDifficulty, 1, '.', '');

            //gets assignments that have been completed 
            



            $numOnTime = 0;

            $score = 3;
            if($numOver > 5)
              $score -= 2;
            else if($numOver > 0)
              $score -= 1;
            else if($numOnTime > 95)
              $score += 1;

            if($numToday > 10)
              $score -= 1;
            else if($numWeek == 0)
              $score += 2;
            else if($numToday == 0)
              $score += 1;


            if($score < 1)
              $score = 1;
            else if($score > 5)
              $score = 5;


            // $finalScore = 3;

            // Status Summary
            echo '<p><div style="text-align: center; font-size:20px;">';
            if($score == 5) { echo 'Outstanding!'; } 
            else if($score == 4) { echo 'Doing Good'; } 
            else if($score == 3) { echo 'On Track'; } 
            else if($score == 2) { echo 'Slacking'; } 
            else if($score == 1) { echo 'Awful!'; } 
            echo '</div></p><div style="text-align:center;">';
            echo '<img src="resources/'. $score .'.png" width="192" height="192" alt="delete assignment"/>';
            echo '<br/><br/><br/></br>';
            echo '</div><b>Overdue: </b></p>';
            echo '<p>Assignments: ' . $numOver . '<br>Avg. Difficulty: '.$overDifficulty.'</p>';

            echo '<p><b>Today: </b></p>';
            echo '<p>Assignments: ' . $numToday . '<br>Avg. Difficulty: '.$todayDifficulty.'</p>';

            echo '<p><b>This Week: </b></p>';
            echo '<p>Assignments: ' . $numWeek . '<br>Avg. Difficulty: '.$weekDifficulty.'</p>';

            echo '<p><b>Finished On Time: </b></p>';
            echo '<p>' . $numOnTime . '%</p>';
            
            $result->free();
            $db->close();
          ?>
          <br/>
          <br/>
          <br/>
        </div>
        <div class="modal-footer"> </div>
      </div>
    </div>

    <script>
      $("#slideOutTab").click(function () {
        if ($(this).parent().hasClass("slideIn")) {
          $(this).parent().removeClass("slideIn");
          $(this).parent().addClass("slideOut");
        } 
        else {
          $(this).parent().removeClass("slideOut");
          $(this).parent().addClass("slideIn");
        }
      });

      $("#slideOutTab2").click(function () {
        if ($(this).parent().hasClass("slideIn2")) {
          $(this).parent().removeClass("slideIn2");
          $(this).parent().addClass("slideOut2");
        } 
        else {
          $(this).parent().removeClass("slideOut2");
          $(this).parent().addClass("slideIn2");
        }
      });
    </script>

    <script>
      window.onscroll = function() {myFunction()};

      var navbar = document.getElementById("navbar");
      var sticky = navbar.offsetTop;

      function myFunction() {
        if (window.pageYOffset >= sticky) {
          navbar.classList.add("sticky")
        } else {
          navbar.classList.remove("sticky");
        }
      }
    </script>

    <script>
      $(".plus").click(function() {
        var num = $(this).parent().find(".amount").html();
        var amount = parseInt(num);
        if(amount <= 95) {
          amount += 5;
          $(this).parent().find(".amount").html(amount);  
          if(amount == 100) {
            if(confirm('Are you sure you want to mark this task as completed?')) {
              $(this).parent().parent().find(".deleteAssignment").click();
            }
            else {
              $(this).parent().find(".amount").html("95");  
            }
          }
        }
      });

      $(".minus").click(function() {
        var num = $(this).parent().find(".amount").html();
        var amount = parseInt(num)
        if(amount >= 5) {
          amount -= 5;
          $(this).parent().find(".amount").html(amount);
          if(amount = 95) {
            $(this).parent().parent().find(".returnAssignment").click();
          }
        }
      });
    </script>

  </body>
</html>
