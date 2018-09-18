<?php
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
   
          $_POST['canSignIn'] = '0';
          $_POST['canSignIn'] = '0';
   
   if(isset($_GET['opt'])){
       if($_GET['opt'] == "newUser"){
          unset($_SESSION['UID']); 
           header("Location:index.php");
   
       } 
   }
   
   if (isset($_POST['canSignIn']) &&  $_POST['canSignIn'] = '1') {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $_SESSION['username'] = null;
           $_SESSION['password'] = null;
           $_SESSION['uid']      = null;
   
           
           if (!empty($_POST['username']) && !empty($_POST['password'])) {
               $user = trim($_POST['username']);
               $pass = trim($_POST['password']);
               $hash = hash('sha256', $pass);
   
               $userSql = "SELECT Username,Password,UID FROM `User` WHERE UserName = ? AND Password = ?";
               
               $query = $pdo->prepare($userSql);
               $query->bindValue(1, $user);
               $query->bindValue(2, $hash);
               $query->execute();
               
               if ($query->rowCount() != 0) {
                   while ($row = $query->fetch()) {
                       $results = $row;
                       if (($user = $row['Username']) && $hash = $row['Password']) {
                           $_SESSION['UID']      = $row['UID'];
                           
                           $_SESSION['username'] = $user;
                           $_SESSION['password'] = $pass;
                           header("Location:drops.php?order=popular&type=ASC");
                        
                       }
                   }
               }else{
   
                $shouldShowErrors = true;
               }
           }else{
   
                $shouldShowErrors = true;
           }
       }
   }
   
   if(isset($_POST['canSignUp']) && $_POST['canSignUp'] == '1'){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $_SESSION['uid'] = null;
            if (!empty($_POST['newUsername']) && !empty($_POST['newPassword']) && !empty($_POST['newEmail']) && !empty($_POST['newPasswordRE'])) {
   
                $hash = hash('sha256', $_POST['newPassword']);
   
                $sql_insert = "INSERT INTO User (`Username`,`Password` ,`Email`,`PicturePath`) VALUES(?,?,?,?)";
                $query = $pdo->prepare($sql_insert);
                $query->bindValue(1, $_POST['newUsername']);
                $query->bindValue(2, $hash);
                $query->bindValue(3, $_POST['newEmail']);
                $query->bindValue(4, 'NULL');
                $query->execute();
               
   
               $IDSql = 'SELECT MAX(UID) FROM User';
               $IDRes = $pdo->query($IDSql);
               $ID = $IDRes ->fetch();
               $_SESSION['UID'] = $ID[0];
               header("Location: drops.php?order=popular&type=ASC");
   
   
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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="js/landingpage.js"></script>
      <title></title>
      <style type="text/css">
         #drops-ctn{
         margin: 0 auto;
         margin-top: 100px;
         }
         body{
         background-color: white;
         color: black;
         }
         input[type="text"],[type="password"]{
         border:none;
         border-bottom: solid 1px #212121;
         margin-top: 5px;
         margin-bottom: 10px;
         width: 10px;
         background-color: white;
         }
         button{
         font-size: 30px;
         width:60px;
         height: 40px;
         margin-top: 15px;
         margin-left: 50%;
         color: black;
         background-color: white;
         border-radius: 20px;
         border:solid 2px #212121;
         }
         .strech{
         animation-name: strech;
         animation-duration: 1s;
         animation-fill-mode: forwards;
         }
         .shrink{
         animation-name: shrink;
         animation-duration: 0.5s;
         animation-fill-mode: forwards;
         }
         #title{
         margin-left: 30px;
         }
         #mainContent-ctn{
         width: 100%;
         background-color: white;
         }
         form{
         width: 500px;
         margin: 0 auto;
         margin-top: 100px;
         }
         @keyframes strech {
         0%   {width: 10px;}
         100% {width: 140px;}
         }
         @keyframes shrink {
         0%   {width: 140px;}
         100% {width: 10px;}
         }
      </style>
   </head>
   <body>
      <div id = "title">
         <h1>DropPoint</h1>
         <h3>Login or SignUp</h3>
      </div>
      <div id = "mainContent-ctn">
         <form method="post" id = "userForm" action="index.php">
            <div id = "signIn">
               <input class = "textField" name = "canSignIn" id = "canSignIn" value = "" type="hidden">
               <label>Username</label><br>
               <input class = "textField" name = "username" id = "textField-1" type="text"><br>
               <label>Password</label><br>
               <input class = "textField" name = "password" id = "textField-2" type="password"><br>
               <button type="button" id ="SignIn" name = "signIn">
                  <p>🏃</p>
               </button>
            </div>
            <div id = "singUp">
               <input class = "textField" name = "canSignUp" id = "canSignUp" value = "1" type="hidden">
               <label>Username</label><br>
               <input class = "textField" name = "newUsername" id = "textField-3" type="text"><br>
               <label>Email</label><br>
               <input class = "textField" name = "newEmail" id = "textField-4" type="text"><br>
               <label>Password</label><br>
               <input class = "textField" name = "newPassword" id = "textField-5" type="password"><br>
               <label>Re-Password</label><br>
               <input class = "textField" name = "newPasswordRE" id = "textField-6" type="password"><br>
               <button type="button" name="SignUp" id ="SignUp" style="width: 150px; height: 45px; ">
                  <p>Sign Up</p>
               </button>
            </div>
         </form>
      </div>
      <?php
         $popular = array();
         $sql = "SELECT * FROM Message ORDER BY Likes DESC";
         $res = $pdo->query($sql);
         while ($row = $res->fetch()) {
             $popular[] = $row;     
         }
         
                 echo '<section id = "drops-ctn" >
         <ul id = "drops">';
             foreach ($popular as $value) {
             $userSql = "SELECT Username,PicturePath FROM User Where UID = ".$value['UID'];
             $userRes = $pdo->query($userSql);
             $user = $userRes ->fetch();
             echo
                 '<li>
                     <div class = "drop '.$value['Color'].' ';
                      if($value['TypeOfMessage'] == 2){echo 'extendedDrop';} 
                      echo '">
                         <p id = "username"><a href = "index.php">@'.$user['Username'].'</a></p>
                         <div class = "text-ctn">';
         
                         if($user['PicturePath'] != "ProfileImages/null.png"){
                             echo '<img class = "dropProfilePic '.$value['Color'].'" src = "'.$user['PicturePath'].'">';
                         }else{
                             echo '<div class = "dropProfilePic '.$value['Color'].'"></div>';
                         }
                             echo '  <p id = "dropMsg">
                                     ';echo $value['Message']; echo'
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
         
         echo '</ul>
         </section>';
         ?>
   </body>
</html>