<?php
$host = "127.0.0.1";
$user="root";
$pass ="123456789";
$database = "website";
$connect = mysqli_connect($host,$user,$pass,$database);
if(mysqli_connect_errno()){
    die("cannot connect ".mysqli_connect_error());
}
// Sql Injection in the cookie
if (isset($_COOKIE['PHPSESSID'])) {
    $session = $_COOKIE['PHPSESSID'];// from user
    $session = htmlentities($session,ENT_QUOTES);
    $query = "select username from login where session='".$session."'";// sql injection
    $result = mysqli_query($connect,$query);
    $username = mysqli_fetch_assoc($result)['username'];
}
$query2 = "select * from product";
$result2 = mysqli_query($connect,$query2);
$data = mysqli_fetch_all($result2);
$url = [$data[0][1],$data[1][1],$data[2][1]];
$title = [$data[0][3],$data[1][3],$data[2][3]];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body style="background-color: gray;">
<center><br><br><br><br><br><br><br><br><br>
<nav style="background-color: darkslateblue;width: 90%;">
<br><br>
<p style="color:aliceblue">Welcome <?php echo $username; ?></p>
<br>
<?php 

for ($i=0; $i <= 2; $i++) { 
    $x = $i +1;
    echo "<img src='".$url[$i]."' width='10%'><br><a href='product.php?id=".$x."'>".$title[$i]."</a><br><br>";
}


?>
<br><br><br><br><br><br><br><br><br>
</nav>
</center>

</body>
</html>