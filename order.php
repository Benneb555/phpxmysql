<?php
session_start();
$fname= $_POST["fname"];
$lname= $_POST["lname"];
$address= $_POST["address"];
$mobile= $_POST["mobile"];
$servername="localhost";
$username="root";
$password="12341234";
$dbname="shop";
$con=mysqli_connect($servername,$username,$password,$dbname);
if(!$con) die("Connnect mysql database fail!!".mysqli_connect_error());
//echo "Connect mysql successfully!";
$sql="INSERT INTO order_product (fname, lname,address,mobile)";
$sql.="VALUES ('$fname', '$lname', '$address','$mobile');";
//echo $sql;
if (mysqli_query($con, $sql)) {
    $last_id = mysqli_insert_id($con);
    //echo "New record created successfully. Last inserted ID is: " . $last_id;
    // loop in session cart and insert each item to database
    $sql1="INSERT INTO order_details (order_id,product_id) VALUES ";
    for($i=0;$i<count($_SESSION["cart"]);$i++){
        $item_id=$_SESSION["cart"][$i]['id'];
        $sql1.="('$last_id','$item_id')";
        if($i<count($_SESSION["cart"])-1)
         $sql1.=",";
        else
         $sql.=";";
    }
    //echo $sql1;
    if(mysqli_query($con,$sql1)) echo "บันทึกข้อมูลการสั่งซื้อเรียบร้อยแล้ว";
    else "เกิดข้อผิดพลาดในการสั่งซื้อ";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
?>
    <br/>
<?php
echo "<h1>รายละเอียดการสั่งซื้อของคุณ</h1>";
echo "<h2>Data: </h2>";

echo "<h2>รายการสินค้า</h2>";
echo "<table><tr><th>ลำดับ</th><th>name</th><th>price</th></tr>";
    for($i=0;$i<count($_SESSION["cart"]);$i++)
    {
        $item=$_SESSION["cart"][$i];
        echo "<tr><td>".($i+1)."</td>";
        //echo "<td>".$item['id']."</td>";
        echo "<td>".$item['name']."</td>";
        //echo "<td>".$item['description']."</td>";
        echo "<td>".$item['price']."</td>";
        $total+=$item['price'];
    }
echo "</table>";
?>
<br/>
<?php
echo "ราคาสินค้า $total บาท";
?>
<br/>
<?php
echo "<h2>ที่อยู่ในการจัดส่งสินค้า</h2>";
echo "$fname $lname";
?>
    <br/>
<?php
echo "$address";
?>
    <br/>
<?php
echo "$mobile";
echo "</table>";
mysqli_close($conn);
//$result=mysqli_query($con,$sql);
//$numrow=mysqli_num_rows($result);
?>