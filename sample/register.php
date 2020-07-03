<?php
$username=$_POST['un'];
$password=$_POST['ps'];
$gender=$_POST['Gender'];
$email=$_POST['em'];
$phonecode=$_POST['phcd'];
$phone=$_POST['ph'];

if(!empty($username) || !empty($password) || !empty($gender) || !empty($email) || !empty($phonecode) || !empty($phone))
{
		$host="localhost";
		$dbUsername="root";
		$dbPassword="";
		$dbname="test";
		
		$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
		if(mysqli_connect_error())
		{
			die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
		}
		else
		{
			$SELECT = "SELECT username From register Where username = ? Limit 1";
			$INSERT = "INSERT Into register (username, password, gender, email, phonecode, phone) values(?, ?, ?, ?, ?, ?)";
			
			$stmt = $conn->prepare($SELECT);
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->bind_result($username);
			$stmt->store_result();
			$rnum = $stmt->num_rows;
			
			if($rnum==0)
			{
				$stmt->close();
				
				$stmt = $conn->prepare($INSERT);
				$stmt->bind_param("ssssii", $username, $password, $gender, $email, $phonecode, $phone);
				$stmt->execute();
				echo "Your Data Saved Sucessfully";
			}
			else
			{
				echo "Someone already registered using this details....";
			}
			$stmt->close();
			$conn->close();
		}
}
else
{
		echo"All fields are required";
		die();
}
?>