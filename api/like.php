<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "COSI127b";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['email'])){
        $email = $_GET['email'];
        header('Content-Type: application/json');

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $stmt = $conn->prepare(
                "SELECT l.mpid
                FROM Likes l
                WHERE l.uemail = :email
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


} 
elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    $postData = json_decode(file_get_contents('php://input'), true);
    $mid = $postData['mid'];
    $email = $postData['email'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare(
            "INSERT INTO Likes (Likes.uemail, Likes.mpid) VALUES (:email, :mid)"
        );
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mid', $mid);

        $stmt->execute();

        $result = $stmt->fetchAll();
        echo json_encode(array("ok" => "ok"));
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
else {
    http_response_code(405);
    echo json_encode(array("error" => "error"));
}
?>

