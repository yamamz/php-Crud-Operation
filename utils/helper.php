<?php

class HelperSql{


function deleteEmployee($conn){
if(isset($_GET['delete']) && !empty($_GET['delete'])){

  $delete_id=(int)$_GET['delete'];
  $dsql="DELETE FROM employee WHERE id='$delete_id'";
$conn->query($dsql);
   header('Location: index.php');
}
}

function searchEmployees($page,$con,$limit){

$start_from = ($page-1) * $limit;
$sqlEmployee = "SELECT * FROM employee LIMIT $start_from, $limit";
return $rs_result = mysqli_query($con,$sqlEmployee);
}

function getNumberOfPage($con,$limit){
$sqle = "SELECT COUNT(id) FROM employee";
$rs_results = mysqli_query($con,$sqle);
$row = mysqli_fetch_row($rs_results);
$total_records = $row[0];
return $total_pages = ceil($total_records / $limit);
}

function insertEmployee($conn){
    if(isset($_POST['add_submit'])){
     $first_name=htmlentities($_POST['first_name']);
    $last_name=htmlentities($_POST['last_name']);
    $email=htmlentities($_POST['email']);
    $phone=htmlentities($_POST['phone']);
    $address=htmlentities($_POST['address']);
    $city=htmlentities($_POST['city']);
    $state=htmlentities($_POST['state']);
    $zip=htmlentities($_POST['zip']);

if(!$_POST['first_name']=='' && !$_POST['last_name']==''){
$sql = "INSERT INTO employee (first_name, last_name, email,phone,address,city,state,zip) VALUES ('$first_name', '$last_name', '$email','$phone','$address','$city','$state','$zip')";

if(mysqli_query($conn, $sql)) {

    echo "New record created successfully";
    $_POST['first_name']='';
    $_POST['last_name']='';
    $_POST['email']='';
    $_POST['phone']='';
    $_POST['address']='';
    $_POST['city']='';
    $_POST['state']='';
    $_POST['zip']='';


   // $urls='index.php'.'?page='.$total_pages;
    header('Location:index.php');

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}


}

}

}

?>
