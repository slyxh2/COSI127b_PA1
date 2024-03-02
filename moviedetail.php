<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Bootstrap JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSI 127b</title>
    
</head>
<body>

    <div class="container">
        <?php
        // Check if the 'p' parameter is set in the URL
        if (isset($_GET['id'])) {
            // Retrieve the value of the 'p' parameter
            $movieId = $_GET['id'];

            // Use the parameter value as needed
        } else {
            // 'p' parameter is not set in the URL
            echo "'id' parameter is not present in the URL.";
        }



        // SQL CONNECTIONS
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";

        try {
            // We will use PDO to connect to MySQL DB. This part need not be 
            // replicated if we are having multiple queries. 
            // initialize connection and set attributes for errors/exceptions
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare statement for executions. This part needs to change for every query
            $stmt = $conn->prepare("
                SELECT mp.`name`, mp.production, mp.budget, mp.rating,m.boxoffice_collection FROM Movie m
                JOIN MotionPicture mp
                WHERE m.mpid = mp.id && m.mpid = $movieId
            ");

            // execute statement
            $stmt->execute();

            for ($i = 0; $row = $stmt->fetch(PDO::FETCH_ASSOC); $i++) {
                $name = $row['name'];
                $production = $row['production'];
                $budget = $row['budget'];
                $rating = $row['rating'];
                $boxoffice_collection = $row['boxoffice_collection'];
            
                echo "<h1 style='text-align:center'>$name</h1>";
                // echo "<h1 style='text-align:center'>$production</h1>";
                // echo "<h1 style='text-align:center'>$budget</h1>";
                // echo "<h1 style='text-align:center'>$rating</h1>";
                // echo "<h1 style='text-align:center'>$boxoffice_collection</h1>";

            }
            // // for each row that we fetched, use the iterator to build a table row on front-end
            // foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            //     echo $v;
            // }
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo "<h2>User Like This Movie</h2>";
        echo "<table class='table table-md table-bordered'>";
        echo "<thead class='thead-dark' style='text-align: center'>";

         echo "<tr>
         <th>email</th>
         <th>name</th>
         <th>age</th>
         </tr>
         </thead>";
        echo "</table>";
        $conn = null;    
    ?>

    </div>
</body>
</html>
