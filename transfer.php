<?php
if(!isset($_POST['Transfer']) && !isset($_POST['Send'])){//these both are not start at first, if we use || then if even one of them is not set it will redirect
  if(!isset($_POST['transfer_money'])){
    header("Location: index.html");
  }
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta http-equiv="X-UA-Compatible"
          content="IE=edge" />
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" />
    <link type="text/css" rel="stylesheet" href="style3.css?version=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <title>Transfer Money</title>
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

  <h1 id="heading">Net Banking Portal</h1><br>

  <?php
  if(isset($_POST['Send'])){
  	$conn=new mysqli("localhost","root","","bank");
  	if(!$conn->connect_error){
  		$sender_cid=$_GET['cids'];
  		$receiver_cid=$_GET['cidr'];
  		$sql1="select account_balance,account_number from account_ where cid=$sender_cid";
  		$result1=$conn->query($sql1);
     if($result1->num_rows>0){
  		 while($row1=$result1->fetch_assoc()){
  			 $account_balance=$row1['account_balance'];
         if(!is_numeric($_POST['amount'])){
           //popup
           //window.history.go(-1)
           ?>
           <script>
                window.history.go(-1.0);
           </script>
           <?php
         }//if value entered is not numeric
  			 if($_POST['amount']<=$account_balance){
  				 $sql3="select branch_ifsc from branch where branch_id=(select branch_id from account_ where cid=$sender_cid)";
  			   $result3=$conn->query($sql3);
  			   while($row3=$result3->fetch_assoc())
  			   $sender_ifsc=$row3['branch_ifsc'];
  			  $sql4="select branch_ifsc from branch where branch_id=(select branch_id from account_ where cid=$receiver_cid)";
  			   $result4=$conn->query($sql4);
  			   while($row4=$result4->fetch_assoc())
  			     $receiver_ifsc=$row4['branch_ifsc'];
  			     $amount=$_POST['amount'];
  			   $sender_acc=$row1['account_number'];
  			   $sql5="select account_number from account_ where cid=$receiver_cid";
  			   $result5=$conn->query($sql5);
  			   while($row5=$result5->fetch_assoc())
  			     $receiver_acc=$row5['account_number'];
  			       $date_time=strval(date("Y-m-d"));
  			       //echo $date_time;
  			       $sql6="insert into transaction(sender_account_number,receiver_account_number,sender_ifsc,receiver_ifsc,amount,date_time,payment_method_id) values($sender_acc,$receiver_acc,'$sender_ifsc','$receiver_ifsc',$amount,'$date_time',1)";
  						 if($conn->query($sql6)){
  		 	        $sql7="update account_ set account_balance=account_balance+$amount where account_number=$receiver_acc";
  		 	        $sql8="update account_ set account_balance=account_balance-$amount where account_number=$sender_acc";
  		 	        if($conn->query($sql7) && $conn->query($sql8)){
  								?>
  								<div class="popup">
  									<div class="popup2">
  										<img class="close" src="close1.png" style="width:10%;"/>
  										<img id="icon" src="tick.jpg" style="width:50%;" alt="Success!!"/><br>
                      <div class="popup-text1">
  										<b>Payment Successful</b>
                    </div>
  									</div>
  								</div>
  								<?php
  							}//if account details updated, then payment Successful!!!!!!!!
  						}//if inserted into transaction successful
  			 }//if the user has enough Balance
  			 else{
  				     ?>
               <div class="popup">
                 <div class="popup2">
                   <img class="close" src="close1.png" style="width:10%;"/>
                   <img id="icon" src="warn.png" style="width:35%;" alt="Success!!"/><br>
                   <div class="popup-text1">
                   <b>Not Enough Balance.</b>
                 </div>
                 </div>
               </div>
  	          <?php
  			 }//else not enough balance
  			 ?>
  			 <script>
  			 		document.querySelector(".close").addEventListener("click",function(){
  			 			window.history.go(-2.0);
  			 		//document.querySelector(".popup").style.display="none";
  			 	})
  			 </script>
  			 <?php
  		 }//outer while
  	 }//if first query Successful
  	}//if conn is Successful
  }//if send button is clicked------------------------------------

  else{ //because you're opening same page so the code after this will also exec if else not there
  if(isset($_POST['Transfer'])){//if Transfer button is pressed
    $conn=new mysqli("localhost","root","","bank");
  	if(!$conn->connect_error){
  	$s=$_GET['cids'];
  	$r=$_GET['cidr'];
    $sql1="select account_balance from account_ where cid=$s";
    $result1=$conn->query($sql1);
    if($result1->num_rows>0){
      while($row1=$result1->fetch_assoc()){
    $sql2="select first_name,last_name from customer where cid=$r";
    $result2=$conn->query($sql2);
    if($result2->num_rows>0){
      while($row2=$result2->fetch_assoc()){
  ?>
  <div class="popup">
  	<div class="popup-content">
  		<img class="close" src="close1.png" style="width:10%;"/>
    <div align="center">
  		<img id="wallet" src="wallet.png" alt="Transfer"/></div>
      <div class="popup-text">
     <b>Your account balance: </b><?php echo "Rs. ".$row1['account_balance'];?><br><br>
  	 <b>Transfer to: </b><?php echo $row2['first_name']." ".$row2['last_name']; ?><br><br>
  	 <b>Enter amount: </b><?php ?><br>
  	 <form action="transfer.php?cids=<?php echo $s;?>&cidr=<?php echo $r;?>" method="post">
  	 Rs. <input id="amount" type="text" name="amount"/>
      </div>
  		 <div align="center"><br>
  	   <input class="send" type="submit" name="Send" value="Send" style=""/>
  	   </div>
  	 </form>
  	</div>
  </div>

  <script>
  		document.querySelector(".close").addEventListener("click",function(){
  			window.history.back();
  		//document.querySelector(".popup").style.display="none";
  	})
  </script>

  	<?php
           }//while
         }//sql1 if
       }//while
     }//sql1 if
   }//conn if
  }//if Tranfer button end-------------------
  else{
  	?>


  <?php
  $conn=new mysqli("localhost","root","","bank");
  if($conn->connect_error){
  	?>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">Failed to get data.</span></p>
  	<?php
  }//if
  else{
  	$c=(int)$_GET['cid'];
  	$sql="select cid,first_name,last_name from customer where cid!=$c";
  	$result=$conn->query($sql);
  		if($result->num_rows>0){
  		?>
  		<div class="div2">
  		<table id="table1">
  			<thead><tr>
  		<th>Name</th>
  		<th>Transfer To</th></tr></thead>
  		<?php while($row = $result->fetch_assoc()){ ?>
  			<tbody>
  		<tr>
  		<td>
  		<?php echo $row['first_name']." ".$row['last_name'];?>
  		</td>
  		<td align="center">
  <form method="post" action="transfer.php?cids=<?php echo $c;?>&cidr=<?php echo $row['cid'];?>">
  	<input id="status" type="Submit" name="Transfer" value="Select"/>
  </form>
  		</td>
  		</tr>
  	</tbody>
  		<?php
  		}//while
  		?>
  		</table>
  		</div>
  		<?php
  	}//if there re rows
  	else{
  		?>
  <p style="margin: 0 auto;text-align:center;"><span style="color:white;background-color:	#CD5C5C;border-radius:6px;font-size:20px;letter-spacing: 3px;font-family:monospace;font-weight:600;">Failed to get data.</span></p>
  		<?php
  	}//inner else
  }//else
  }//else Transfer btn is not set
  }//else Send button is not yet set
   ?>

</body>
</html>
