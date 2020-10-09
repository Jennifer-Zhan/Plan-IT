<?php
  /* Delete an actor */
  
  /* Create a new database connection object, passing in the host, username,
     password, and database to use. The "@" suppresses errors. */
  @ $db = new mysqli('localhost', 'root', '', 'itproject');
  
  if ($db->connect_error) {
    $connectErrors = array(
      'errors' => true,
      'errno' => mysqli_connect_errno(),
      'error' => mysqli_connect_error()
    );
    echo json_encode($connectErrors);
  } else {
    if (isset($_POST["id"])) {
      // get our id and cast as an integer
      $assignmentId = (int) $_POST["id"];
      
      // Setup a prepared statement.
      $query = "update assignment SET deletion = 1 where assignmentid = ?";
      $statement = $db->prepare($query);
      // bind our variable to the question mark
      $statement->bind_param("i",$assignmentId);
      // make it so:
      $statement->execute();

      // Setup a prepared statement.
      $query = "update assignment SET completion = 100 where assignmentid = ?";
      $statement = $db->prepare($query);
      // bind our variable to the question mark
      $statement->bind_param("i",$assignmentId);
      // make it so:
      $statement->execute();
      
      // return a json object that indicates success
      $success = array('errors'=>false,'message'=>'Assignment Finished');
      echo json_encode($success);
    }
  }
?>
