<?php
session_start();
include 'connect.php';
error_reporting('0');
if (isset($_POST['register'])) {
    if (!empty(['name']) || !empty(['email']) || !empty(['contact']) || !empty($_POST['location']) || !empty(['city']) || !empty(['country']) || !empty(['password']) || !empty($_POST['cpassword'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
        if ($password !== $cpassword) {
            echo '
                <script  type="text/javascript">
                    alert("confarmation password does not match.......!");
                    window.location.href="../index.html";
                </script>';
        } else {
            //insert data using prepared statement
            $passhash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `register`(`fullname`, `email`, `contact`, `location`, `city`, `country` , `password`)VALUES(?,?,?,?,?,?,?);";
            //create prepared statement
            $stmt = mysqli_stmt_init($conn);
            //prepare prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                echo '<script  type="text/javascript">
                    alert("SQL prepare statement Error....!");
                    window.location.href="../index.html";
                </script>';
            } else {
                //bind prepared statement
                mysqli_stmt_bind_param($stmt, "ssissss", $name, $email, $contact, $location, $city, $country, $passhash);
                mysqli_stmt_execute($stmt);
                echo '<script  type="text/javascript">
                 let text = "Congraturations Your Registration Account Have been Successfully Created....!\nPlease Login \n THANK YOU!";
                    if(confirm(text) == true) {
                         window.location.href="../index.html";
                     }else{
                         alert("Error: in Registration");
                        window.location.href="../index.html";
                     }
                </script>';
            }
            //close connection
            mysqli_close($conn);
        }
    }
} else if (isset($_POST['loggin'])) {
    if (!empty($_POST['logEmail']) || !empty($_POST['logPassword'])) {
        $email = mysqli_real_escape_string($conn, $_POST['logEmail']);
        $pws = mysqli_real_escape_string($conn, $_POST['logPassword']);
        $query = "SELECT * FROM `register` WHERE `email` = ? OR password = ?";
        //create prepared stamtement
        $stmt = mysqli_stmt_init($conn);
        //prepare the prepared statement
        if (!mysqli_stmt_prepare($stmt, $query)) {
            echo '<script  type="text/javascript">
                     alert("SQL Prepared Statement Execution 404 Error.........!");
                     window.location.href="../index.html";
                 </script>';
            exit();
        } else {

            //bind paremeters to the placeholder
            mysqli_stmt_bind_param($stmt, "ss", $email, $pws);
            //run param inside db
            mysqli_stmt_execute($stmt);
            //get result from executed statement
            $result = mysqli_stmt_get_result($stmt);
            //fetch data from database
            if ($row = mysqli_fetch_assoc($result)) {
                // hashed password in database and compire with user inputchecks
                $passCheck = password_verify($pws, $row['password']);
                if ($passCheck == false) {
                    echo '<script  type="text/javascript">
                             alert("PassWord is Incorrect! Please Try again....!");
                             window.location.href="../index.html";
                        </script>';
                    /* echo '<script>window.location.href"../index.html";</script>'; */
                    exit();
                } else if ($passCheck == true) {
                    echo "<br>";
                    // echo "password is correct";
                    $_SESSION['fullname'] = $row['fullname'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['contact'] = $row['contact'];
                    $_SESSION['location'] = $row['location'];
                    $_SESSION['city'] = $row['city'];
                    $_SESSION['country'] = $row['country'];
                    $_SESSION['date'] = $row['date'];
                    echo '<script  type="text/javascript">
                           if(confirm("Congraturations Login successfully........!")) {
                                window.location.href="../../Products/index.html";
                            }else{
                                alert("You Have successfully  canceled your form submission!");
                               window.location.href="../index.html";
                            }
                         </script>';
                    echo "<br>";
                    // echo "FullName:" .  "<br>" . "<b>" . $row['fullname']  .  "<br>" . "<b>" . "email:" .  "<br>" . "<b>" . $row['email']  . "</b>" . "<br>" . "Encrpted password:" . "<br>" . "<b>" . $row['password'] .  "</b>" . "<br>" . "Date of Registration:" . "</b>" . $row['date'] . "</b>";
                } else {
                    echo "<br>";
                    echo '<script  type="text/javascript">
                             alert("Password doesn`t exist in database\n Please Use correct credentials....!");
                             window.location.href="../index.html";
                         </script>';
                }
            } else {
                echo '<script  type="text/javascript">
                alert("Error database search on such user found!");
                    window.location.href="../index.html";
                    </script>';
                exit();
            }
        }
    }
    mysqli_close($conn);
}