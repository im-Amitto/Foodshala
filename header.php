<?php
session_start();

if ($_GET["log"] == 1) {
    session_destroy();
    redirect("index.php");
}

function redirect($url)
{
    ob_start();
    header('Location: ' . $url);
    ob_end_flush();
    die();
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<html lang='en'>

<head>
    <!--=======================Basic========================-->
    <title>Foodshala - Your food corner</title>
    <meta charset='utf-8'>
    <meta name='keywords' content='HTML,CSS,JAVASCRIPT,BOOTSTRAP'>
    <meta name='author' content='Amit Meena'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='shortcut icon' href='./img/logo.png'>
    <!--=====================CSS============================-->
    <link rel='stylesheet' href='./css/bootstrap.min.css'>
    <link rel='stylesheet' href='./css/style.css'>
    <script src='./js/modernizr.js'></script>
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            background: whitesmoke;
            transition: 0.3s;
            border-radius: 5px;
            margin: 5px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .card-container {
            padding: 10px 20px;
        }
    </style>
    <!--=================Social Logo============================-->
    <link rel='stylesheet' href='./css/font-awesome.min.css'>
</head>
<!--=================Return To Top============================-->
<a id='return-to-top'><i class='glyphicon glyphicon-chevron-up'></i></a>

<body>
    <!--=================Head============================-->
    <div class='container-fluid head'>
        <div class='container head-top-mg'>
            <a href='index.php'>
                <img src='./img/logo.png' class='head-logo' height='56' />
            </a>
            <h4 class='head-link'>
                <a class='ltc-black' href='index.php'>FoodShala
                </a>
                <br />
            </h4>
            <h5 class='head-link mg-clear'>
                <a href='/' target='_blank'>Your Food Corner
                </a><br />
            </h5>
        </div>
    </div>
    <!--=================NavBar============================-->
    <nav class='navbar navbar-default'>
        <div class='container'>
            <div class='navbar-header'>
                <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#Navbar'>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
            </div>
            <div class='collapse navbar-collapse' id='Navbar'>
                <ul class='nav navbar-nav navbar-left'>
                    <li><a href='index.php'>Home</a></li>
                    <li><a href='menu.php'>Menu</a></li>
                    <?php if (isset($_SESSION["userType"]) && $_SESSION["userType"] == "rest") {
                    ?>
                        <li><a href='editMenu.php'>Manage Restaurant</a></li>
                        <li><a href='viewOrders.php'>View Orders</a></li>
                    <?php } ?>
                </ul>
                <ul class='nav navbar-nav navbar-right'>
                    <?php if ($_SESSION["userType"] != "rest") {
                    ?>
                        <li><a href='restLogin.php'><span class='glyphicon glyphicon-user'></span> Restaurant Login</a></li>
                    <?php }
                    if ($_SESSION["userType"] != "cust") {
                    ?>
                        <li><a href='custLogin.php'><span class='glyphicon glyphicon-log-in'></span> Customer Login</a></li>
                    <?php }
                    if (isset($_SESSION["email"]) && isset($_SESSION["userType"])) { ?>
                        <li><a href='?log=1'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>