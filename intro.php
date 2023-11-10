<?php
session_start();
if (empty($_SESSION['idPlayer'])) {
  header('location:connexion.php');
}
$conn=mysqli_connect('test','test','test','test') or die(mysqli_error($conn));
if($conn){


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Heebo:wght@500;600&family=Roboto:wght@300;400&display=swap');

  body {
    font-family: 'Heebo', sans-serif;
    background-image: url('img/blackhole.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    height: 100vh;

  }

  nav {
    background: transparent;
  }

  a {
    color: white;
  }

  .wrapper {
    position: absolute;
    top: 70%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .a {
    display: block;
    width: 200px;
    height: 40px;
    line-height: 40px;
    font-size: 18px;
    font-family: sans-serif;
    text-decoration: none;
    color: #333;
    border: 2px solid #333;
    letter-spacing: 2px;
    text-align: center;
    position: relative;
    transition: all .35s;
  }

  .a span {
    position: relative;
    z-index: 2;
  }

  .a:after {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: #ff003b;
    transition: all .35s;
  }

  .a:hover {
    color: #fff;
  }

  .a:hover:after {
    width: 100%;
  }
</style>

<body>

<nav class="navbar navbar-expand-sm">
        <a class="navbar-brand" href="#">H<sup>Games</sup></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" style="background-color: white;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="intro.php"style="color:royalblue">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="menu.php" >Menus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="recommend.php" >Recommend</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="myacc.php">MyAcc</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="chat.php" >Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php?logout" >Logout</a>
                </li>
                <?php
                $sql="SELECT image FROM players WHERE idPlayer=".$_SESSION['idPlayer']."";
               $result=mysqli_query($conn,$sql);
               $line=mysqli_fetch_assoc($result);
                echo'
                <li class="nav-item">
                <a class="nav-link" href="myacc.php" ><img src="uploads/'.$line['image'].'" class="rounded-circle" style="width:40px;height:40px"></a>
                <div style="position:absolute;width:10px;height:10px;border-radius:50%;background-color:green;right:25px;top:45px"></div>
            </li>'
                ?>

            </ul>
        </div>
    </nav>
  </nav>
  <div class="container" style="color: white;position:absolute;left:50%;top:50%;transform: translate(-50%, -50%);background-color: #1fd1f9;
background-image: linear-gradient(315deg, #1fd1f9 0%, #b621fe 74%);
;border-radius:30px;min-height:50vh">
    <h1 style="text-align: center;margin-top:10%">Welcome Dear Player To our lame games haha</h1><br>
    <div class="wrapper">
      <a href="menu.php" class="a"><span>Check it out!</span></a>
    </div>
  </div>



</body>

</html>
<?php }?>
