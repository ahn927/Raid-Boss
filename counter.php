<?php

    session_start();
    $servername = "localhost";
    $dblogin = "root";
    $pwd = "root";
    $dbname = "tapncook";

    $methodType = $_SERVER['REQUEST_METHOD'];
    $data = array("msg" => "$methodType");

    if ($methodType === 'GET') {

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $pwd);

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $uName = $_SESSION["username"];
            $sql = "UPDATE user SET user.counter = user.counter + 1 WHERE user.user_name = ?";

            $statement = $conn->prepare($sql);
            $statement->execute(array($uName));

            $data = array("msg" => $uName);
        } catch(PDOException $e) {
            $data = array("msg" => $e->getMessage());
        }
    } else {
        $data = array("msg" => "Error: only GET allowed");
    }

    echo json_encode($data, JSON_FORCE_OBJECT);

?>