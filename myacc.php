<?php
session_start();
if(empty($_SESSION['idPlayer'])){
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
    }

    nav {
        background-color: black;
    }

    a {
        color: white;
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
                    <a class="nav-link" href="recommend.php" >Recommend</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="myacc.php"style="color:royalblue">MyAcc</a>
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
    <form action="myacc.php" method="POST">
        <?php
        $sql='SELECT * FROM players WHERE idPlayer='.$_SESSION['idPlayer'].'';
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if(mysqli_num_rows($result)>0){
            $line=mysqli_fetch_assoc($result);
        }
        ?>
    <div class="card" style="width: 40rem;position:absolute;left:35%;top:10%;margin-bottom:1rem">
    <h2>My account</h2>
        <img src="uploads/<?php echo $line['image']?>" class="card-img-top" alt="..." style="" >
        <div class="card-body">
            <h5 class="card-title">Name</h5>
            <p class="card-text"><?php echo $line['nom']?></p>
            <h5 class="card-title">Last name</h5>
            <p class="card-text"><?php echo $line['prenom']?></p>
            <h5 class="card-title">Email</h5>
            <p class="card-text"><?php echo $line['email']?>.</p>
            <h5 class="card-title">Phone Number</h5>
            <p class="card-text"><?php echo $line['tel']?>.</p>
            <a href="update.php" class="btn btn-primary">Update</a>
        </div>
    </div>
</form>
</body>

</html>
<?php }?>
