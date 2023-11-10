<?php
session_start();
if(empty($_SESSION['idPlayer'])){
    header('location:connexion.php');
}
$conn=mysqli_connect('test','test','test','test') or die(mysqli_error($conn));
if($conn){
    $reponse='';
if(isset($_POST['submit'])){
        $nom=mysqli_real_escape_string($conn,$_POST['nom']);
        $prenom=mysqli_real_escape_string($conn,$_POST['prenom']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $tel=mysqli_real_escape_string($conn,$_POST['tel']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        $passwordCheck=mysqli_real_escape_string($conn,$_POST['passwordCheck']);
        $img_name=$_FILES['image']['name'];
        $img_size=$_FILES['image']['size'];
        $img_error=$_FILES['image']['error'];
        $tmp_name=$_FILES['image']['tmp_name'];
        if($_SESSION['nom']!=$nom){
            $sql="UPDATE players SET nom='$nom' where idPlayer=".$_SESSION['idPlayer']."";
            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if(mysqli_affected_rows($conn)>0){
                header('loaction:myacc.php');
            }else{
                $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> Error.
                          </div>';
            }
        }if($_SESSION['prenom']!=$prenom){
            $sql="UPDATE players SET prenom='$prenom' where idPlayer=".$_SESSION['idPlayer']."";
            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if(mysqli_affected_rows($conn)>0){
                header('loaction:myacc.php');
            }else{
                $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> Error.
                          </div>';
            }
        }if($_SESSION['email'] != $email){
            $sql="UPDATE players SET email='$email' where idPlayer=".$_SESSION['idPlayer']."";
            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if(mysqli_affected_rows($conn)>0){
                header('loaction:myacc.php');
            }else{
                $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> Error.
                          </div>';
            }
        }if($_SESSION['tel'] != $tel){
            $sql="UPDATE players SET tel='$tel' where idPlayer=".$_SESSION['idPlayer']."";
            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if(mysqli_affected_rows($conn)>0){
                header('loaction:myacc.php');
            }else{
                $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> Error.
                          </div>';
            }
        }if($_SESSION['password'] != $password){
            if($password==$passwordCheck){
                $sql="UPDATE players SET password='$password' where idPlayer=".$_SESSION['idPlayer']."";
                $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                if(mysqli_affected_rows($conn)>0){
                    header('loaction:myacc.php');
                }else{
                    $reponse='<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Danger!</strong> Error.
                              </div>';
                }
            }
        }if($_SESSION['image']!=$img_name){
            if($img_error===0){
                if($img_size<1250000){
                    $img_ex=pathinfo($img_name,PATHINFO_EXTENSION);
                    $img_ex_lc=strtolower($img_ex);
                    $allowed_exs=array('jpg','jpeg','png');
                    if(in_array($img_ex_lc,$allowed_exs)){
                        $new_img_name=uniqid("IMG-",true).'.'.$img_ex_lc;
                        $path="uploads/".$new_img_name;
                        move_uploaded_file($tmp_name,$path);
                        $sql="UPDATE players SET image='$new_img_name' where idPlayer=".$_SESSION['idPlayer']."";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        if(mysqli_affected_rows($conn)>0){
                            header('loaction:myacc.php');
                        }else{
                            $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> There was an error.
                          </div>';
                        }
                    }else{
                        $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> Unsupported extension.
                          </div>';
                    }
                }else{
                    $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> File Too Big.
                          </div>';
                }
            }else{
                $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> There was an error Uploading.
                          </div>';
            }
    
        }
   /* if(!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['email']) and !empty($_POST['tel']) and !empty($_FILES['image']) and !empty($_POST['password']) and !empty($_POST['passwordCheck'])){
        
    
        if($password==$passwordCheck){
            if($img_error===0){
                if($img_size<1250000){
                    $img_ex=pathinfo($img_name,PATHINFO_EXTENSION);
                    $img_ex_lc=strtolower($img_ex);
                    $allowed_exs=array('jpg','jpeg','png');
                    if(in_array($img_ex_lc,$allowed_exs)){
                        $new_img_name=uniqid("IMG-",true).'.'.$img_ex_lc;
                        $path="uploads/".$new_img_name;
                        move_uploaded_file($tmp_name,$path);
                        $sql="INSERT INTO players (nom,prenom,password,email,tel,image) VALUES ('$nom','$prenom','$password','$email','$tel','$new_img_name')";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        if($result>0){
                            $reponse='  <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong> Player '.$nom.' Has been signe up.
                          </div>';
                        }else{
                            $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> There was an error.
                          </div>';
                        }
                    }else{
                        $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> Unsupported extension.
                          </div>';
                    }
                }else{
                    $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> File Too Big.
                          </div>';
                }
            }else{
                $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> There was an error Uploading.
                          </div>';
            }
    
        }else{
            $reponse='  <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> Unmatched passwords.
                          </div>';
        }
    
    }else{
        $reponse='  <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Danger!</strong> Fill all the fields.
      </div>';
    }*/
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>

</style>
<body>
    
<div class="container">
  <h2>Update Account</h2>
  <form action="update.php" method="POST" enctype="multipart/form-data">
      <?php


          $sql="SELECT * FROM players where idPlayer=".$_SESSION['idPlayer']."";
          $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

            $line=mysqli_fetch_assoc($result);
            $_SESSION['idPlayer']=$line['idPlayer'];
            $_SESSION['nom']=$line['nom'];
            $_SESSION['prenom']=$line['prenom'];
            $_SESSION['email']=$line['email'];
            $_SESSION['tel']=$line['tel'];
            $_SESSION['image']=$line['image'];
            $_SESSION['password']=$line['password'];

      
      ?>
    <div class="form-group">
      <label for="email">Name:</label>
      <input type="text" class="form-control" id="email"  name="nom" value="<?php echo $line['nom']?>">
    </div>
    <div class="form-group">
      <label for="pwd">Last Name:</label>
      <input type="text" class="form-control" id="pwd"  name="prenom" value="<?php echo $line['prenom']?>">
    </div>
     <div class="form-group">
      <label for="pwd">Email:</label>
      <input type="email" class="form-control" id="pwd"  name="email" value="<?php echo $line['email']?>">
    </div>
     <div class="form-group">
      <label for="pwd">Phone number:</label>
      <input type="number" class="form-control" id="pwd"  name="tel" value="<?php echo $line['tel']?>">
    </div>
      <div class="form-group">
      <label for="pwd">New Password?</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
    </div>
       <div class="form-group">
      <label for="pwd">Confirm the new Password</label>
      <input type="password" class="form-control" id="pwd" placeholder="Confirm the new password" name="passwordCheck">
    </div>
       <div class="form-group">
      <label for="pwd">Change your profile Picture</label>
      <input type="file" class="form-control" id="pwd"  name="image">
    </div>
    
    <input type="submit"  class="btn btn-primary" name="submit" value="submit">
    <?php echo $reponse;?>
  </form>
</div>
</body>
</html>
<?php }?>
