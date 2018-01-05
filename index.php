<?php

    session_start();
    
    $noNavBar = '';
    $noContent = '';
    
    // If session is active, then redirect to dashboard
    if (isset($_SESSION['username'])){
        header('Location: dashboard.php');
        exit();
    }
    
    require_once 'init.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {     //Check if the credentials are coming through POST method
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = sha1($password);
        
        // Check if the user exists in the database
        
        $statement = $con->prepare('SELECT UserID, Username, UserPassword FROM users WHERE Username = ? AND UserPassword = ? LIMIT 1');
        $statement->execute(array($username, $hashedPassword));
        $row = $statement->fetch();
        $count = $statement->rowCount();
        
        // If $count is greater than 0, then the user exists
        
        if ($count > 0) {
            $_SESSION['username']   = $username;        // Register username in session
            $_SESSION['id']         = $row['UserID'];   // Register user id in session
            header('Location: dashboard.php');
        }
    }
  
?>
<h1 class="appName"><span>P</span>rofiler <span>A</span>pp</h1>
<div class="container" id="login">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <h2 class="text-center">Login</h2>
      <div class="form-group">
          <input type="text" class="form-control" name="username" placeholder="&#xf007 Username"/>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="&#xf084 Password"/>
      </div>
        <button type="submit" class="btn btn-primary">&#xf090; &nbsp; Login</button>
    </form>
</div>

<?php 
    
    require_once $tmpl . 'footer.php';