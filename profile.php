<?php
$host = "127.0.0.1";
$user="root";
$pass ="123456789";
$database = "website";
$connect = mysqli_connect($host,$user,$pass,$database);
if(mysqli_connect_errno()){
    die("cannot connect ".mysqli_connect_error());
}
if(isset($_COOKIE['PHPSESSID'])){
    $session = $_COOKIE['PHPSESSID'];// from user
    $session = htmlentities($session,ENT_QUOTES);
    $query = "select * from login where session='".$session."'";// sql
    $result = mysqli_query($connect,$query);
    $data = mysqli_fetch_assoc($result);
    $username = $data['username'];
    $password = $data['password'];
    $picture = $data['image'];
    $csrf_token = $data['csrf_token'];
    // here if the user want to upload file image profile 
    // sql injection in upload file if i control in the name of file
    $size = $_FILES['file']['size'];
    $name = $_FILES['file']['name'];// from user
    $type = $_FILES['file']['type'];// from user
    $tmp_name = $_FILES['file']['tmp_name'];
    //Here is many way to file upload vulnerablity
    if ($size < 100000) {
        $whitelest = ['png','jpg','jpeg'];
        $file = explode(".",$name);// from user
        $length = count($file); 
        if (in_array($file[$length-1],$whitelest)) {
            $upload_dir = '/var/www/html/website/downloads/'.$username.'.'.$file[$length-1];
            $done = move_uploaded_file($tmp_name,$upload_dir);
            $query2 = "update login set image='downloads/".$username.".".$file[$length-1]."' where username='".$username."'";// sql
            $result2 = mysqli_query($connect,$query2);
            $image = 'true';
        }
        
    }

    if (isset($_POST['password1'])) {
        $password1 = $_POST['password1'];// from user
        $password1 = htmlentities($password1,ENT_QUOTES);
        $password2 = $_POST['password2'];
        $password2 = htmlentities($password2,ENT_QUOTES);
        if ($password1 == $password2) {
            $password1 = sha1($password1);
            if ($csrf_token == $_POST['csrf_token']) {
                $query4 = "update login set password='".$password1."' where session='".$session."' ";// sql
                $result4 = mysqli_query($connect,$query4);
                $x = true;
            }
            
        }
        
    }

}else{
    header("HTTP/1.1 404 Not Found");
    die();
}







?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
</head>
<body style="background-color: gray;">
<center><br><br><br><br><br><br>
<nav style="background-color: darkslateblue;width: 90%;">
<br><br>

<img src="<?php  ?>">
<p style="color:aliceblue">Welcome <?php echo $username; ?></p>
<br>
<img src="<?php echo $picture; ?>" width=60%>
<br><br><br><br><br><br><br><br><br>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="file">
<input type="submit" value="send image"><br><br><br>
</form><!-- need to prevent csrf -->
<form action="" method="post">
<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" >
<input type="password" name="password1">
<br>
<input type="password" name="password2">
<br>
<input type="submit" name="submit" value="send">
</form><br><br><br>
<?php

if ($image == 'true') {
    echo 'image uploaded successfully';
};
if($x == true){
    echo 'password updated';
}
?>

</nav>
</center>


</body>
</html>