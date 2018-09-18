<?php 
   error_reporting(1);
   session_start();
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
   
   
   	$numFollowersSql = 'SELECT * FROM `UserFollowing` WHERE Following = '.$_GET['id'];
   	$numFollowersRes = $pdo->query($numFollowersSql);
   	$numFollowersRow = $numFollowersRes ->fetchAll();
   
   	$followers = count($numFollowersRow);
   
   	$likes = 0;
   	$messages = array();
   	$sql = "SELECT * FROM Message Where UID = ".$_GET['id']." ORDER BY Date DESC";
   	$res = $pdo->query($sql);
   	while ($row = $res->fetch()) {
     		$messages[] = $row; 
     		//if($row['UID'] = $_GET['id']){ 
     			$likes += $row['Likes']; 
     		//}  
   	}
   
   	
   			$profilePicSql = 'SELECT PicturePath FROM `User` WHERE UID = '.$_SESSION['UID'];
   			$profilePicSqlRes = $pdo->query($profilePicSql);
   			$profilePicSqlRow = $profilePicSqlRes ->fetch();
   
   			$profilePath = $profilePicSqlRow['PicturePath'];
   
   if(isset($_POST['delete'])){
   	$sql = "DELETE FROM User WHERE UID = ".$_SESSION['UID'];
       $pdo->exec($sql);
       header('location:index.php?opt=newUser');
       exit();
   }
   
   if(isset($_POST['changePass'])){
   	if(isset($_POST['NEWpassword'])){
   		if(count($_POST['NEWpassword'])>0){
   			
   		    $hash = hash('sha256',$_POST['NEWpassword']);
   			$sql = "UPDATE User SET Password='".$hash."' WHERE UID = ".$_SESSION['UID'];
       		$stmt = $pdo->prepare($sql);
       		$stmt->execute();
   		}
   	}
   }
   
   
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
   
   
   			echo "<a href = '/finalproject/drops.php?hashId=".$HashTag['HashTagID']."' style = 'color:#29B6F6';> ".$words[$i]." </a>";
   
   
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
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title></title>
      <link rel="stylesheet" type="text/css" href="css/reset.css">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="css/header.css">
      <link rel="stylesheet" type="text/css" href="css/drops.css">
      <link rel = "stylesheet" type="text/css" href="css/sideBar.css">
      <link href="index.html">
      <link href="Notifications.html">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <style type="text/css">
         html{
         width: 100%;
         }
         body{
         background-color: white;
         }
         #sideBar{
         margin-top: 200px;
         }
         #friends{
         margin-top: 0px;
         }
         #profilePic-big{
         width: 200px;
         height: 200px;
         border-radius: 200px;
         background-color: #29B6F6;
         }
         #profileDetails{
         list-style-type: none;
         }
         #profileDetails li{
         display: inline;
         margin-bottom: none;
         margin-left: 10px;
         float: none;
         clear: none;
         }
         .profile-friends li{
         margin-left:30px;
         }
         #profileDetails li a:last-child{
         color:#29B6F6;
         }
         #profileDetails li:last-child{
         color:#29B6F6;
         }
      </style>
   </head>
   <body>
      <?php 
         $user1Sql = "SELECT * FROM `User` WHERE UID = ".$_GET['id'];
         $user1Res = $pdo->query($user1Sql);
         $user1 = $user1Res ->fetch();
         
         $followersSql = 'SELECT Following FROM `UserFollowing` WHERE UID = '.$_SESSION['UID'].' AND Following ='.$_GET['id'];
         $followersRes = $pdo->query($followersSql);
         $followersRow = $followersRes ->fetchAll();
         
         if(isset($_POST['unfollow'])){
         	
         	$deleteFollowingSql = 'DELETE FROM `UserFollowing` WHERE UID = '.$_SESSION['UID'].' AND Following ='.$_GET['id'];
         	$pdo->exec($deleteFollowingSql);
         	header("location:profile.php?id=".$_GET['id']);
         }
         if(isset($_POST['follow'])){
         	
         		$sql_insert = "INSERT INTO UserFollowing (`UID`, `Following`) VALUES(?,?)";
         
         		$query = $pdo->prepare($sql_insert);
         		$query->bindValue(1, $_SESSION['UID']);
         		$query->bindValue(2, $_GET['id']);
         		$query->execute();
         		header("location:profile.php?id=".$_GET['id']);
         }
         
         echo'
         <div>
         	<div id = "topMenu" class = "blue">
         		<ul>
         			<li id = "logo">DropPoint<li>
         			<li class="right">
         				<ul>
         					<li id = "logout-btn"><a href="index.php?opt=newUser">logout</a></li>
         				</ul>
         			</li>
         		</ul>
         	</div>';
         	echo'
         	<div id = "menu-Cnt">
         		<div id = subMenu>
         			<div class="menu-item yellow" style= "height: 190px; ">
         			<div class="menu-item-text"><a href="drops.php?order=popular&type=ASC">Drops</a></div>
         			</div>
         			<div class="menu-item purple" style= "height: 160px; ">
         			<div class="menu-item-text"><a href="">Notifications</a></div>
         			</div>
         			<div class="menu-item blue" style= "height: 130px; ">
         			<div class="menu-item-text active"><a href="">'.$user1['Username'].'s Profile</a></div>
         			</div>
         		</div>
         	</div>
         	<div class="inflow">
         		<div id = "profilePic-Cnt">';
         				
         		if(isset($_SESSION['UID'])){
         
         		if($profilePath != 'NULL'){
         		echo' <a href = "profile.php?id='.$_SESSION['UID'].'"> <img id = profilePic src="'.$profilePicSqlRow['PicturePath'].'"></a>';
         		}else{
         			echo' <div id = profilePic></div>';
         		}
         		}
         		
         		echo'
         		</div>
         	</div>
         </div>';
         
         
         
         
         
         
         
         echo '<section id = "sideBar" class="col-sm-2">
         	<ul>
         		<li><div id = "tending">
         			<ul id = "sidebarList">
         				<li>
         				';
         				if($profilePath != 'NULL'){
         					echo '<img src = "'.$user1['PicturePath'].'" id = "profilePic-big">';
         				}else{
         					echo '<div id = "profilePic-big"></div>';
         				}
         				echo '
         				</li>
         				<li>
         				<form method="post" action="profile.php?id='.$_GET['id'].'">';
         				if($_GET['id'] != $_SESSION["UID"]){
         					if(count($followersRow)>=1){
         							echo'
         							<input id = "FollowValue" type="hidden" name="unfollow" value="" />
         					<button type = "submit" value = "unfollow" style = "border:none;" class="btn btn-info lightBlack" role="button"> Unfollow </button></form>';
         
         					}else{
         							echo'
         							<input id = "FollowValue" type="hidden" name="follow" value="" />
         						<button type = "submit" value = "follow" style = "border:none;" class="btn btn-info blue" role="button"> Follow </button></form>';
         					}
         				
         
         				}
         
         				echo '
         				</li>
         				<li>
         					<ul id = "profileDetails"><li>'.$user1['Username'].'</li></ul>
         				</li>
         				<li>
         					<ul id = "profileDetails"><li>Drops:</li><li>'.Count($messages).'</li></ul>
         				</li>
         				<li>
         					<ul id = "profileDetails"><li>Likes:</li><li>'.$likes.'</li></ul>
         				</li>
         				<li>
         					<ul id = "profileDetails"><li>Followers:</li><li>'.$followers.'</li></ul>
         				</li>';
         
         
         				if($_GET['id'] == $_SESSION['UID']){
         					echo '					
         					<li>
         						<ul id = "profileDetails"><li>NewPassword:</li>
         						<li>
         						<form method = "POST" action="profile.php?id='.$_SESSION['UID'].'">
         						<input type = "password" name = "NEWpassword">
         						<button type = "submit" name = "changePass">Change</button>
         						</form>
         						</li>
         						</ul>
         					</li>
         					<li>
         						<ul id = "profileDetails"><li></li><li>							
         						<form method = "POST"  action="profile.php?id='.$_SESSION['UID'].'">
         						<button type = "submit" name = "delete">Delete Account</button>
         						</form></li></ul>
         					</li>';
         				}
         				echo'
         
         			</ul>
         		</li></div>';
         
         
         ?>
      <li>
         <div id = "friends">
            <div class = "titleHeader black">
               <h1>Followers</h1>
            </div>
            <ul id = "sidebarList">
               <?php
                  foreach($numFollowersRow as $friend){
                  	$userSql = "SELECT Username,UID FROM User Where UID = ".$friend['UID'];
                  	$userRes = $pdo->query($userSql);
                  	$user = $userRes ->fetch();
                  	echo'<li>
                  			<a style = "color:#29B6F6;" href = "profile.php?id='.$user['UID'].'">'.$user['Username'].'</a>
                  		</li>';
                  }
                  ?>
            </ul>
      </li>
      </div>
      </ul>
      </section>
      <?php echo '<section id = "drops-ctn" class="col-sm-10"> 
         <ul id = "drops">';?>
      <?php 
         $messagesSql = "SELECT * FROM `Message` WHERE UID = ".$_GET['id'];
         $messagesRes = $pdo->query($messagesSql);
         $Messages = $messagesRes ->fetch();
         
         
         foreach ($messages as $value) {
         
         	if($value['UID'] == $_GET['id']){
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
   </body>
</html>