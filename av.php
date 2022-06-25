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
    <title>Document</title>
</head>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap');
    body{
        display:flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

    }
    #frame{
        width:300px;
        height:500px;
        border: black 1px solid;
        position:relative;
        overflow: hidden;
        transition: 0.5s ease-in-out;
    }
    #cube{
        position:absolute;
        width:100px;
        height: 100px;
        background-color: red;
        bottom:0;
        left:100px;
        right:100px;
        
    }
    #block{
        width:100px;
        height:100px;
        background-color: darkslategrey;
        position: absolute;
        animation: slide 1s infinite linear;
    }
    @keyframes slide {
        0%{top:0px;}
        50%{top:200px;}
        100%{top:500px}

        
    }
    .popup{
        /*display:flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;*/
        width:500px;
        height: 200px;
        background: linear-gradient(gold,rgb(255, 96, 96));
        position: absolute;
        border: rgb(41, 41, 41) 1px solid;
        display:none;
        
    }
    .button{
        position:absolute;
        width:60px;
        height:40px;
        font-family: Montserrat;
        color:black;
        background-color: whitesmoke;
        transition:0.3s ease;
        cursor: pointer;
        border:none;
        bottom:5px;
        left:210px;
    }
    .button:hover{
        background-color: black;
        color:whitesmoke;
    }
    .text{
        position:absolute;
        top:50px;
        left:30px;
        font-family: Montserrat;
        font-size: 30px;
        color:snow;
    }
    .score{
        position:absolute;
        top:100px;
        left:230px;
        font-weight: bold;
        font-family: Montserrat;
        font-size: 40px;
        color:snow;
    }
    #dark{
        position: absolute;
        right:0;
        top:10px;
        width:70px;
        height:70px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
        border-radius: 50%;
        background-color: white;

    }
    #dark:hover{
        width:100px;
        height:100px;

    }
    #body{
        transition: 0.5s ease-in-out;

    }

</style>

<body id="body">
    <div id="frame">
        <div id="cube">

        </div>
        <div id="block">

        </div>
    </div>
    <div class="popup">
        <span class="text">
            You have Lost :( Your score is:
        </span>
        <span class="score" >

        </span>
        <button class="button" onclick="send();">
            Try Again!
        </button>
    </div>
    <img src="img/darkmode.png" alt="Dark Mode" id="dark" onclick="dark();" title="Dark Mode">
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    var cube=document.querySelector("#cube");
    var block=document.querySelector("#block");
    var frame=document.querySelector("#frame");
    var popup=document.querySelector(".popup");
    var score=document.querySelector(".score");
    var body=document.getElementById('body');
    var btn=document.querySelector(".button");
    var count=0;

   

    block.addEventListener('animationiteration', () => {
    var random = Math.floor(Math.random() * 3);
    left = random * 100;
    block.style.left = left + "px";
    count++;
    
    });

    
    document.addEventListener("keydown" ,event=>{
        if(event.key==="ArrowRight"){
            mright();
        }
        if(event.key==="ArrowLeft"){
            mleft();
        }
        if(event.key==="D" || event.key==="d"){
            dark();
        }

    })

    function mright(){
        var left=parseInt(window.getComputedStyle(cube).getPropertyValue("left"));
        left+=100;
        if(left<300){
        
        cube.style.left=left+"px";
    }
    }


    function mleft(){
        var left=parseInt(window.getComputedStyle(cube).getPropertyValue("left"));
        left-=100;
        if(left>=0){
        
        cube.style.left=left+"px";
    } }


    setInterval(function(){
    var characterLeft = parseInt(window.getComputedStyle(cube).getPropertyValue("left"));
    var blockLeft = parseInt(window.getComputedStyle(block).getPropertyValue("left"));
    var blockTop = parseInt(window.getComputedStyle(block).getPropertyValue("top"));
    if(characterLeft==blockLeft && blockTop>300 && blockTop<500){
        block.style.animation="none";
        score.innerHTML=count;
        //body.style.filter="brightness(40%)";
        $(document).ready(function(){
            $(".popup").fadeIn(1000);
        });

    }

    },10)


    function send(){
        window.location.reload();
    }
    function dark(){
        body.style.backgroundColor="#181818";
        frame.style="border:1px solid white";
    }

   



    /*var cube=document.querySelector("#cube");
    document.onkeydown = checkKey;

function checkKey(e) {

    To clarify, 'e || window.event' means that if 'e' is a defined value, it will be the result of 
    the '||' expression. If 'e' is not defined, 'window.event' will be the result of the '||' expression.
     So it's basically shorthand for: e = e ? e : window.event; Or: if (typeof(e) === "undefined") 
     { e = window.event; } 
    e = e || window.event;

    if (e.keyCode == '38') {
        //up
        //alert(e.keyCode)
        cube.style.top="250px";
    }
    else if (e.keyCode == '40') {
        // down arrow
        cube.style.bottom="0"

    }
    else if (e.keyCode == '37') {
       // left arrow
       cube.style.left="200px";
       if(cube.style.left=="200px"){
           cube.style.left="100px;"
       }
    }
    else if (e.keyCode == '39') {
       // right arrow
       
       cube.style.right="200px";
    }

}*/
</script>
</html>