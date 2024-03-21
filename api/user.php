<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['email'])){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        $email = $_GET['email'];
        header('Content-Type: application/json');

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $stmt = $conn->prepare(
                "SELECT u.name, u.email, u.age
                FROM User u
                WHERE u.email = :email
                "
            );
            $stmt->bindParam(':email', $email);

            $stmt->execute();

            $result = $stmt->fetchAll();
            echo json_encode($result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


} else {
    http_response_code(405);
    echo json_encode(array("error" => "error"));
}
?>

