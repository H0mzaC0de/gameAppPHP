<?php
session_start();
if(empty($_SESSION['idPlayer'])){
    header('location:connexion.php');
}
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'games';
try {
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
    $pdo = new PDO($dsn, $user, $password);
    $reponse = '';
} catch (PDOException $exception) {
    exit('Failed to connect to database');
}

$sqlNumMessages="SELECT idMessage from messages";
$stmt=$pdo->prepare($sqlNumMessages);
$stmt->execute();
$numberMessages=$stmt->rowCount();
function createMessageRow($data){
    return '
      <div class="comment" style="margin:1rem;position:relative;padding-top:10px; ">
      <img src="uploads/'.$data['image'].'" alt="" class="rounded-circle" width="40" height="40" style="position:absolute;top:7px">
          <div class="user" ><span style="font-size:1.5rem;margin-left:3rem;color:white"><a href="specificPlayer.php?id='.$data['idPlayer'].'">'.$data['nom'].'</a></span><span class="time" style="margin-left:10px;font-size:0.9rem;color:#778899">'.$data['createdOn'].'</span></div>
          <div class="userComment" style="font-weight:normal;margin-top:0.2rem;margin-left:1rem;margin-top:0.2rem;color:white">'.$data['message'].'</div>
         
      </div>
      <hr>
    ' ;
}

if(isset($_POST['getAllMessages'])){
    $start=$_POST['start'];
    $response="";
 $stmt=$pdo->query("SELECT messages.idPlayer,players.nom,messages.message,messages.createdOn,players.image
 from players,messages
 where players.idPlayer=messages.idPlayer
   ORDER BY messages.idMessage DESC LIMIT $start, 20"); 
  while($data=$stmt->fetch(PDO::FETCH_ASSOC))
    $response .= createMessageRow($data);
    exit($response);
}

if(isset($_POST['addMessage'])){
    $message=$_POST['message'];

    $sql="INSERT INTO messages (idPlayer,message) VALUES (:idPlayer,:message)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(['idPlayer'=>$_SESSION['idPlayer'],'message'=>$message]);
    $stmt2=$pdo->query("SELECT messages.idPlayer,players.nom,messages.message,messages.createdOn,players.image
 from players,messages
 where  players.idPlayer=messages.idPlayer
   ORDER BY messages.idMessage DESC LIMIT 1"); 
   $data=$stmt2->fetch(PDO::FETCH_ASSOC);
    exit(createMessageRow($data));

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>    @import url('https://fonts.googleapis.com/css2?family=Heebo:wght@500;600&family=Roboto:wght@300;400&display=swap');
    * {
        box-sizing: border-box;
    }



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
    min-height: 8vh;
}

a {
    color: white;
}

    .glow-on-hover {
    width: 220px;
    height: 50px;
    border: none;
    outline: none;
    color: #fff;
    background: #7289DA;
    cursor: pointer;
    position: absolute;
    bottom: 0;
    right:0;
    z-index: 0;
}

.glow-on-hover:before {
    content: '';
    background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
    position: absolute;
    bottom: -2px;
    left:-2px;
    background-size: 400%;
    z-index: -1;
    filter: blur(5px);
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    animation: glowing 20s linear infinite;
    opacity: 0;
    transition: opacity .3s ease-in-out;
    border-radius: 10px;
}

.glow-on-hover:active {
    color: #000
}

.glow-on-hover:active:after {
    background: transparent;
}

.glow-on-hover:hover:before {
    opacity: 1;
}

.glow-on-hover:after {
    z-index: -1;
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: #7289DA;
    left: 0;
    top: 0;
    border-radius: 10px;
}

@keyframes glowing {
    0% { background-position: 0 0; }
    50% { background-position: 400% 0; }
    100% { background-position: 0 0; }
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
                    <a class="nav-link" href="myacc.php">MyAcc</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="chat.php" style="color:royalblue">Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php?logout" >Logout</a>
                </li>
                <?php
                $sql="SELECT image FROM players WHERE idPlayer=".$_SESSION['idPlayer']."";
                $stmt=$pdo->query($sql);
                $line=$stmt->fetch(PDO::FETCH_ASSOC);
                echo'
                <li class="nav-item">
                <a class="nav-link" href="myacc.php" ><img src="uploads/'.$line['image'].'" class="rounded-circle" style="width:40px;height:40px"></a>
                <div style="position:absolute;width:10px;height:10px;border-radius:50%;background-color:green;right:25px;top:45px"></div>
            </li>'
                ?>

            </ul>
        </div>
    </nav>

<div class="container" style="background: #7289DA;;margin-bottom:-30px">
    <h2 style="text-align: center;color:white;">CHAT <?php echo '<span style="font-size:20px">('.$numberMessages.' Messages)</span>'?> </h2>
</div>
<div class="container" style="background-color:#2C2F33;height:92vh;margin-top:30px;position:relative;overflow:scroll">
<div class="userMessage" id="userMessage" style="width:100%;background-color:#2C2F33;border-radius:25px;position:relative">



        </div>

</div>
<div class="container" style="position: relative;">
<div class="form-group">
    <input type="text" class="form-control" id="mainMessage" placeholder="Type Your message" style="position:absolute;bottom:0;left:0;border-radius:0;
    width:81%;height:50px">
    <button class="glow-on-hover" type="submit" id="addMessage">SEND</button>
  </div>
</div>
<script src="js/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function(){
          $("#addMessage").on('click',function(){
               var message=$("#mainMessage").val();
          if(message!=''){
              $.ajax({
                async: true,
                  url:'chat.php',
                  method:'POST',
                  dataType:'text',
                  data:{
                      addMessage:1,
                      message:message,
                  }, success: function(response){
                      $('#mainMessage').val("");
                      $('#userMessage').prepend(response);
                       
                  }
              })
          }else{
              alert("Please check Your Input");
          }
          });
        getAllMessages(0,<?php echo $numberMessages?>);
      });
      function getAllMessages(start,max){
          
          if(start>max){
              return;
          }
          $.ajax({
            async: true,
              url:'chat.php',
              method:'POST',
              dataType:'text',
              data:{
                  getAllMessages:1,
                  start:start
              },success: function(response){
                  $("#userMessage").append(response);
                  getAllMessages((start=20),max);
                  console.log(response);
              }
  
          });
        }
</script>



</body>

</html>