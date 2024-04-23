<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "mydb";
$conn = "";

try {
    $conn =  mysqli_connect(
        $db_server,
        $db_user,
        $db_pass,
        $db_name
    );
} catch (mysqli_sql_exception) {
    echo "could not connect <br>";
}

try {
    $sql = "CREATE TABLE IF NOT EXISTS us (
        id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user varchar(25) NOT NULL,
        reg datetime NOT NULL DEFAULT current_timestamp()
        )";
    mysqli_query($conn, $sql);
} catch (mysqli_sql_exception) {
}
