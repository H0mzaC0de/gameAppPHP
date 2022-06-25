<?php
session_start();
if(empty($_SESSION['idPlayer'])){
    header('location:connexion.php');
}
?>
<!doctype html>
<html>
<head>
	<title> REMEMEBER GAME </title>
</head>
<style >
div#memory_board{
	background: #ccc;
	border:#999 1pxsolid;
	width:800px;
	height: 540px;
	padding:24px;
	margin:0px auto;
}
/* programming of our game is going to be a lot of litttle divs that are gonna represents the cards that are gonna be dynamically placed into this memry board so haka ghandiro liha f upcoming lines so all we have to do is put ONE MORE STYLE RULE FOR ALL THE DYNAMIC little divs that are going to be placed into the memory board so we target the div the idea of the meomory board and we specify this rule to target all the little divs within the MEMORY BOARD  */
div#memory_board > div{
	background: url(images/vide.png) no-repeat;
	border: #000 1px solid;
	width:71px;
	height: 71px;
	float:left;
	margin:10px;
	padding:20px;
	font-size: 64px;
	cursor:pointer;
	text-align: center;
}

</style>
<script >
var moves=0;
var memory_array=['A','A','B','B','C','C','D','D','E','E','F','F','G','G','H','H','I','I','J','J','K','K','L','L'];
/*EACH ELEMENT IN THIS ARRAY REPRESENTS THE CONTENT THATS GONNA BE HIDING UNDER EACH CARD BASICALLY THIS ARRAY IS USED IN JAVASCRIPT 
TO DYNAMICALLY ALL THE CARDS*/
var memory_values=[];
/*an other empty array and thats for storing the memory values */
var memory_tiles_ids=[];
/*another empty array that stores memory tiles ids*/
var tiles_flipped=0;
/*and then we have a variable for tiles flipped thats just for keeping track od how many tiles are flipped */

/*NOW THE NEXT THING WE GONNA ADD A SHUFFLE METHOD TO THE ARRAY OBJECT IN JAVASCRIPT bcz by default arrays in javascript have no shuffle
 methos that you caan usually access  */
Array.prototype.memory_tile_shuffle=function(){
	var i=this.length,j,temp;
	while(--i>0){
		j=Math.floor(Math.random()*(i+1));
		temp=this[j];
		this[j]=this[i];
		this[i]=temp;

	}
}
/*TO GENERATE A NEW BOARD*/

function newBoard(){
	tiles_flipped=0;/*each time a new board is generated tilesflipped is back to 0*/
	var output='';
	/*memory array hia li eandna lfoqo derna liha l memory_tiles_shuffle on it bach bhala tdmess bhala creana method rassna bach 
	ndemsso biha cards randomly*/
	 memory_array.memory_tile_shuffle();
	for(var i = 0; i < memory_array.length; i++){
		output += '<div id="tile_'+i+'" onclick="memoryFlipTile(this,\''+memory_array[i]+'\')"></div>';
		/*had div lfoq ra hia little dives representing those cards each little div gets an ID of a dynamic tile number hadik
		 onclick memoryfliptile hadik hia fonction responsible for flipping the tiles over o ghansifto meaha two arguments "this"
		  whixh going to represent whichever div is being accessed so our memory flip tile function will access to this calling 
		  object and the next argument howa the data for each of the cards*/
	}
	document.getElementById('memory_board').innerHTML = output;
}
/*tile=card id val=value dyalha f dak array*/
/*tile.innerHTML=="" zaema baqi mabanch */
function memoryFlipTile(tile,val){
	if(tile.innerHTML==""&&memory_values.length<2){
	/*db hadil fff fach ghatqlb hadak lherf background dyalo ghayweli white value dyalo hadak harf hta howa ghayban f html*/
	tile.style.background='#fff';
	tile.innerHTML=val;
	/*if it is 0 hit hia ghatbda b 0  by default hadakchi li clickina eliha kola mera kaytpusha wahed into the memory values array 
	for the card that the person is clicking then in the memory tile ids array we pudh the tiles id or the cards id the one that the
	 user is clicking so that way our memory values array on our memory tile ids array both have values that represent the cards that 
	 the user clicking */
	if(memory_values.length==0){
		memory_values.push(val);
		memory_tiles_ids.push(tile.id);
	/*memory_values.length==1 that means if already there is one card flipped over and the user is clicking a second one then
	 ghanakhdo infos dyal secon card */
	}else if(memory_values.length==1){
		memory_values.push(val);
		memory_tiles_ids.push(tile.id);
		/*this condition is to see if the both cards are a match so we gonna plus 2 on the tiles flipped variale bcz 
		we know we have a match so those tiles are gonna stay flipped over  */
		if(memory_values[0]==memory_values[1]){
			tiles_flipped+=2;
			moves+=1;
			//clear both arrays and get them ready for a new matching sequence 
			memory_values=[];
			memory_tiles_ids=[];
			//check to see if the whole board is cleared 
			if(tiles_flipped==memory_array.length){
				alert("BOARD CLEARD...GENERATING A NEW BOARD \n YOUR MOVES : "+moves);
				document.getElementById("memory_board").innerHTML="";
				/*clear the memory board in the html completely */
				newBoard();
			}
		}
		else{
			/*this else condition is for if the match isnt made o hia dyal if lwla li fiha wach match kayn */
			function flip2Back(){
				//flip the tw tiles back
				var tile_1=document.getElementById(memory_tiles_ids[0]);
				var tile_2=document.getElementById(memory_tiles_ids[1]);
				tile_1.style.background='url(images/vide.png) no-repeat';
				tile_1.innerHTML="";
				tile_2.style.background='url(images/vide.png) no-repeat';
				tile_2.innerHTML="";
				//clear both arrays 
				memory_values=[];
				memory_tiles_ids=[];
			}
			setTimeout(flip2Back,700);
		}









			}
		}
	}








</script>
<body>
<div id="memory_board"></div>
<script>newBoard();</script>
<!--this line bhaala kateawed gae dok dives -->










</body>
</html>