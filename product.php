<?php
$host = "127.0.0.1";
$user="root";
$pass ="123456789";
$database = "website";
$connect = mysqli_connect($host,$user,$pass,$database);
if(mysqli_connect_errno()){
    die("cannot connect ".mysqli_connect_error());
}
$query2 = "select * from product";
$result2 = mysqli_query($connect,$query2);
$data = mysqli_fetch_all($result2);
$url = [$data[0][1],$data[1][1],$data[2][1]];
$title = [$data[0][3],$data[1][3],$data[2][3]];
$id = $_GET['id'];// sql injection IF
$id = $id - 1;
$price = [$data[0][2],$data[1][2],$data[2][2]];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<body>
    
<body style="background-color: gray;">
<center><br><br><br><br><br><br><br><br><br>
<nav style="background-color: darkslateblue;width: 90%;">
<br><br>
<br>
<?php 
echo "<img src='".$url[$id]."' width='10%'><br><a>".$title[$id]."</a><br><br>";
?>
<form action="store.php" method="post">
<input type="hidden" value="<?php $id=$id+1;echo $id; ?>" name="product_id">
<input type="submit" value="send">
</form><br><br>

</nav>
</body>
</html>