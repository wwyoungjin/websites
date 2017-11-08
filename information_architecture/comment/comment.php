<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My Comments</title>
</head>

<body>
	
	<?php
	//if add url query, then include the add form
	if(isset($_GET['add']) && !$_POST['action'] == 'edit'){
		include("add.php");
	} else {
		echo '<a href="?add" class="btn btn-primary">Add Comment</a>';
	}
	
	?>
	
	<?php 
	//server credentials
	$servername = "localhost";
	$username = "young962";
	$password = "ERer3434#";
	$dbname = "young962_comments";

	//create our database object
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	//establish connection, if connection error
	if ($conn->connect_error) {
     	die("Connection failed: " . $conn->connect_error);
	}	
	
	//ADDING Comments
	//make sure that we've sent a variable
	//if our commenttext variable is set (using POST method)
	if(isset($_POST['commenttext']) && !isset($_GET['update'])){
		
		$sql = 'INSERT INTO comment SET
				commentname = "' . $_POST['commentname'] . '",
				commentemail = "' . $_POST['commentemail'] . '",
				commenttext = "' . $_POST['commenttext'] . '",
				commentdate = "' . $_POST['commentdate'] . '"';
		
		if($conn->query($sql) === TRUE){
			echo "new data added, yay!";
		} else{
			echo "you have an error: " . $conn->error;
		}
	}
	
	//EDITING comment FORM
	if(isset($_POST['action']) && $_POST['action'] == 'edit'){
		
		//sql statement to get comment being edited
		$sql = 'SELECT id, commentname, commentemail, commenttext, commentdate FROM comment 
				WHERE id=' . $_POST['id'];
		$result = $conn->query($sql);		
		
		if($result->num_rows > 0){
			
			while($row = $result->fetch_assoc()){
		?>
			
			<form action="?update" method="post" class="default">
	
				<label for="commenttext">Edit name:
				</label><br/>
				<textarea id="commentname" name="commentname" rows="1" cols="40"><?php echo $row["commentname"];?></textarea><br/>
				<label for="commenttext">Edit email:
				</label><br/>
				<textarea id="commentemail" name="commentemail" rows="1" cols="40"><?php echo $row["commentemail"];?></textarea><br/>
				<label for="commenttext">Edit comment:
				</label><br/>
				<textarea id="commenttext" name="commenttext" rows="3" cols="40"><?php echo $row["commenttext"];?></textarea><br/>
					
				<label for="commentdate">Date:
				<input type="date" name="commentdate" id="commentdate"
				value="<?php echo $row['commentdate'];?>">
				</label>
				
				<input type="hidden" name="id" value="<?php echo $row['id']?>">
				<br/>
				<input class="btn sm" type="submit" value="Update comment">
					
			</form>
			<br/>
			
		
		<?php
					
			}//end of while loop
			
		}//end of if num_rows
		
	}//end of editing comment
	
	
	//UPDATE comment 
	if(isset($_GET['update'])){
		
		$sql = 'UPDATE comment SET
				commentname = "' . $_POST['commentname'] . '",
				commentemail = "' . $_POST['commentemail'] . '", 
				commenttext = "' . $_POST['commenttext'] . '",
				commentdate = "' . $_POST['commentdate'] . '"
				WHERE id =' . $_POST['id'];
		
		//if successfully updates db
		if($conn->query($sql) === TRUE){
			echo "updated!";
			
		} else{
			echo "error" . $conn->error;	
		}	
		
	}
	
	
	
	//DELETING comment
	//if there is the $_POST variable 'delete' in our URL
	if(isset($_POST['action']) && $_POST['action'] == 'delete'){
		
		//delete sql statement
		$sql = 'DELETE FROM comment WHERE id =' . $_POST['id'];
		
		//if success/error
		if($conn->query($sql) === TRUE){
			echo "your data is deleted";	
		} else{
			echo "you have an error" . $conn->error;
		}
		
	}
	
	//RETRIEVING ALL comments	
	//variable to hold our SQL command
	//selects id, commenttext, commentdate from our comment TABLE
	$sql = "SELECT id, commentname, commentemail, commenttext, commentdate FROM comment";
	//execute SQL query
	$result = $conn->query($sql);
	
	//if there is rows in our table
	if ($result->num_rows > 0) {
	     
	     //for each row, echo our id, commenttext, commentdate
	     while($row = $result->fetch_assoc()) {
         echo "<p>". $row["id"]. "&nbsp;&nbsp;&nbsp;&nbsp;". $row["commentname"]. "&nbsp;&nbsp;&nbsp;&nbsp;". $row["commentemail"]. "&nbsp;&nbsp;&nbsp;&nbsp;". $row["commentdate"] . "<br/>". $row["commenttext"].  "</p>";
    ?>   
		<?php //edit and delete form ?>	      	
	     <form action="<?php $_POST['action']?>" method="post">
	     	<input type="hidden" name="id" value="<?php echo $row['id']?>">
			 	<input class="btn sm" type="submit" name="action" value="delete">
			 	<input class="btn sm" type="submit" name="action" value="edit">
	     </form>
	     <br/>	     
	     
	<?php     
	     }
	     
	//if there are no rows, then echo 0 results     
	} else {
	     echo "0 results";
	}
	
	//close connection
	$conn->close();
			
	?>	
	
  
</body>
</html>