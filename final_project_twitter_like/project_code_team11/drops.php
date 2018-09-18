<?php 
   session_start();
   error_reporting(0);
   $username = "root";
   $password = "";
   //$username = "id5403878_finalprojectroot";
   //$password = "12345";
   $shouldShowErrors = false;
   global $pdo;
   try {
       //$pdo = new PDO("mysql:host=localhost;dbname=id5403878_finalproject", $username, $password);
       $pdo = new PDO("mysql:host=localhost;dbname=cs3500_MessageDB", $username, $password);
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
   }
   catch (PDOException $e) {
       echo "Connection failed: " . $e->getMessage();
   }
   
   
   			$profilePicSql = 'SELECT PicturePath FROM `User` WHERE UID = '.$_SESSION['UID'];
   			$profilePicSqlRes = $pdo->query($profilePicSql);
   			$profilePicSqlRow = $profilePicSqlRes ->fetch();
   
   			$profilePath = $profilePicSqlRow['PicturePath'];
   
   
   
   if(!isset($_SESSION["UID"])){
   	$_SESSION['UID'] = 2;
   }
   
   
   /*then i heard the guy rap, trouble is his name, and i was like wow i love this song. i face timed mike will and was like wow this song, and he sent the instrumental and i was like */
   
   function printMessageWithHashTag($message) {
   	$username = "root";
   	$password = "";
   	//$username = "id5403878_finalprojectroot";
   	//$password = "12345";
   	$shouldShowErrors = false;
   	try {
   	    //$pdo = new PDO("mysql:host=localhost;dbname=id5403878_finalproject", $username, $password);
   	    $pdo = new PDO("mysql:host=localhost;dbname=cs3500_MessageDB", $username, $password);
   	    
   	}
   	catch (PDOException $e) {
   	    echo "Connection failed: " . $e->getMessage();
   	}
   	    $words = explode(" ", $message);
   	    for($i = 0;$i<count($words);$i++){
   	    	if(strlen($words[$i])>1){
   			if($words[$i][0] == '#'){
   				$hashSql = 'SELECT HashTagID FROM `MessageHashTags` WHERE HashTag like "'.substr($words[$i],1).'"';
   
   				$hashRes = $pdo->query($hashSql);
   				$HashTag = $hashRes ->fetch();
   
   
   				echo "<a href = 'drops.php?hashId=".$HashTag['HashTagID']."' style = 'color:#29B6F6';> ".$words[$i]." </a>";
   
   
   			}else{
   				if($words[$i][0] == '@'){
   
   				$userSql = 'SELECT UID FROM `User` WHERE Username like "'.substr($words[$i],1).'"';
   				$userRes = $pdo->query($userSql);
   				$userRow = $userRes ->fetch();
   
   				echo "<a href = 'profile.php?id=".$userRow['UID']."' style = 'color:#29B6F6';> ".$words[$i]." </a>";
   
   				}else{
   				echo ' '.$words[$i].' ';
   				}
   			}
   			}else{
   				echo ' '.$words[$i].' ';
   			}
   		}
   }
   
   function searchForPostHashTags($message,$messageID){
   	$username = "root";
   	$password = "";
   	//$username = "id5403878_finalprojectroot";
   	//$password = "12345";
   	$shouldShowErrors = false;
   	try {
   	    //$pdo = new PDO("mysql:host=localhost;dbname=id5403878_finalproject", $username, $password);
   	    $pdo = new PDO("mysql:host=localhost;dbname=cs3500_MessageDB", $username, $password);
   	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   	    
   	}
   	catch (PDOException $e) {
   	    echo "Connection failed: " . $e->getMessage();
   	}
   	
   	$words = explode(" ", $message);
   	    for($i = 0;$i<count($words);$i++){
   	    	
   	    	if(strlen($words[$i])>1){
   
   				if($words[$i][0] == '#'){
   					
   					$hashtag = substr($words[$i],1);
   
   					$hashSql = 'SELECT HashTagID FROM `MessageHashTags` WHERE HashTag like "'.$hashtag.'"';
   					$hashRes = $pdo->query($hashSql);
   					$HashTag = $hashRes ->fetchAll();
   					
   					if(count($HashTag)>=1){
   						echo "has rows";
   						echo $HashTag['HashTagID'][0];
   					}else{
   						echo "has no rows";
   					}
   					
   					if(count($HashTag)>=1){
   
   						$sql_insert = "INSERT INTO MessageHashTags (`MessageID`, `HashTagID`, `HashTag`) VALUES(?,?,?)";
   						$query = $pdo->prepare($sql_insert);
   						$query->bindValue(1, $messageID);
   						$query->bindValue(2, $HashTag[0]['HashTagID']);
   						$query->bindValue(3, $hashtag);
   						$query->execute();
   
   					}else{
   						$msgIDSql = 'SELECT MAX(HashTagID) FROM MessageHashTags';
   						$msgIDRes = $pdo->query($msgIDSql);
   						$msgID = $msgIDRes ->fetch();
   
   						$sql_insert = "INSERT INTO MessageHashTags (`MessageID`,`HashTagID` ,`HashTag`) VALUES(?,?,?)";
   						$query = $pdo->prepare($sql_insert);
   						$query->bindValue(1, $messageID);
   						$query->bindValue(2, $msgID[0]+1);
   						$query->bindValue(3, $hashtag);
   						$query->execute();
   					}
   					
   				}
   			}
   		}
   }
   	
   	function showImageErrorWithMessage($message){
   		if($shouldShowErrors == true){
   			echo $message;
   		}
   	}
   	
   	if(isset($_POST["submit"])) {
   
   		$path = "";
   		$file = $_FILES['file'];
   
   		if($_SESSION['UID'] == null){$_SESSION['UID']=2;};
   		
   		$fileName = $_FILES['file']['name'];
   		$fileTmpName = $_FILES['file']['tmp_name'];
   		$fileSize = $_FILES['file']['size'];
   		$fileError = $_FILES['file']['error'];
   		$fileType = $_FILES['file']['type'];
   		$fileExt = explode('.', $fileName);
   
   		$fileActualExt = strtolower(end($fileExt));
   		
   		$allowed = array("png");
   		$fileNameNew = "null";
   
   		if(in_array($fileActualExt, $allowed)){
   			if($fileError === 0){
   				if($fileSize < 200000000){
   					$fileNameNew = str_replace(".","",uniqid('',true)).".".$fileActualExt;
   					$path = "DropImages/".$fileNameNew;
   					echo $fileDestination;
   					$value = move_uploaded_file($fileTmpName, $path);
   					$errorMessage = "";
   					$shouldShowErrors = false;
   					echo $value;
   				}else{
   				
   				}
   			}else{
   			
   			}
   		}else{
   
   		}
   		$tag = "news";
   		$color = 'purple';
   		$message = $_POST['NewDropMessage'];
   		$date = date("Y-m-d H:i:s");
   		$messageType = 1;
   		$likes = 0;
   		$Privacy = 1;
   
   		if($path != ""){
   			$messageType = 2;
   		}else{
   			$path = "null";
   		}
   
   		if(count($message) < 179){			
   			if($_POST['tagValue'] == 1){
   				$tag = "funny";
   				$color = "red";
   			}
   			if($_POST['tagValue'] == 2){
   				$tag = "tech";
   				$color = "blue";
   			}
   			if($_POST['tagValue'] == 3){
   				$tag = "news";
   				$color = "purple";
   			}
   		try{
   			$sql_insert = "INSERT INTO Message (`UID`, `TypeOfMessage`, `Message`,`Path`,`Date`,`Likes`,`Privacy`,`Color`,`Type`) VALUES(?,?,?,?,?,?,?,?,?)";
   
   			$query = $pdo->prepare($sql_insert);
   			$query->bindValue(1, $_SESSION['UID']);
   			$query->bindValue(2, $messageType);
   			$query->bindValue(3, $message);
   			$query->bindValue(4, $fileNameNew);
   			$query->bindValue(5, $date);
   			$query->bindValue(6, $likes);
   			$query->bindValue(7, $Privacy);
   			$query->bindValue(8, $color);
   			$query->bindValue(9, $tag);
   			$query->execute();
   
   
   
   			$msgIDSql = 'SELECT MAX(MessageID) FROM Message';
   			$msgIDRes = $pdo->query($msgIDSql);
   			$msgID = $msgIDRes ->fetch();
   
   			
   			searchForPostHashTags($message,$msgID[0]);
   			
   			
   
       		echo "New record created successfully";
   
       		//header("Location: drops.php?order=recent&type=ASC");
       }
   catch(PDOException $e)
       {
       echo $sql . "<br>" . $e->getMessage();
       }
   
   
   	}
   
   	}
   	 
   
   ?>
<!DOCTYPE html>
<html>
   <meta charset="utf-8">
   <head>
      <link rel="stylesheet" type="text/css" href="css/reset.css">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="css/header.css">
      <link rel="stylesheet" type="text/css" href="css/drops.css">
      <link rel="stylesheet" type="text/css" href="css/sideBar.css">
      <link href="profile.html">
      <link href = "notifications.html">
      <script type="text/javascript">
         function centerImage(userId,messageID){
         
         }
          
      </script>
      <title></title>
      <style type="text/css">
         @keyframes showDrop {
         0%   {margin-left: 100%;}
         10%  {position: relative;}
         100% {margin-left: 5%;position: relative;}
         }
         @keyframes hideDrop {
         0%   {margin-left: 5%;}
         100% {margin-left: 100%;position: absolute;}
         }
         .showNewDrop{
         animation-name: showDrop;
         animation-duration: 2s;
         animation-fill-mode: forwards;
         }
         .hideNewDrop{
         animation-name: hideDrop;
         animation-duration: 0.5s;
         animation-fill-mode: forwards;
         }
         #newDrop{
         position: absolute;
         margin-left: -200px;
         margin-top: 80px;
         color: white;
         width: 140px;
         height: 45px;
         border-radius: 30px;
         border:1px #424242 solid;
         }
         #newDrop:hover{
         background-color: #263238;
         }
         #newDrop-Details button{
         position: relative;
         }
         #newDropItems{
         position: absolute;
         color:white;
         width: 600px;
         height: 350px;
         margin:230px auto -200px auto;
         margin-left: 100%;
         border-radius: 40px;
         padding: 20px;
         padding-top: 0px;
         }
         #newDrop-Details{
         position: relative;
         margin-top: 10px;
         }
         .dropTag{
         width: 140px;
         height: 45px;
         border-radius: 30px;
         border:1px #424242 solid;
         }
         #exit{
         margin-top: -40px;
         margin-left: 390px;
         }
         textarea{
         width: 400px;
         height: 100px;
         border-radius: 20px;
         padding: 10px;
         }
         figure {
         padding: 5px 0;
         max-height: 500px;
         overflow-y: hidden;
         position: relative;
         margin-left: 10px;
         margin-right: 10px;
         }
         figure>img {
         width: 100%;
         height: auto;
         position: relative;
         margin-top:50%;
         transform:translateY(-75%);
         }
      </style>
   </head>
   <body>
      <section>
         <div id = "topMenu" style="background-color: #FFEE58">
            <ul>
               <li id = "logo">DropPoint
               <li>
               <li class="right">
                  <ul>
                     <li id = "logout-btn"><a href="index.php?opt=newUser">logout</a></li>
                  </ul>
               </li>
            </ul>
         </div>
         <div id = "menu-Cnt">
         <div id = subMenu>
         <div class="menu-item blue" style= "height: 190px; ">
            <?php echo '<div class="menu-item-text"><a href = "profile.php?id='.$_SESSION['UID'].'">My Profile</a></div>';?>
         </div>
         <div class="menu-item purple" style= "height: 160px; ">
            <div class="menu-item-text"><a href="#">Notifications</a></div>
         </div>
         <div class="menu-item yellow" style= "height: 130px; ">
            <div class="menu-item-text active">
               <a href="drops.php?order=popular&type=ASC">Drops</a>
               <div class="right">
                  <button id = "newDrop" class="lightBlack">New Drop +</button>
                  <div>
                  </div>
               </div>
            </div>
         </div>
         <div class="inflow">
            <div id = "profilePic-Cnt">
               <?php 
                  if(isset($_SESSION['UID'])){
                  /*$profilePicSql = 'SELECT PicturePath FROM `User` WHERE UID = '.$_SESSION['UID'];
                  $profilePicSqlRes = $pdo->query($profilePicSql);
                  $profilePicSqlRow = $profilePicSqlRes ->fetch();*/
                  
                  	if(trim($profilePath) == 'NULL'){
                  		echo' <div id = profilePic></div>';
                  	}else{
                  		
                  		echo' <a href = "/finalproject/profile.php?id='.$_SESSION['UID'].'"> <img id = profilePic src="'.$profilePicSqlRow['PicturePath'].'"></a>';
                  	}
                  }
                  ?>
            </div>
         </div>
      </section>
      <section id = "newDropItems" class="black">
         <form id="newDropForm" method="post" action="drops.php" enctype="multipart/form-data">
            <ul>
               <li>
                  <h3>Add Drop</h3>
               </li>
               <li><img id = exit src="DropImages/exit.png"></li>
            </ul>
            <textarea class="black " name="NewDropMessage" form="newDropForm" placeholder="Enter text here..."><?php showImageErrorWithMessage($errorMessage); ?></textarea>
            <div id = "newDrop-Details">
               <ul id = "Tags">
                  <input id = "tagValue" type="hidden" name="tagValue" value="" />
                  <li><button type = "button" id = "dropTag-1"  class = "dropTag red">Funny</button></li>
                  <li><button type = "button" id = "dropTag-2"  class = "dropTag blue">Tech</button></li>
                  <li><button type = "button" id = "dropTag-3"  class = "dropTag purple">News</button></li>
                  <li><button type="submit" value="Upload Image" name="submit" class="dropTag white" style="color: #424242; ">Drop</button></li>
               </ul>
               <ul>
                  <li>
                     <div style = "margin-left: 270px;"><input type="file" name="file" id="file" class="inputfile" /></div>
                  </li>
               </ul>
            </div>
         </form>
      </section>
      <?php
         //****************
         $messages = array();
         $sql = "SELECT * FROM Message ORDER BY Date DESC";
         $res = $pdo->query($sql);
         while ($row = $res->fetch()) {
          		$messages[] = $row;     
         }
         //****************
         $popular = array();
         $sql = "SELECT * FROM Message ORDER BY Likes DESC";
         $res = $pdo->query($sql);
         while ($row = $res->fetch()) {
          		$popular[] = $row;     
         }
         //****************
         
         /*Trending*/
         echo '<section id = "sideBar" class="col-sm-2">
         	<ul>
         		<li><div id = "tending">
         			<div class = "titleHeader black">
         				<h1>Trending</h1>
         			</div>
         			<ul id = "sidebarList">
         				<li>
         					<div class = "minDrop">
         						<h4 id = "minDropLikes">'.$popular[0]['Likes'].'</h4>
         						<p id = "minDropMsg">
         							'.$popular[0]['Message'].'
         						</p>
         					</div>
         				</li>
         				<li>
         					<div class = "minDrop">
         						<h4 id = "minDropLikes">'.$popular[1]['Likes'].'</h4>
         						<p id = "minDropMsg">
         							'.$popular[1]['Message'].'
         						</p>
         					</div>
         				</li>
         				<li>
         					<div class = "minDrop">
         						<h4 id = "minDropLikes">'.$popular[2]['Likes'].'</h4>
         						<p id = "minDropMsg">
         							'.$popular[2]['Message'].'
         						</p>
         			</div>
         		</li>
         	</ul>
         </li></div>';
         ?>
      <!--The filters-->
      <li>
         <div id = "filters">
         <div class = "titleHeader black">
            <h1>Filters</h1>
         </div>
         <ul id = "sidebarList">
            <li>
               <div class = "minDrop">
            <li><a style = "border:none;" href="drops.php?order=tech&type=ASC" class="btn btn-info blue" role="button"> tech </a></li>
            <li><a  style = "border:none;" href="drops.php?order=funny&type=ASC" class="btn btn-info red" role="button"> funny </a></li>
            <li><a  style = "border:none;" href="drops.php?order=news&type=ASC" class="btn btn-info purple" role="button"> news </a></li>            
            </li>
            <li>
            <div class = "minDrop">
            <a  style = "border:none;" href="drops.php?order=popular&type=ASC" class="btn btn-info lightBlack" role="button"> Most Popular</a>
            </div>
            </li>
            <li>
            <div class = "minDrop">
            <a  style = "border:none;" href="drops.php?order=recent&type=ASC" class="btn btn-info lightBlack" role="button"> Most Recent </a>
            </div>
            </li>
         </ul>
      </li>
      </div>
      </ul>
      </section>
      <?php
         /*The Drops*/
         echo '<section id = "drops-ctn" class="col-sm-10">
         <ul id = "drops">';
         
         if(isset($_GET['hashId'])){
         		$hashMsgsSql = "SELECT MessageID FROM `MessageHashTags` WHERE HashTagID = ".$_GET['hashId'];
         		$hashMsgsRes = $pdo->query($hashMsgsSql);
         		$hashMsgs = $hashMsgsRes ->fetchAll();
         
         		
         
         		$messages1 = array();
         		$counter = 0;
         		foreach ($hashMsgs as $values) {
         
         			$MsgsSql = "SELECT * FROM `Message` WHERE MessageID = ".$values[0];
         			$MsgsRes = $pdo->query($MsgsSql);
         			$Msgs = $MsgsRes ->fetch();
         
         			$messages1[$counter] = $Msgs;
         			
         			$counter++;
         		}	
         	
         		$c = 0;
         
         foreach ($messages1 as $value) {
         	$userSql = "SELECT Username,PicturePath FROM User Where UID = ".$value['UID'];
         	$userRes = $pdo->query($userSql);
         	$user = $userRes ->fetch();
         	echo
         		'<li>
         			<div class = "drop '.$value['Color'].' ';
         			 if($value['TypeOfMessage'] == 2){echo 'extendedDrop';} 
         			 echo '">
         				<p id = "username"><a href = "profile.php?id='.$value['UID'].'">@'.$user['Username'].'</a></p>
         				<div class = "text-ctn">';
         
         				if($user['PicturePath'] != "ProfileImages/null.png"){
         					echo '<img class = "dropProfilePic '.$value['Color'].'" src = "'.$user['PicturePath'].'">';
         				}else{
         					echo '<div class = "dropProfilePic '.$value['Color'].'"></div>';
         				}
         					echo '	<p id = "dropMsg">
         							'; printMessageWithHashTag($value['Message']); echo'
         						</p>
         				
         					<div class = "dropType '.$value['Type'].' fine extendedText">
         						<p>'.$value['Type'].'</p>
         					</div>
         					<div class = "dropInfo fine">
         						<ul>
         							<li><p id = "date">'.$value['Date'].'</p></li>
         							<li><p class = "likes '.$value['Type'].'">'.$value['Likes'].' likes</p></li>
         						</ul>
         					</div>';
         
         					if($value['TypeOfMessage'] == 2){echo '
         					<figure>
         						<img id = "'.$value['UID'].':'.$value['MessageID'].'"  class = "" src = "DropImages/'.$value['Path'].'" >
         						<script type="text/javascript">
         							centerImage('.$value['UID'].','.$value['MessageID'].');
         						</script>
         					</figure>
         					';}
         
         					echo'
         				</div>
         			</div>
         		</li>';
         		}
         }
         
         //Tag: Tech
         if ($_GET['order'] == 'tech') {
         foreach ($messages as $value) {
         	if ($value['Type'] == 'tech') {
         	$userSql = "SELECT Username,PicturePath FROM User Where UID = ".$value['UID'];
         	$userRes = $pdo->query($userSql);
         	$user = $userRes ->fetch();
         	echo
         		'<li>
         			<div class = "drop '.$value['Color'].' ';
         			 if($value['TypeOfMessage'] == 2){echo 'extendedDrop';} 
         			 echo '">
         				<p id = "username"><a href = "profile.php?id='.$value['UID'].'">@'.$user['Username'].'</a></p>
         				<div class = "text-ctn">';
         
         				if($user['PicturePath'] != "ProfileImages/null.png"){
         					echo '<img class = "dropProfilePic '.$value['Color'].'" src = "'.$user['PicturePath'].'">';
         				}else{
         					echo '<div class = "dropProfilePic '.$value['Color'].'"></div>';
         				}
         					echo '	<p id = "dropMsg">
         							'; printMessageWithHashTag($value['Message']); echo'
         						</p>
         				
         					<div class = "dropType '.$value['Type'].' fine extendedText">
         						<p>'.$value['Type'].'</p>
         					</div>
         					<div class = "dropInfo fine">
         						<ul>
         							<li><p id = "date">'.$value['Date'].'</p></li>
         							<li><p class = "likes '.$value['Type'].'">'.$value['Likes'].' likes</p></li>
         						</ul>
         					</div>';
         
         					if($value['TypeOfMessage'] == 2){echo '
         					<figure>
         						<img id = "'.$value['UID'].':'.$value['MessageID'].'"  class = "" src = "DropImages/'.$value['Path'].'" >
         						<script type="text/javascript">
         							centerImage('.$value['UID'].','.$value['MessageID'].');
         						</script>
         					</figure>
         					';}
         
         					echo'
         				</div>
         			</div>
         		</li>';
         }
         }
         }
         
         //Tag: Funny
         if ($_GET['order'] == 'funny') {
         foreach ($messages as $value) {
         	if ($value['Type'] == 'funny') {
         	$userSql = "SELECT Username,PicturePath FROM User Where UID = ".$value['UID'];
         	$userRes = $pdo->query($userSql);
         	$user = $userRes ->fetch();
         	echo
         		'<li>
         			<div class = "drop '.$value['Color'].' ';
         			 if($value['TypeOfMessage'] == 2){echo 'extendedDrop';} 
         			 echo '">
         				<p id = "username"><a href = "profile.php?id='.$value['UID'].'">@'.$user['Username'].'</a></p>
         				<div class = "text-ctn">';
         
         				if($user['PicturePath'] != "ProfileImages/null.png"){
         					echo '<img class = "dropProfilePic '.$value['Color'].'" src = "'.$user['PicturePath'].'">';
         				}else{
         					echo '<div class = "dropProfilePic '.$value['Color'].'"></div>';
         				}
         					echo '	<p id = "dropMsg">
         							'; printMessageWithHashTag($value['Message']); echo'
         						</p>
         				
         					<div class = "dropType '.$value['Type'].' fine extendedText">
         						<p>'.$value['Type'].'</p>
         					</div>
         					<div class = "dropInfo fine">
         						<ul>
         							<li><p id = "date">'.$value['Date'].'</p></li>
         							<li><p class = "likes '.$value['Type'].'">'.$value['Likes'].' likes</p></li>
         						</ul>
         					</div>';
         
         					if($value['TypeOfMessage'] == 2){echo '
         					<figure>
         						<img id = "'.$value['UID'].':'.$value['MessageID'].'"  class = "" src = "DropImages/'.$value['Path'].'" >
         						<script type="text/javascript">
         							centerImage('.$value['UID'].','.$value['MessageID'].');
         						</script>
         					</figure>
         					';}
         
         					echo'
         				</div>
         			</div>
         		</li>';
         }
         }
         }
         
         
         //Tag: News
         if ($_GET['order'] == 'news') {
         foreach ($messages as $value) {
         	if ($value['Type'] == 'news') {
         	$userSql = "SELECT Username,PicturePath FROM User Where UID = ".$value['UID'];
         	$userRes = $pdo->query($userSql);
         	$user = $userRes ->fetch();
         	echo
         		'<li>
         			<div class = "drop '.$value['Color'].' ';
         			 if($value['TypeOfMessage'] == 2){echo 'extendedDrop';} 
         			 echo '">
         				<p id = "username"><a href = "profile.php?id='.$value['UID'].'">@'.$user['Username'].'</a></p>
         				<div class = "text-ctn">';
         
         				if($user['PicturePath'] != "ProfileImages/null.png"){
         					echo '<img class = "dropProfilePic '.$value['Color'].'" src = "'.$user['PicturePath'].'">';
         				}else{
         					echo '<div class = "dropProfilePic '.$value['Color'].'"></div>';
         				}
         					echo '	<p id = "dropMsg">
         							'; printMessageWithHashTag($value['Message']); echo'
         						</p>
         				
         					<div class = "dropType '.$value['Type'].' fine extendedText">
         						<p>'.$value['Type'].'</p>
         					</div>
         					<div class = "dropInfo fine">
         						<ul>
         							<li><p id = "date">'.$value['Date'].'</p></li>
         							<li><p class = "likes '.$value['Type'].'">'.$value['Likes'].' likes</p></li>
         						</ul>
         					</div>';
         
         					if($value['TypeOfMessage'] == 2){echo '
         					<figure>
         						<img id = "'.$value['UID'].':'.$value['MessageID'].'"  class = "" src = "DropImages/'.$value['Path'].'" >
         						<script type="text/javascript">
         							centerImage('.$value['UID'].','.$value['MessageID'].');
         						</script>
         					</figure>
         					';}
         
         					echo'
         				</div>
         			</div>
         		</li>';
         	}
         }
         }
         
         //Most Popular
         if ($_GET['order'] == 'popular') {
         foreach ($popular as $value) {
         	$userSql = "SELECT Username,PicturePath FROM User Where UID = ".$value['UID'];
         	$userRes = $pdo->query($userSql);
         	$user = $userRes ->fetch();
         	echo
         		'<li>
         			<div class = "drop '.$value['Color'].' ';
         			 if($value['TypeOfMessage'] == 2){echo 'extendedDrop';} 
         			 echo '">
         				<p id = "username"><a href = "profile.php?id='.$value['UID'].'">@'.$user['Username'].'</a></p>
         				<div class = "text-ctn">';
         
         				if($user['PicturePath'] != "ProfileImages/null.png"){
         					echo '<img class = "dropProfilePic '.$value['Color'].'" src = "'.$user['PicturePath'].'">';
         				}else{
         					echo '<div class = "dropProfilePic '.$value['Color'].'"></div>';
         				}
         					echo '	<p id = "dropMsg">
         							'; printMessageWithHashTag($value['Message']); echo'
         						</p>
         				
         					<div class = "dropType '.$value['Type'].' fine extendedText">
         						<p>'.$value['Type'].'</p>
         					</div>
         					<div class = "dropInfo fine">
         						<ul>
         							<li><p id = "date">'.$value['Date'].'</p></li>
         							<li><p class = "likes '.$value['Type'].'">'.$value['Likes'].' likes</p></li>
         						</ul>
         					</div>';
         
         					if($value['TypeOfMessage'] == 2){echo '
         					<figure>
         						<img id = "'.$value['UID'].':'.$value['MessageID'].'"  class = "" src = "DropImages/'.$value['Path'].'" >
         						<script type="text/javascript">
         							centerImage('.$value['UID'].','.$value['MessageID'].');
         						</script>
         					</figure>
         					';}
         
         					echo'
         				</div>
         			</div>
         		</li>';
         }
         }
         
         //Most Recent
         if ($_GET['order'] == 'recent') {
         foreach ($messages as $value) {
         	$userSql = "SELECT Username,PicturePath FROM User Where UID = ".$value['UID'];
         	$userRes = $pdo->query($userSql);
         	$user = $userRes ->fetch();
         	echo
         		'<li>
         			<div class = "drop '.$value['Color'].' ';
         			 if($value['TypeOfMessage'] == 2){echo 'extendedDrop';} 
         			 echo '">
         				<p id = "username"><a href = "profile.php?id='.$value['UID'].'">@'.$user['Username'].'</a></p>
         				<div class = "text-ctn">';
         
         				if($user['PicturePath'] != "ProfileImages/null.png"){
         					echo '<img class = "dropProfilePic '.$value['Color'].'" src = "'.$user['PicturePath'].'">';
         				}else{
         					echo '<div class = "dropProfilePic '.$value['Color'].'"></div>';
         				}
         					echo '	<p id = "dropMsg">
         							'; printMessageWithHashTag($value['Message']); echo'
         						</p>
         				
         					<div class = "dropType '.$value['Type'].' fine extendedText">
         						<p>'.$value['Type'].'</p>
         					</div>
         					<div class = "dropInfo fine">
         						<ul>
         							<li><p id = "date">'.$value['Date'].'</p></li>
         							<li><p class = "likes '.$value['Type'].'">'.$value['Likes'].' likes</p></li>
         						</ul>
         					</div>';
         
         					if($value['TypeOfMessage'] == 2){echo '
         					<figure>
         						<img id = "'.$value['UID'].':'.$value['MessageID'].'"  class = "" src = "DropImages/'.$value['Path'].'" >
         						<script type="text/javascript">
         							centerImage('.$value['UID'].','.$value['MessageID'].');
         						</script>
         					</figure>
         					';}
         
         					echo'
         				</div>
         			</div>
         		</li>';
         }
         }
         
         	echo '</ul>
         </section>';
         ?>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src = "js/drop.js" type="text/javascript"></script>
   </body>
</html>