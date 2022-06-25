<?php
session_start();
if(empty($_SESSION['idPlayer'])){
    header('location:connexion.php');
}
// $conn=mysqli_connect('localhost','root','','games') or die(mysqli_error($conn));
// if($conn){
//     $reponse='';
// if(isset($_POST['addComment'])){
//     $comment=$_POST['comment'];
//     $sql="INSERT INTO comments (idPlayer,comment) VALUES (".$_SESSION['idPlayer'].",'$comment')";
//     $result=mysqli_query($conn,$sql);
//     if($result>0){
//         $reponse='<span> Comment added</span>';
//     }else{
//         $reponse='<span> No</span>';
//     }
// }

$host='localhost';
$user='root';
$password='';
$dbname='games';
try{
   $dsn='mysql:host='.$host.';dbname='.$dbname;
    $pdo=new PDO($dsn,$user,$password); 
    $reponse='';
}catch(PDOException $exception){
    exit('Failed to connect to database');
}


$sqlNumComments="SELECT id from comments";
$stmt=$pdo->prepare($sqlNumComments);
$stmt->execute();
$numberComments=$stmt->rowCount();
function createCommentRow($data){
    global $pdo;
    $response = '
      <div class="comment" style="margin:1rem;position:relative;padding-top:10px">
      <img src="uploads/'.$data['image'].'" alt="" class="rounded-circle" width="40" height="40" style="position:absolute;top:7px">
          <div class="user" ><span style="font-size:1.5rem;margin-left:3rem;color:#5C5C5C">'.$data['nom'].'</span><span class="time" style="margin-left:10px;font-size:0.9rem;color:#778899">'.$data['createdOn'].'</span></div>
          <div class="userComment" style="font-weight:normal;margin-top:0.2rem;margin-left:1rem;margin-top:0.2rem;color:#8A8A8A">'.$data['comment'].'</div>
          <div class="reply"><a href="javascript:void(0)" data-commentID="'.$data['id'].'" onclick="reply(this);" style="color:blue;font-size="0.5rem"">REPLY</a></div>
          <div class="replies" style="margin-left:40px">';
          $stmt2=$pdo->query("SELECT replies.id,players.nom,replies.comment,replies.createdOn,players.image
          from players,replies
          where players.idPlayer=replies.userID
          AND replies.commentID='".$data['id']."'
            ORDER BY replies.id DESC LIMIT 1"); 
            while($dataR=$stmt2->fetch(PDO::FETCH_ASSOC))
            $response .= createCommentRow($dataR);
         $response.=' </div>
      </div>
      <hr>';
      return $response;
    
}
// <!--<div class="comment">
// <img src="uploads/'.$data['image'].'" alt="" class="rounded-circle" width="40" height="40" style="position:absolute;top:7px">
//     <div class="user" >'.$data['nom'].'<span class="time" style="margin-left:10px;font-size:0.9rem">'.$data['createdOn'].'</span></div>
//     <div class="userComment" >'.$data['comment'].'</div>
// </div>-->
if(isset($_POST['getAllComments'])){
    $start=$_POST['start'];
    $response="";
 $stmt=$pdo->query("SELECT comments.id,players.nom,comments.comment,comments.createdOn,players.image
 from players,comments
 where players.idPlayer=comments.idPlayer
   ORDER BY comments.id DESC LIMIT $start, 20"); 
  while($data=$stmt->fetch(PDO::FETCH_ASSOC))
    $response .= createCommentRow($data);
    exit($response);
}
if(isset($_POST['addComment'])){
    $comment=$_POST['comment'];
    $isReply=$_POST['isReply'];
    $commentID=$_POST['commentID'];
    if($isReply){
        $sql="INSERT INTO replies (userID,comment,commentID) VALUES (:userID,:comment,:commentID)";
        $stmt=$pdo->prepare($sql);
        $stmt->execute(['userID'=>$_SESSION['idPlayer'],'comment'=>$comment,'commentID'=>$commentID]);
        $stmt2=$pdo->query("SELECT replies.id,players.nom,replies.comment,replies.createdOn,players.image
 from players,replies
 where players.idPlayer=replies.userID
   ORDER BY replies.id DESC LIMIT 1"); 
    }else{
    $sql="INSERT INTO comments (idPlayer,comment) VALUES (:idPlayer,:comment)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(['idPlayer'=>$_SESSION['idPlayer'],'comment'=>$comment]);
    $stmt2=$pdo->query("SELECT comments.id,players.nom,comments.comment,comments.createdOn,players.image
 from players,comments
 where players.idPlayer=comments.idPlayer
   ORDER BY comments.id DESC LIMIT 1"); 
    }
    
   $data=$stmt2->fetch(PDO::FETCH_ASSOC);
    exit(createCommentRow($data));

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games Menu</title>
    
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
    body {
    background-color: #eee
}

.bdge {
    height: 21px;
    background-color: orange;
    color: #fff;
    font-size: 11px;
    padding: 8px;
    border-radius: 4px;
    line-height: 3px
}

.comments {
    text-decoration: underline;
    text-underline-position: under;
    cursor: pointer
}

.dot {
    height: 7px;
    width: 7px;
    margin-top: 3px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block
}

.hit-voting:hover {
    color: blue
}

.hit-voting {
    cursor: pointer
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
                    <a class="nav-link" href="menu.php" style="color:royalblue">Menus</a>
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

    <div class="container" style="color: white;position:absolute;left:50%;top:50%;transform: translate(-50%, -50%);display:flex;flex:1;">
        <div class="card" style="width: 18rem;margin:1rem">
            <img class="card-img-top" src="img/ref.jpg" alt="Card image cap">
            <div class="card-body">
                <p class="card-text" style="color: black;">Do you want to put your reflexes to a test?</p>
                <a href="ref.php"class="btn btn-info">Play</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;margin:1rem">
            <img class="card-img-top" src="img/bl.jfif" alt="Card image cap">
            <div class="card-body">
                <p class="card-text" style="color: black;">Avoid Cubes lol :).</p>
                <a href="av.php"class="btn btn-info">Play</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;margin:1rem">
            <img class="card-img-top" src="img/rem.png" alt="Card image cap">
            <div class="card-body">
                <p class="card-text" style="color: black;">Remeber games. Test your amegdela.</p>
                <a href="rem.php"class="btn btn-info">Play</a>
            </div>
        </div>

    
    </div> 
    
  <div class="container" style="position: absolute; top:90%;left:20%">

  <div class="form-group">
    <textarea class="form-control"   placeholder="Enter Comment" id="mainComment"></textarea>
    <input type="submit"  class="btn btn-primary" value="submit" id="addComment" onclick="isReply=false;">
  </div>

  <h2 id="numComments" style="color:white;position:absolute;left:40%;top:80px;background-color:black;"><?php echo ''.$numberComments.' '?>Comments</h2>
   <div class="userComment" id="userComment" style="width:100%;background-color:white;border-radius:25px;position:relative">
 
            

  </div> 
 
  </div>
  <div class="replyRow"style="display: none;">
  <div class="form-group" >
    <textarea class="form-control"   placeholder="Enter Reply" id="replyComment"></textarea>
    <input type="submit"  class="btn btn-primary" value="submit" onclick="isReply=true;" id="addReply">
    <input type="submit"  class="btn btn-primary" value="Close" onclick="$('.replyRow').hide();">
  </div>
</div>
    <script src="js/jquery-3.6.0.js"></script>
  <script>
      var max= <?php echo $numberComments?>;
      var isReply=false;
      var commentID=0;
      $(document).ready(function(){
          $("#addComment ,#addReply").on('click',function(){
               var comment;
               if(!isReply){
                    comment=$("#mainComment").val();
               }else{
                   comment=$('#replyComment').val();
               }
               
          if(comment.length>2){
              $.ajax({
                  url:'menu.php',
                  method:'POST',
                  dataType:'text',
                  data:{
                      addComment:1,
                      comment:comment,
                      isReply:isReply,//true or false
                       commentID:commentID
                  }, success: function(response){
                      max++;
                      $('#numComments').text(max+" Comments");
                      if(!isReply){
                        $('#userComment').prepend(response);
                        $('#mainComment').val("");
                      }else{
                          commentID=0;
                        $('#replyComment').val("");
                        $('.replyRow').hide();
                        $('.replyRow').parent().next().append(response);
                      }
                      
                       
                  }
              })
          }else{
              alert("Please check Your Input or comment should be less than 5 characters")
          }
          });
         getAllComments(0,max);
      });
      function reply(caller){
          commentID=$(caller).attr('data-commentID');
        $('.replyRow').insertAfter($(caller));
        $('.replyRow').show();
      }
      function getAllComments(start,max){
          
        if(start>max){
            return;
        }
        $.ajax({
            url:'menu.php',
            method:'POST',
            dataType:'text',
            data:{
                getAllComments:1,
                start:start
            },success: function(response){
                $("#userComment").append(response);
                getAllComments((start=20),max);
                console.log(response);
            }

        });
      }
  </script>

</body>

</html>


<?php //} ?>