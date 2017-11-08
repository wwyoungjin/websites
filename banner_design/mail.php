	<?php 
	
	//if page requested by post method
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//if value submitted in name input is empty
		if(empty($_POST["name"])){
			//variable to hold error message
			$nameError = "Name is required";
		} else{
			//else not empty, prep/clean data
			$name = test_input($_POST["name"]);
			
			//if not letters and whitespace 
			if(!preg_match("/^[a-zA-Z ]*$/", $name)){
				//variable to hold error message
				$nameError = "Only letters and whitespace allowed";
			}
		}
		
		//if value submitted in email input is empty
		if(empty($_POST["email"])){
			//variable to hold error message
			$emailError = "Email is required";
		} else{
			//else not empty, prep/clean data
			$email = test_input($_POST["email"]);
			
			//if email is not valid
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				//variable to hold error message
				$emailError = "Invalid email";
			}
			
		}
	
		$message = test_input($_POST["message"]);

		//if there is no email/name error, then send email using mail()
		if(!$nameError && !$emailError){
			$to="youngjinjo@outlook.com";
			$subject = "this is a message from my website.";
			$message = wordwrap($message, 140, "\r\n");
			$hearders ="From: ". $name. "<". $email. ">"; 

			mail($to, $subject, $message, $headers);

			echo '<div class="thankyou">Thank you for your email</div>';
		}else{
			echo '<div class="error-msg">Validation Errors, email not sent</div>'; 
		}
	}
	
	//preps and cleans our data
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
		
		
	?>	
	
	<form action="<?php echo
		htmlspecialchars($_SERVER["PHP_SELF"]);?>"
		method="post">
		
		<label for="name">Name: 
			<input type="text" name="name">
		</label>
		<span class="error">
			<?php echo $nameError; ?>
		</span>
		<br/>
		
		<label for="email">E-mail: 
			<input type="text" name="email">
		</label>
		<span class="error">
			<?php echo $emailError; ?>
		</span>	
		<br/>
		
		<label for="message">Message:</label><br/>
		<textarea name="message" rows="5">
		</textarea><br/>
		
		<input type="submit" value="Submit">
	
	</form>

