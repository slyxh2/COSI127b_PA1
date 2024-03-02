<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Bootstrap JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="./javascript/movie.js" defer></script>

    <link rel="stylesheet" href="./style/movie.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSI 127b</title>
</head>
<body>
    <div class="container">
        <h1 style="text-align:center">Movies</h1><br>
    </div>
    <div class="container">
        <form id="ageLimitForm" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter minimum Rating" name="inputAge" id="inputAge">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="submitted" id="button-addon2">Query</button>
                </div>
            </div>
        </form>
        <form id="ageLimitForm" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter Movie's Name" name="inputAge" id="inputAge">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="submitted" id="button-addon2">Query</button>
                </div>
            </div>
        </form>
        <h3>Please Click Each Row to go to the Like Table for each Movie</h3>
    </div>
    <div class="container">
        <?php

        echo "<table class='table table-md table-bordered'>";
        echo "<thead class='thead-dark' style='text-align: center'>";

         echo "<tr>
         <th>Name</th>
         <th>Production</th>
         <th>budget</th>
         <th>rating</th>
         <th>Box Collection</th>
         </tr>
         </thead>";

        class TableRows extends RecursiveIteratorIterator {
            private $isFirstIteration = true;

            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }

            function current() {
                $mpId = parent::current();

                if ($this->isFirstIteration) {
                    $this->isFirstIteration = false;
                    return "";
                } else {
                    return "<td data-id='$mpId' style='text-align:center'>$mpId</td>";
                }
            }

            function beginChildren() {
                $mpId = parent::current();
                echo "<tr movie_id='$mpId' class='movie_table_row'>";
            }

            function endChildren() {
                $this->isFirstIteration = true;
                echo "<td  style='text-align:center'><button class='like_btn'>Like It</button></td>";
                echo "</tr>" . "\n";
            }
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
            $stmt = $conn->prepare(
                "SELECT mp.id, mp.`name`, mp.production, mp.budget, mp.rating, m.boxoffice_collection 
                FROM Movie m
                JOIN MotionPicture mp
                WHERE m.mpid = mp.id"
            );

            // execute statement
            $stmt->execute();

            // set the resulting array to associative. 
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // for each row that we fetched, use the iterator to build a table row on front-end
            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                echo $v;
            }
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo "</table>";
        // destroy our connection
        $conn = null;
    
    ?>

    </div>
</body>
</html>
