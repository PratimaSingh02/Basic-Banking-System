<?php
  if(!isset($_POST['view_customer'])){
    header("Location: index.html");
  }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta http-equiv="X-UA-Compatible"
          content="IE=edge" />
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" />
    <link type="text/css" rel="stylesheet" href="style1.css?version=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <title>Login</title>
</head>

<body>
  <nav>
     <div class="logo">SwiftBank</div>
     <input type="checkbox" id="click">
     <label for="click" class="menu-btn">
     <i class="fas fa-bars"></i>
     </label>
     <ul>
     <li><a href="index.html">Home</a></li>
     <li><a>About</a></li>
     <li><a>Services</a></li>
     <li><a>Contact</a></li>
     <li><a>Feedback</a></li>
    </ul>
  </nav>
  <br>

  <h1 id="heading">CUSTOMERS</h1><br>

  <?php
  $conn=new mysqli("localhost","root","","bank");
  if($conn->connect_error){
  	?>
  	<p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">Failed to get data.</span></p>
  	<?php
  }
  else{
  //	echo "Successful";
  $sql="select first_name,last_name,cid,phone from customer";
  $result=$conn->query($sql);
  if($result->num_rows>0){
  	?>
  <div class="div2">
  <table id="table1">
  <thead>
  <tr>
  <th>Name</th>
  <th>Customer_Id</th>
  <th>Phone</th>
  <th>Login As</th>
  </tr>
  </thead>

  <tbody>
  <?php
  while($row = $result->fetch_assoc()) {
  	?>
  	<tr>
  	<form method="post" action="details.php?cid=<?php echo $row["cid"];?>">
  	<td><?php echo $row["first_name"]." ".$row["last_name"];?></td>
  	<td><?php echo $row["cid"];?></td>
  	<td><?php echo $row["phone"]?></td>
  	<td><input id="status" type="submit" name="login" value="LOGIN"/></td>
  	</form>
  	</tr>
  	<?php
  }//while
  ?>
  </tbody>
  </table>
  </div>

  <br>
  <?php
  }//inner if
  else{
  	?>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">Failed to get data.</span></p>

  	<?php
  }
  }//outer else
  ?>

  <script>
    document.querySelector(".menu-btn").addEventListener("click",function(){
      var checkBox = document.getElementById("click");
      if(checkBox.checked==true)
        document.getElementById("div2").style.display="block";
        else
          document.getElementById("div2").style.display="none";
    })
  </script>

</body>
</html>
