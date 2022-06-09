<?php
require_once '../connect.php';
if (isset($_POST['submit'])) {
    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['cpassword'])) {
        echo '<script type="text/javascript">alert("Input ay be Blank....!\n please Enter all inputs!");
	   window.location.href="forgot.html";
	   </script>';
    } else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
        if ($password !== $cpassword) {
            echo '<script type="text/javascript">alert("password does not match please enter your passwords correctly");</script>';
        } else {

            $query = "SELECT * FROM `register` WHERE `email` = ? ";
            //create prepared statement
            $stmt = mysqli_stmt_init($conn);
            //prepare statement
            if (!mysqli_stmt_prepare($stmt, $query)) {
                echo '<script  type="text/javascript">
			    alert("SQL Prepared Statement Execution 404 Error.........!");
			    window.location.href="forgot.html";

		 </script>';
                exit();
            } else {
                //bind paremeters to the placeholder
                mysqli_stmt_bind_param($stmt, "s", $email);
                //run the prepared parem
                mysqli_stmt_execute($stmt);
                //get result from executed statement
                $result = mysqli_stmt_get_result($stmt);
                //fetch data from database
                if ($row = mysqli_fetch_assoc($result)) {
                    echo "email found";
                    echo $row['email'];
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                    echo $hash_pass;
                    $sql = "UPDATE  `register` SET `password` = ?  WHERE `email`= ?;";
                    //create prepared statment
                    $stmt = mysqli_stmt_init($conn);
                    // //prepare prepared statement
                    $result = mysqli_prepare($conn, $sql);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo '<script type="text/javascript">
					   alert("password updation Prepared Statement Execution 404 Error.........!");
					   window.location.href="forgot.html";

				</script>';
                        exit();
                    } else {
                        echo "correct";
                        //bind variable to statement as parameter
                        echo "</br>" . mysqli_stmt_bind_param($result, 'ss', $row, $hash_pass);
				         //execute prepared statement
                       if(mysqli_stmt_execute($result)==1){
					echo '<script type="text/javascript">
					alert("password updation  Execution  is done successfully");
					window.location.href="recover.html";
			  </script>';
				   }else{
					   echo "error";
				   }
                    
                    }
                } else {
                    echo '<script  type="text/javascript">
			        alert("Email Avilable in database chek password Execution 404 Error.........!");
			         window.location.href="forgot.html";

		          </script>';

                }
            }
        }

    } //close prepared statement
    //     mysqli_stmt_close($conn);
}