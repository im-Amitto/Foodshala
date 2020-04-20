<?php include "header.php" ?>
<?php
if (!isset($_SESSION["email"]) || !isset($_SESSION["userType"]) || $_SESSION["userType"] != "rest") {
  redirect("restLogin.php");
}


include "dbconfig.php";


$email = $_SESSION["email"];

try {
  $sql = "SELECT o.id, o.custId,o.foodId, fm.name as foodName, fm.food_type, cl.name as custName FROM orders AS o JOIN food_menu AS fm ON o.foodId = fm.id JOIN cust_login AS cl ON o.custId = cl.id where o.restId = :restId;";
  $stmt = $DB->prepare($sql);
  $stmt->bindValue(":restId", $_SESSION['userId']);
  $stmt->execute();
  $listedOrders = $stmt->fetchAll();
} catch (Exception $ex) {
  echo $ex->getMessage();
}
?>

<div class="container" style="min-height:120px;">
<h2 class="text-center"> Orders List </h2>
      <?php
      $x = 0;
      while ($listedOrders[$x]["id"]) {
        $tempOrder = $listedOrders[$x];
      ?>
        <div class="card col-sm-3">
          <div class="card-container">
            <h4><b>Order Number: <?php echo $tempOrder["id"] ?></b></h4>
            <h5><b><?php echo $tempOrder["food_type"] ?></b></h5>
            <p>Customer Id: <?php echo $tempOrder["custId"] ?></br>
              Customer Name: <?php echo $tempOrder["custName"] ?></br>
              Food Id: <?php echo $tempOrder["foodId"] ?></br>
              Food Name: <?php echo $tempOrder["foodName"] ?></p>
          </div>
        </div>
      <?php
        $x++;
      }
      ?>

  </div>
</div>
<br><br>

<?php include "footer.php" ?>