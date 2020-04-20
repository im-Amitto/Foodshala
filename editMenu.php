<?php include "header.php" ?>
<?php
if (!isset($_SESSION["email"]) || !isset($_SESSION["userType"]) || $_SESSION["userType"] != "rest") {
  redirect("restLogin.php");
}


include "dbconfig.php";


$email = $_SESSION["email"];

$sql = "SELECT * from rest_login where email = :email";
try {
  $stmt = $DB->prepare($sql);
  $stmt->bindValue(":email", $email);
  $stmt->execute();
  $result = $stmt->fetchAll();

  $restId = $result[0]["id"];
  $name = $result[0]["name"];
  $priority = $result[0]["priority"];
  $img_path = $result[0]["img_path"];

  $sql = "SELECT * from food_menu where rest_id = :restId";
  $stmt = $DB->prepare($sql);
  $stmt->bindValue(":restId", $restId);
  $stmt->execute();
  $listedFoodItems = $stmt->fetchAll();
} catch (Exception $ex) {
  echo $ex->getMessage();
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["upload"])) {
    $url = "editMenu.php#home";

    if ($_FILES["uploadedimage"]["size"] > 50000) {
      $msg = "Sorry, your file is too large(Max=50KB).";
      $msgType = "info";
      $_SESSION["msg"] = $msg;
      $_SESSION["msgType"] = $msgType;
      redirect($url);
    } else {
      if (!empty($_FILES["uploadedimage"]["name"])) {

        $file_name = $_FILES["uploadedimage"]["name"];
        $temp_name = $_FILES["uploadedimage"]["tmp_name"];
        $imgtype = $_FILES["uploadedimage"]["type"];
        $ext = GetImageExtension($imgtype);
        $imagename = date("d-m-Y") . "-" . time() . $ext;
        $target_path = "images/" . $imagename;
        if (move_uploaded_file($temp_name, $target_path)) {

          $sql = "UPDATE `rest_login` SET `img_path`= :img_path where email = :email";
          $stmt = $DB->prepare($sql);
          $stmt->bindValue(":img_path", $target_path);
          $stmt->bindValue(":email", $email);
          $stmt->execute();
          unlink($img_path);
          $msg = "Picture is updated successfully";
          $msgType = "success";

          $_SESSION["msg"] = $msg;
          $_SESSION["msgType"] = $msgType;
          redirect($url);
        } else {
        }
      }
    }
  } elseif (isset($_POST["changepass"])) {
    $url = "editMenu.php#changepass";
    $pass = $_POST["passw"];
    $npass = $_POST["password"];
    $sql = "SELECT * from rest_login where email = :email and pass= :pass ";
    $stmt = $DB->prepare($sql);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":pass", md5($pass));
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (count($result) == 1) {
      $sql = "UPDATE `rest_login` SET `pass`= :npass where email = :email";
      $stmt = $DB->prepare($sql);
      $stmt->bindValue(":npass", md5($npass));
      $stmt->bindValue(":email", $email);
      $stmt->execute();
      $msg = "Password updated successfully";
      $msgType = "success";

      $_SESSION["msgpass"] = $msg;
      $_SESSION["msgTypepass"] = $msgType;
      redirect($url);
    } else {
      $msg = "Wrong Password";
      $msgType = "warning";
      $_SESSION["msgpass"] = $msg;
      $_SESSION["msgTypepass"] = $msgType;
      redirect($url);
    }
  } elseif (isset($_POST["addFood"])) {
    $url = "editMenu.php#addFood";
    $fname = $_POST["fname"];
    $description = $_POST["description"];
    $foodType = $_POST["foodType"];
    $sql = "INSERT INTO `food_menu` (`name`, `description`, `rest_id`, `food_type`) VALUES " . "( :fname, :description, :restId, :foodType)";
    $stmt = $DB->prepare($sql);
    $stmt->bindValue(":fname", $fname);
    $stmt->bindValue(":description", $description);
    $stmt->bindValue(":restId", $restId);
    $stmt->bindValue(":foodType", $foodType);

    $stmt->execute();
    $msg = "Food Added Successfully";
    $msgType = "success";

    $_SESSION["msgbio"] = $msg;
    $_SESSION["msgTypebio"] = $msgType;
    redirect($url);
  }
}
function GetImageExtension($imagetype)
{
  if (empty($imagetype)) return false;
  switch ($imagetype) {
    case 'image/bmp':
      return '.bmp';
    case 'image/gif':
      return '.gif';
    case 'image/jpeg':
      return '.jpg';
    case 'image/png':
      return '.png';
    default:
      return false;
  }
}

?>

<div class="container">
  <style>
    ul.nav-pills li {
      font-weight: 600;
      font-size: 1.2em;
    }
  </style>
  <br><br><br>
  <ul class="nav nav-pills nav-justified">
    <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    <li><a data-toggle="tab" href="#addFood">Add New Food</a></li>
    <li><a data-toggle="tab" href="#foodMenu">Food Menu</a></li>
    <li><a data-toggle="tab" href="#changepass">Change Password</a></li>
    <li><a href="?log=1">Logout</a></li>
  </ul>

  <div class="tab-content text-center">

    <div id="home" class="tab-pane fade in active">

      <?php if ($_SESSION["msg"] <> "") { ?>
        <br>
        <div class="alert alert-dismissable alert-<?php echo $_SESSION["msgType"]; ?>">
          <button data-dismiss="alert" class="close" type="button">x</button>
          <p><?php echo $_SESSION["msg"]; ?></p>
        </div>
      <?php $_SESSION["msg"] = "";
        $_SESSION["msgType"] = "";
      } ?>

      <br><br />
      <div class="row">
        <div class="col-md-5">
          <h4>Name :&nbsp;&nbsp;<?php echo $name ?> </h4><br />
          <h4>E-mail :&nbsp;&nbsp;<?php echo $email ?></h4><br />
          <h4>Restaurant Id :&nbsp;&nbsp;<?php echo $restId ?></h4><br />

        </div>

        <div class="col-md-3">
        </div>

        <div class="col-md-2">

          <img src="<?php echo $img_path ?>" class="img" height=170px; width=170px; alt="Upload Profile Pic">

          <form enctype="multipart/form-data" method="post">
            <br> <input style="text-align: center;
  margin: auto;" type="file" name="uploadedimage" accept="image/*" required><br>
            <input name="upload" class="btn btn-success" type="submit" value="Upload Image">
          </form>

        </div>

        <div class="col-md-2">
        </div>

      </div>

    </div>





    <div id="addFood" class="tab-pane fade">


      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
          <?php if ($_SESSION["msgbio"] <> "") { ?>
            <br>
            <div class="alert alert-dismissable alert-<?php echo $_SESSION["msgTypebio"]; ?>">
              <button data-dismiss="alert" class="close" type="button">x</button>
              <p><?php echo $_SESSION["msgbio"]; ?></p>
            </div>
          <?php $_SESSION["msgbio"] = "";
            $_SESSION["msgTypebio"] = "";
          } ?>
          <form method="post" class="text-center">
            <br><br>

            <legend>Add new food</legend>
            <br>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input id="restId" type="text" value="<?php echo $restId ?>" class="form-control" name="restId" readonly>
            </div><br>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input id="fname" type="text" class="form-control" name="fname" placeholder="Food Name" required>
            </div><br>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-sunglasses"></i></span>
              <input id="description" type="text" value="<?php echo $hobbies ?>" class="form-control" name="description" placeholder="Food short description">
            </div><br>
            <div class="input-group">
              <label class="radio-inline">
                <input value="veg" type="radio" name="foodType" checked>Veg
              </label>
              <label class="radio-inline">
                <input value="nonVeg" type="radio" name="foodType">Non Veg
              </label>
            </div><br>
            <button type="submit" class="btn btn-success" name="addFood">Add Food</button>
          </form>
        </div>
      </div>
    </div>





    <div id="foodMenu" class="tab-pane fade text-center">
      <?php
      $x = 0;
      while ($listedFoodItems[$x]["name"]) {
        $tempFood = $listedFoodItems[$x];
      ?>
        <div class="card col-sm-3">
          <div class="card-container">
            <h4><b><?php echo $tempFood["name"] ?></b></h4>
            <h5><b><?php echo $tempFood["food_type"] ?></b></h5>
            <p><?php echo $tempFood["description"] ?></p>
          </div>
        </div>
      <?php
        $x++;
      }
      ?>
    </div>



    <div id="changepass" class="tab-pane fade">
      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
          <?php if ($_SESSION["msgpass"] <> "") { ?>
            <br>
            <div class="alert alert-dismissable alert-<?php echo $_SESSION["msgTypepass"]; ?>">
              <button data-dismiss="alert" class="close" type="button">x</button>
              <p><?php echo $_SESSION["msgpass"]; ?></p>
            </div>
          <?php $_SESSION["msgpass"] = "";
            $_SESSION["msgTypepass"] = "";
          } ?>
          <br><br>
          <form method="post" class="text-center" id="valid">
            <legend>Change Password</legend>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input id="oldpass" type="password" class="form-control" name="passw" placeholder="Old Password" required>
            </div><br>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input id="pass" type="password" pattern=".{8,}" title="Password must be atleast 8  character." class="form-control" name="password" placeholder="Enter Your Password" required>
            </div><br>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input id="cpass" type="password" class="form-control" name="confirmPassword" placeholder="Retype Your Password" required>
            </div><br>
            <button type="submit" class="btn btn-info " name="changepass">Change Password</button>
          </form>
        </div>
      </div>
    </div>


  </div>
</div>
<br><br>

<?php include "footer.php" ?>