<?php include "header.php" ?>
<?php
$url = $_SERVER["PHP_SELF"];

if (isset($_SESSION["email"]) && isset($_SESSION["userType"]) && $_SESSION["userType"] == "rest") {
  $url = "editMenu.php";
  redirect($url);
}
require_once 'dbconfig.php';
$name = $email =  $name = $pass = $cpass =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["register"])) {
    $email = test_input($_POST["email"]);
    $name = test_input($_POST["name"]);
    $pass = test_input($_POST["password"]);
    $sql = "SELECT COUNT(*) AS count from rest_login where email = :email_id";
    try {
      $stmt = $DB->prepare($sql);
      $stmt->bindValue(":email_id", $email);
      $stmt->execute();
      $result = $stmt->fetchAll();

      if ($result[0]["count"] > 0) {
        $msg = "Email already exist";
        $msgType = "warning";
        $_SESSION["msg"] = $msg;
        $_SESSION["msgType"] = $msgType;
        redirect($url);
      } else {
        $sql = "INSERT INTO `rest_login` (`name`, `pass`, `email`) VALUES " . "( :name, :pass, :email)";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":pass", md5($pass));
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $result = $stmt->rowCount();

        if ($result > 0) {

          $lastID = $DB->lastInsertId();

          try {
            $msg = "Thanks for registring with us";
            $msgType = "success";
            $_SESSION["msg"] = $msg;
            $_SESSION["msgType"] = $msgType;
            redirect($url);
          } catch (Exception $ex) {
            $sql = "Delete from `rest_login` where email = :email";

            $stmt = $DB->prepare($sql);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $msg = "Failed to create User";
            $msgType = "warning";
            $_SESSION["msg"] = $msg;
            $_SESSION["msgType"] = $msgType;
            redirect($url);
          }
        } else {
          $msg = "Failed to create User";
          $msgType = "warning";
          $_SESSION["msg"] = $msg;
          $_SESSION["msgType"] = $msgType;
          redirect($url);
        }
      }
    } catch (Exception $ex) {
      echo $ex->getMessage();
    }
  } elseif (isset($_POST["login"])) {


    $email = test_input($_POST["email"]);
    $_SESSION["wemail"] = $email;
    $pass = test_input($_POST["password"]);
    $sql = "SELECT * from rest_login where email = :email";
    try {
      $stmt = $DB->prepare($sql);
      $stmt->bindValue(":email", $email);
      $stmt->execute();
      $result = $stmt->fetchAll();

      if (count($result) > 0) {
        $sql = "SELECT * from rest_login where email = :email and pass= :pass ";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":pass", md5($pass));
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (count($result) == 1) {
          $_SESSION["email"] = $email;
          $_SESSION["userType"] = "rest";
          $_SESSION["userId"] = $result[0]['id'];
          redirect($url);
        } else {
          $msg = "Wrong Password";
          $msgType = "warning";
          $_SESSION["msg"] = $msg;
          $_SESSION["msgType"] = $msgType;
          redirect($url);
        }
      } else {
        $msg = "E-mail does't exist.";
        $msgType = "warning";
        $_SESSION["msg"] = $msg;
        $_SESSION["msgType"] = $msgType;
        redirect($url);
      }
    } catch (Exception $ex) {
      echo $ex->getMessage();
    }
  }
}
?>

<br>

<div class="container">
  <div class="text-center headline bloc ">
    <h3>Restaurant Login Portal</h3>
  </div>

  <div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
      <?php if ($_SESSION["msg"] <> "") { ?>
        <div class="alert alert-dismissable alert-<?php echo $_SESSION["msgType"]; ?>">
          <button data-dismiss="alert" class="close" type="button">x</button>
          <p><?php echo $_SESSION["msg"]; ?></p>
        </div>
      <?php $_SESSION["msg"] = "";
        $_SESSION["msgType"] = "";
      } ?>
      <form method="post" class="text-center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
        <legend>Login Details</legend>
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input id="email" type="email" value="<?php echo $_SESSION["wemail"]; ?>" class="form-control" name="email" title="Enter your college e-mail" placeholder="College Email" value="<?php echo $email ?>" required>
        </div><br>
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
        </div><br>
        <button type="submit" class="btn btn-info " name="login">Login</button>
        <a class="btn btn-warning" data-toggle="collapse" data-target="#Register">New User?</a>
      </form>

      <br>

      <div id="Register" class="collapse">
        <form method="post" class="text-center" id="valid">
          <legend>Register Yourself</legend>

          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input id="email" type="email" class="form-control" title="Enter your e-mail" name="email" placeholder="Enter Your College E-mail" required>
          </div><br>
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="email" type="text" class="form-control" name="name" placeholder="Enter Your Full Name" required>
          </div><br>
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="pass" type="password" pattern=".{8,}" title="Password must be atleast 8  character." class="form-control" name="password" placeholder="Enter Your Password" required>
          </div><br>
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="cpass" type="password" class="form-control" name="confirmPassword" placeholder="Retype Your Password" required>
          </div><br>
          <button type="submit" class="btn btn-success" name="register">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>

<br><br>
<?php include "footer.php" ?>