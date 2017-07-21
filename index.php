<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
       <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
      <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

 

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

<?php
require_once("conn.php");


$sql1="SELECT * FROM location";
$result=$conn->query($sql1);


$limit =10;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
$sqlEmployee = "SELECT * FROM employee LIMIT $start_from, $limit";  
$rs_result = $conn->query($sqlEmployee);


$sqle = "SELECT COUNT(id) FROM employee";  
$rs_results = mysqli_query($conn,$sqle);  
$row = mysqli_fetch_row($rs_results);  
$total_records = $row[0];  
$total_pages = ceil($total_records / $limit); 




$errors=array();
if(isset($_POST['add_submit'])){

if(!$_POST['first_name']=='' && !$_POST['last_name']==''){
$sql = "INSERT INTO employee (first_name, last_name, email,phone,address,city,state,zip) VALUES ('$_POST[first_name]', '$_POST[last_name]', '$_POST[email]','$_POST[phone]','$_POST[address]','$_POST[city]','$_POST[state]','$_POST[zip]')";

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

    $divBy10=$total_pages % 10;
    

    $url='index.php'.'?page='.$total_pages;
    header('Location: '.$url);
  
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

mysqli_close($conn);
}


?>
<div class="container-fluid" id="main-div-container">
    
         <div class="col-md-10 col-md-offset-1" id="table_div">

            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <div class="row">
                  <div class="col col-xs-6">
                    <h3 class="panel-title">Employee List</h3>
                  </div>
                 
                </div>
              </div>
              <div class="panel-body">
                <table class="table table-striped table-bordered table-auto">
                  <thead>
                    <tr>
                        <th><em class="fa fa-cog"></em></th>
                        <th class="hidden-xs">ID</th>
                        <th>first name</th>
                        <th>last name</th>
                          <th>email</th>
                            <th>mobile #</th>
                              <th>address</th>
                                  <th>city</th>  
                                  <th>state</th> 
                                  <th>zip</th>                        
                    </tr> 
                  </thead>
                  <tbody>
                      <?php while($employee=mysqli_fetch_assoc($rs_result)): ?>
                          <tr class="animated fadeIn">
                            <td align="center">
                              <a class="btn btn-default" href="index.php?edit=<?=$employee['id']; ?>"><em class="fa fa-pencil"></em></a>
                              <a class="btn btn-danger"href="index.php?edit=<?=$employee['id']; ?>"><em class="fa fa-trash"></em></a>
                            </td>
                            <td class="hidden-xs"><?=$employee['id'] ?></td>
                            <td><?=$employee['first_name'] ?></td>
                            <td><?=$employee['last_name'] ?></td>
                            <td><?=$employee['email'] ?></td>
                            <td><?=$employee['phone'] ?></td>
                            <td><?=$employee['address'] ?></td>
                            <td><?=$employee['city'] ?></td>
                            <td><?=$employee['state'] ?></td>
                            <td><?=$employee['zip'] ?></td>
                          </tr>
                           <?php endwhile; ?>
                        </tbody>
                </table>

                <?php  
 
$pagLink = "<div class='pagination'>";  
for ($i=1; $i<=$total_pages; $i++) {  
             $pagLink .= "<a class='btn btn-default btn-success' href='index.php?page=".$i."'>".$i."</a>";  
};  
echo $pagLink . "</div>";  
?>

              </div>

    <form class="well form-horizontal" action=" " method="post"  id="contact_form">
<fieldset>

<!-- Form Name -->
<legend class="text-center">Employee Information</legend>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label">First Name</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input  name="first_name" placeholder="First Name" class="form-control"  type="text" id="first_name">
    </div>
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Last Name</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="last_name" placeholder="Last Name" class="form-control"  type="text" id="last_name">
    </div>
  </div>
</div>

<!-- Text input-->
       <div class="form-group">
  <label class="col-md-4 control-label">E-Mail</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  <input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
    </div>
  </div>
</div>


<!-- Text input-->
       
<div class="form-group">
  <label class="col-md-4 control-label">Mobile #</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
  <input name="phone" placeholder="+639398329162" class="form-control" type="text">
    </div>
  </div>
</div>

<!-- Text input-->
      
<div class="form-group">
  <label class="col-md-4 control-label">Address</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
  <input name="address" placeholder="Address" class="form-control" type="text">
    </div>
  </div>
</div>

<!-- Text input-->
 
<div class="form-group">
  <label class="col-md-4 control-label">City</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
  <input name="city" placeholder="city" class="form-control"  type="text">
    </div>
  </div>
</div>

<!-- Select Basic -->
   
<div class="form-group"> 
  <label class="col-md-4 control-label">State</label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    
    <select name="state" class="form-control selectpicker" >
    
      <option value=" " >Please select your state</option>
          <?php while($location=mysqli_fetch_assoc($result)): ?>
      <option><?=$location['state']; ?></option>
          <?php endwhile; ?>
    </select>

  </div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label">Zip Code</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
  <input name="zip" placeholder="Zip Code" class="form-control"  type="text">
    </div>
</div>
</div>

<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button type="submit" class="btn btn-danger btn-large" name="add_submit" id="register" disabled>Save <span class="glyphicon glyphicon-save"></span></button>
  </div>
</div>

</fieldset>
</form>
</div>

    <hr />


            
    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
       <script src="js/main.js"></script>
  </body>
</html>