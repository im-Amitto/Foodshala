<?php include "header.php" ?>
<?php
include "dbconfig.php";

$email = $_SESSION["email"];

try {
  $sql = "select food_menu.*,rest_login.name as rest_name from food_menu left join rest_login on food_menu.rest_id = rest_login.id;
  ";
  $stmt = $DB->prepare($sql);
  $stmt->execute();
  $listedFoodItems = $stmt->fetchAll();
} catch (Exception $ex) {
  echo $ex->getMessage();
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["orderFood"])) {
    if (!isset($_SESSION["email"])) {
      $url = "custLogin.php";
      $_SESSION["msg"] = "Please login to place order";
      $_SESSION["msgType"] = "warning";
      redirect($url);
    }
    $url = "menu.php";
    if (!isset($_SESSION["userType"]) || $_SESSION["userType"] == "rest") {
      $msg = "Only customer can place orders";
      $msgType = "warning";

      $_SESSION["msg"] = $msg;
      $_SESSION["msgType"] = $msgType;
      redirect($url);
    }
    $custId = $_SESSION["userId"];
    $foodId = $_POST["foodId"];
    $restId = $_POST["restId"];
    $sql = "INSERT INTO `orders` (`custId`, `foodId`, `restId`) VALUES " . "( :custId, :foodId, :restId)";
    $stmt = $DB->prepare($sql);
    $stmt->bindValue(":custId", $custId);
    $stmt->bindValue(":foodId", $foodId);
    $stmt->bindValue(":restId", $restId);

    $stmt->execute();
    $msg = "Food Ordered Successfully";
    $msgType = "success";

    $_SESSION["msg"] = $msg;
    $_SESSION["msgType"] = $msgType;
    redirect($url);
  }
}
?>

<div class="container" style="padding-top:20px; min-height:120px;">
  <?php if ($_SESSION["msg"] <> "") { ?>
    <br>
    <div class="alert alert-dismissable alert-<?php echo $_SESSION["msgType"]; ?>">
      <button data-dismiss="alert" class="close" type="button">x</button>
      <p><?php echo $_SESSION["msg"]; ?></p>
    </div>
  <?php $_SESSION["msg"] = "";
    $_SESSION["msgType"] = "";
  } ?>
  <?php
  $x = 0;
  while ($listedFoodItems[$x]["name"]) {
    $tempFood = $listedFoodItems[$x];
  ?>
    <div class="card col-sm-3">
      <div class="card-container">
        <h4><b><?php echo $tempFood["name"] ?></b></h4>
        <h5><b>Food Type: <?php echo $tempFood["food_type"] ?></b></h5>
        <p>Description: <?php echo $tempFood["description"] ?></p>
        <p>By <?php echo $tempFood["rest_name"] ?></p>
        <form method="post">
          <input style="display: none" id="foodId" type="text" value="<?php echo $tempFood["id"] ?>" class="form-control" name="foodId" readonly hidden>
          <input style="display: none" id="restId" type="text" value="<?php echo $tempFood["rest_id"] ?>" class="form-control" name="restId" readonly hidden>
          <button type="submit" class="btn btn-success" name="orderFood">Order</button>
        </form>
      </div>
    </div>
  <?php
    $x++;
  }
  ?>
</div>


<br><br>

<?php include "footer.php" ?>