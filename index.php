<head>
  <!--=======================Basic========================-->
  <title>Foodshala - Your food corner</title>
  <meta charset='utf-8'>
  <meta name='keywords' content='HTML,CSS,JAVASCRIPT,BOOTSTRAP'>
  <meta name='author' content='Amit Meena'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link rel='shortcut icon' href='./img/logo.png'>
  <!--=======================CSS========================-->
  <link rel='stylesheet' href='./css/bootstrap.min.css'>
  <style>
    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      background: whitesmoke;
      transition: 0.3s;
      border-radius: 5px;
      margin: 5px;
    }

    .card-container {
      padding: 10px 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="card" style="margin: 15vh auto;width: 60vw;">
        <div class="card-container">
          <h1>Welcome to Foodshala,</h1>
          <h3 class="text-center">Continue your journey as</h3>
          <a href="/custLogin.php" class="btn btn-lg btn-primary">Customer</a>
          <a href="/restLogin.php" class="btn btn-lg btn-success" style="float: right">Restaurant</a>
        </div>
      </div>
    </div>
  </div>
</body>