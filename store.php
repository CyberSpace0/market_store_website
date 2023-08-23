<?php
$host = "127.0.0.1";
$user="root";
$pass ="123456789";
$database = "website";
$connect = mysqli_connect($host,$user,$pass,$database);
if(mysqli_connect_errno()){
    die("cannot connect ".mysqli_connect_error());
}
if (isset($_COOKIE['PHPSESSID'])) {
    if(isset($_POST['product_id'])){
        // get product data
        $id = $_POST['product_id'];// from user
        $id_s = htmlentities($id,ENT_QUOTES);
        $query = "select * from product where id='".$id_s."'";// sql
        $result = mysqli_query($connect,$query);
        $data = mysqli_fetch_assoc($result);
        $price = $data['price'];
        //---------------get session for user
        $session = $_COOKIE['PHPSESSID'];// // from user
        $session = htmlentities($session,ENT_QUOTES);
        //current total
        $query2 = "select total,username from login where session='".$session."'";// sql
        $result2 = mysqli_query($connect,$query2);
        $data2 = mysqli_fetch_assoc($result2);
        $username = $data2['username'];
        $total = $data2['total'];# this the total amount for this user
        // update the amount in the database
        $amount = $total+$price;
        $update_price = "update login set total=".$amount." where session='".$session."'";//sql $session
        $execute = mysqli_query($connect,$update_price);

    }
    
    
}
else{
    header("Location: login.php");
    die();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>store</title>
</head>
<body style="background-color: gray;">
<center><br><br><br><br><br><br><br><br><br>
<nav style="background-color: darkslateblue;width: 90%;">
<br><br>
<br>
<?php 
if(isset($_POST['product_id'])){
    echo "welcome ".$username."<br> the total is ".$amount."";
}else{
    $session = $_COOKIE['PHPSESSID'];//// from user
    $session = htmlentities($session,ENT_QUOTES);
    $q = "select * from login where session='".$session."'";// sql
    $r = mysqli_query($connect,$q);
    $da = mysqli_fetch_assoc($r);
    $username = $da['username'];
    $total = $da['total'];
    echo 'Welcome '.$username.' <br> The Total is: '.$total.'';


}
?>

</form><br><br>
    
</body>
</html>