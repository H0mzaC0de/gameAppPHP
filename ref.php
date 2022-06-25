<?php
session_start();
if(empty($_SESSION['idPlayer'])){
    header('location:connexion.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reflex Test</title>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        
    }
    body{
        margin-top: 100px;
        height:60vh;
        display: flex;
        background-color: rgb(51, 153, 255);
        align-items: center;
        flex-direction: column;
        justify-content: space-around;
        
    }
   .counter{
       
      color:whitesmoke;
      font-size: 100px;
      font-family: sans-serif;
      font-weight: normal;
    display:none;
        

   }
   .text{
       
       color:whitesmoke;
       font-size: 60px;
       font-family: sans-serif;
       font-weight: normal;
     
         
 
    }
    .button{
        margin: auto;
        width:100px;
        height: 60px;
        font-size: 30px;
        cursor: pointer;
        background-color:rgb(255, 173, 101);
        border: none;
        color:whitesmoke;
        font-family: sans-serif;
        margin-top: 10px;
    }
    .button:hover{
        background-color: rgb(185, 110, 44);
        color:black;
    }
    .button2{
        margin: auto;
        width:120px;
        height: 70px;
        font-size: 30px;
        cursor: pointer;
        background-color:rgb(248, 157, 78);
        border: none;
        color:whitesmoke;
        font-family: sans-serif;
        margin-top: 10px;
    }
    .button2:hover{
        background-color: rgb(185, 110, 44);
        color:black;
    }

</style>

<body id="body">
    <div >
        <h1 class="text"id="text">We will be testing your reflexes<br><strong>Are you Ready?</strong></h1></br>
        <input type="button" class="button" value="Yes!" id="ok" >
        <h1 id="number"class="counter">3</h1>
        
    </div>
    <div id="textscore"> 
        
    </div>
   

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var time=document.getElementById("number");
    var text=document.getElementById("text");
    var ok=document.getElementById("ok");
    var timer;
    var d= new Date();
    var body=document.getElementById("body");
    var score=document.getElementById("textscore");
    var called=false;
    var start;
    var end;
    var emoji = String.fromCodePoint( 0x1F60E);
    var emoji2 = String.fromCodePoint( 0x1F44B	);

   

     ok.addEventListener("click",function(){
         
            
        time.style.display="inline";
         ok.style.display="none";
        text.style.display="none";
        alert(emoji2+" \nTIP: Remember To Click As Fast As You Can When You See A Green Screen!! "+emoji2);
        timer=setInterval(counter,1000);
         
    })
    function counter(){
        if(time.innerText!=0){
            time.innerText--;
            $(document).ready(function(){
                
            $(time).fadeOut(200).fadeIn(500);
        });
        }if(time.innerText==0){
            clearInterval(timer);
            $(document).ready(function(){
                
                $(time).fadeOut(10);
            });
             var n=d.getSeconds();
            var yo=Math.floor(Math.random()*n);
            setTimeout(function(){
            appear();
            called=true;
            start=new Date();
            console.log(yo); 
            },yo*1000);
           
            body.addEventListener("click",myfunction);
            function myfunction(){
                if(called){
                body.removeEventListener('click', myfunction);
                end=new Date();
                var diff=end-start;
                var msi=diff;
                var ms=Math.floor(msi);
                var si=diff/1000;
                var s=Math.floor(si);
                
                alert("It Took You "+s+" seconds "+ms+" milliseconds");
                
                var p=document.createElement("p");
                p.classList.add("text");
                p.innerText=("It Took You "+s+" seconds "+ms+" milliseconds");
                score.appendChild(p);
                var b2=document.createElement("button");
                b2.classList.add("button2");
                b2.innerText=("Go Back");
                score.appendChild(b2);
                b2.addEventListener("click",reload);
                if(s<0&&ms<400){
                    alert("NOT BAD "+emoji);
                }
                }else{
                alert("Too early :( \n Refrech the page to play again!");
                var a=document.createElement("p");
                a.classList.add("text");
                a.innerText=("Too early :( \n click the button to play again!");
                score.appendChild(a);
                var b=document.createElement("button");
                b.classList.add("button2");
                b.innerText=("Go Back");
                score.appendChild(b);
                b.addEventListener("click",reload);
                body.removeEventListener('click', myfunction);

            }
        }
            
            
        
           
            
        }

    }
   
       
function appear(){
   body.style.backgroundImage= "linear-gradient(90deg,#3fff00,#3cb371)";
}
function reload(){
    window.location.reload();
}

                
 
    

</script>
</html>