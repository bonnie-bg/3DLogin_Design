<?php
$conn = mysqli_connect('localhost', 'root', '', 'E_commercedb1');
if (mysqli_connect_error()) {
    die('Connection failed (' . mysqli_connect_error() . ')' . mysqli_connect_errno());
}

// } else if ($conn == true) {
//     $sql = "CREATE DATABASE IF NOT EXISTS E_commercedb";
//     if (mysqli_query($conn, $sql) == TRUE) {
//         $sql = "CREATE TABLE E_commercedb.register(
//           fullname VARCHAR(255) NOT NULL ,
//           email VARCHAR(255) NOT NULL ,
//           contact INT(12) NOT NULL ,
//           location VARCHAR(255) NOT NULL ,
//           city VARCHAR(255) NOT NULL ,
//           country VARCHAR(255) NOT NULL ,
//           password VARCHAR(255) NOT NULL ,
//           date  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
//           PRIMARY KEY (`email`)
//         ) ENGINE = InnoDB;";

//         if (mysqli_query($conn, $sql)) {
//             echo "Table MyGuests created successfully";
//         } else {
//             echo "Error creating table: " . mysqli_error($conn);
//         }
//     } else {
//         echo "Error creating database: " . mysqli_error($conn);
//     }

//     mysqli_close($conn);
// }

// sql to create table