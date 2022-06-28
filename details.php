<?php
  if(!isset($_POST['login'])){
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
    <link type="text/css" rel="stylesheet" href="style2.css?version=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <title>Transactions</title>
</head>

<body>
  <nav>
     <div class="logo">SwiftBank</div>
     <input type="checkbox" id="click">
     <label for="click" class="menu-btn">
     <i class="fas fa-bars"></i>
     </label>
     <ul>
     <li>
      <form method="post" action="transfer.php?cid=<?php echo $_GET['cid'];?>" align="left">
       <input id="transfer_btn" type="Submit" name="transfer_money" value="Transfer Money"/>
      </form>
     </li>
     <li><a href="index.html">Home</a></li>
     <li><a>About</a></li>
     <li><a>Services</a></li>
     <li><a>Contact</a></li>
     <li><a>Feedback</a></li>
    </ul>
  </nav>
  <br>

  <h1 id="heading">DETAILS</h1><br>

  <?php
  $conn=new mysqli("localhost","root","","bank");
  if($conn->connect_error){
  	?>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">Failed to get data.</span></p>
  	<?php
  }
  else{
  	$cid=$_GET['cid'];
  	$sql="select * from customer where cid='$cid';";
  	$bal="select account_balance from account_ where cid='$cid';";
  	$result=$conn->query($sql) or die($conn->error);;
    // echo $conn->query($sql);
  	$bal_result=$conn->query($bal);
  	if($result->num_rows>0){
  		$row=$result->fetch_assoc();
  		$bal_row=$bal_result->fetch_assoc();
  ?>
  <div class="div2">
  <table id="table1">
  <tr>
  <td style="font-weight: bold">Customer_ID:</td>
  <td><?php echo $cid;?></td>
  </tr>
  <tr>
  <td style="font-weight: bold">Name:</td>
  <td><?php echo $row['first_name']." ".$row['last_name'];?></td>
  </tr>
  <tr>
  <td style="font-weight: bold">Gender:</td>
  <td><?php echo $row['gender'];?></td>
  </tr>
  <tr>

  <td style="font-weight: bold">Address:</td>
  <td><?php echo $row['address'];?></td>
  </tr>
  <tr>
  <td style="font-weight: bold">Email ID:</td>
  <td><?php echo $row['email_id'];?></td>
  </tr>
  <tr>
  <td style="font-weight: bold">Phone number:</td>
  <td><?php echo $row['phone'];?></td>
  </tr>
  <tr>
  <td style="font-weight: bold">Date of Birth:</td>
  <td><?php echo $row['dob'];?></td>
  </tr>
  <tr>
  <td style="font-weight: bold">Current Balance:</td>
  <td><?php echo "Rs. ".$bal_row['account_balance'];?></td>
  </tr>
  </table>


  <?php
  	}//inner if
  else{
  	?>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">Failed to get data.</span></p>

  	<?php
  }
  ?>
  </div>

  <?php
  $sql_a="select account_number from account_ where cid='$cid';";
  $result_a=$conn->query($sql_a);
  if($result_a->num_rows>0){
  	while($rowa=$result_a->fetch_assoc())
  	   $acc_n=$rowa['account_number'];
  }
  //$sql2="select * from transaction where sender_account_number IN (select sender_account_number from transaction inner join account_ on transaction.sender_account_number=account_.account_number where account_.cid=$cid)";
  $sql2="select * from transaction where sender_account_number=$acc_n";
  $result2=$conn->query($sql2);
  if($result2->num_rows>0){
  ?>

  <div style = "clear:both;"></div>
  <br>
  <div class="div2">
  <table id="table2">
  <thead>
  <tr>
  <th>To</th>
  <th>Account no.</th>
  <th>Amount</th>
  <th>Date</th>
  </tr>
  <thead>
  <?php
  while($row2=$result2->fetch_assoc()){
  	$receiver=$row2['receiver_account_number'];
  	$sql3="select first_name,last_name from customer where cid IN (select cid from account_ where account_number=$receiver)";
      $result3=$conn->query($sql3);
  if($result3->num_rows>0){
  while($row3=$result3->fetch_assoc()){
  	?>
  	<tbody>
  <tr>
  <td><?php echo $row3['first_name']." ".$row3['last_name'];?></td>
  <td><?php echo $row2['receiver_account_number'];?></td>
  <td><?php echo "Rs. ",$row2['amount'];?></td>
  <td><?php echo $row2['date_time'];?></td>
  </tr>

  <?php
  }//inner while
  }//inner if
  else{
  	?>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">Failed to get data.</span></p>
  	<?php
  }
  }//while
  ?>
  <tbody>
  </table>
  </div>
  		<?php
  }//if
  else{
  	?>
  	<br>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">No sent transactions.</span></p>
  	<?php
  }
  //-------------------------------When user is receiver

  $sql2="select * from transaction where receiver_account_number=$acc_n";
  $result2=$conn->query($sql2);
  if($result2->num_rows>0){
  ?>
  <div style = "clear:both;"></div>
  <br>
  <div class="div2">
  <table id="table2">
  <thead>
  <tr>
  <th>From</th>
  <th>Account no.</th>
  <th>Amount</th>
  <th>Date</th>
  </tr>
  <thead>
  <?php
  while($row2=$result2->fetch_assoc()){
  	$sender=$row2['sender_account_number'];

  	$sql3="select first_name,last_name from customer where cid IN (select cid from account_ where account_number=$sender)";
      $result3=$conn->query($sql3);
  if($result3->num_rows>0){
  while($row3=$result3->fetch_assoc()){
  	?>
  	<tbody>
  <tr>
  <td><?php echo $row3['first_name']." ".$row3['last_name'];?></td>
  <td><?php echo $sender;?></td>
  <td><?php echo "Rs. ",$row2['amount'];?></td>
  <td><?php echo $row2['date_time'];?></td>
  </tr>

  <?php
  }//inner while
  }//inner if
  else{
  	?>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">Failed to get data.</span></p>
  	<?php
  }
  }//while
  ?>
  <tbody>
  </table>
  </div>
  <?php
  }//last table if
  else{
  	?>
  	<br>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">No received transactions.</span></p>
  	<?php
  }//else
  			$conn->close();
  }//outer else conn
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
