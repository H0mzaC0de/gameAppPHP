<?php
session_start();
if(isset($_GET['logout'])){
    session_destroy();
    session_unset();
    header('location:connexion.php');
}
$conn=mysqli_connect('test','test','test','test') or die(mysqli_error($conn));
if($conn){
    $reponse='';
if(isset($_POST['submit'])){
    if(!empty($_POST['email']) and !empty($_POST['password'])){
        $email=$_POST['email'];
        $password=$_POST['password'];
        $sql="SELECT * FROM players WHERE email='$email' and password='$password'";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if(mysqli_num_rows($result)>0){
            $line=mysqli_fetch_assoc($result);
           $_SESSION['idPlayer']=$line['idPlayer'];
           $_SESSION['nom']=$line['nom'];
           header('location:intro.php');
        }else{
            $reponse='  <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Danger!</strong> Login or password is incorrect.
                      </div>';
        }
    }else{
        $reponse='  <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Warning!</strong> Fill all the fields.
                      </div>';
    }
}


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
    body{
        font-family: 'Heebo', sans-serif;
    }
    nav{
        background-color: black;
    }
    a{
        color:white;
    }
    .note
{
    text-align: center;
    height: 80px;
    background: -webkit-linear-gradient(left, #0072ff, #8811c5);
    color: #fff;
    font-weight: bold;
    line-height: 80px;
}
.form-content
{
    padding: 5%;
    border: 1px solid #ced4da;
    margin-bottom: 2%;
}
.form-control{
    border-radius:1.5rem;
}
.btnSubmit
{
    border:none;
    border-radius:1.5rem;
    padding: 1%;
    width: 20%;
    cursor: pointer;
    background: #0062cc;
    color: #fff;
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
                    <a class="nav-link" href="inscription.php">SignUp</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php" style="color:royalblue">Login</a>
                </li>

            </ul>
        </div>
    </nav>
<form action="connexion.php" method="POST">
<div class="container register-form" style="margin-top: 1rem;">
            <div class="form">
                <div class="note">
                    <p>SignUp Big Boi.</p>
                </div>

                <div class="form-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Your Email *" value="" name="email" autocomplete="off"/>
                            </div>
                  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Your Password *" value="" name="password"/>
                            </div>
                         
                        </div>
                    </div>
                    <input type="submit" name="submit" id="" value="Connect!"class="btnSubmit">
                </div>
            </div>
        </div>
        <?php echo $reponse?>
    </form>
</body>
</html>
<?php }?>
