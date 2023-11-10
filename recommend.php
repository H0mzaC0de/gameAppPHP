<?php
session_start();
if(empty($_SESSION['idPlayer'])){
    header('location:connexion.php');
}
$conn=mysqli_connect('test','test','test','test') or die(mysqli_error($conn));
if($conn){
    $reponse='';
if(isset($_POST['submit'])){
    if(!empty($_POST['rec'])){
        $rec=mysqli_real_escape_string($conn,$_POST['rec']);
        $idPlayer=$_SESSION['idPlayer'];
        $sql="INSERT INTO recommendation (idPlayer,rec) VALUES ('$idPlayer','$rec')";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if($result>0){
            $reponse='  <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> Message sent
                      </div>';
        }else{
            $reponse='  <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Danger!</strong> Error.
                      </div>';
        }
    }else{
        $reponse='  <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Danger!</strong> Write a message first.
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
    <title>Recommend</title>
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
                    <a class="nav-link" href="intro.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="menu.php" >Menus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="recommend.php" style="color:royalblue">Recommend</a>
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
    <form action="recommend.php" method="POST">
        
<div class="container register-form" style="margin-top: 1rem;"><h2>Send a feedback</h2>
            <div class="form">
                <div class="note">
                    <p>We are listening to your recommendations.</p>
                </div>

                <div class="form-content">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                               <textarea name="rec" id="" cols="30" rows="10" class="form-control" placeholder="Leave a recommendation"></textarea>
                            </div>
                         
                        </div>
                    </div>
                    <input type="submit" name="submit" id="" value="Send!"class="btnSubmit">
                </div>
            </div>
        </div>
        <?php echo $reponse?>
    </form>
</body>
</html>
<?php }?>
