<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Bootstrap JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="./style/movie.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSI 127b</title>
</head>
<body>
    <div class="container">
        <h1 style="text-align:center">American Producers Collection</h1><br>
    </div>
    <div class="container">

        <form id="nameForm" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter Min Box Office Collection" name="collection">
                <input type="text" class="form-control" placeholder="Enter Max Budget" name="budget">

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="rangeSubmit">Query</button>
                </div>
            </div>
        </form>

    </div>

    <div class="container">
        <table class='table table-md table-bordered'>
            <thead class='thead-dark' id="motion-thread">

            </thead>
            <tbody id="motion-table-body">
            </tbody>
        </table>
    </div>
</body>
<script>
    let movieArray = <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // check country submit
            if(isset($_POST["rangeSubmit"]))
            {
                $collection = $_POST["collection"]; 
                $budget = $_POST["budget"];
                // Query 8
                $stmt = $conn->prepare(
                    "SELECT p.name as person_name, mp.name as movie_name, m.boxoffice_collection as collection, mp.budget
                    FROM Role r
                    JOIN People p ON r.pid = p.id AND r.role_name = 'Producer' AND p.nationality = 'USA'
                    JOIN Movie m ON m.mpid = r.mpid
                    JOIN MotionPicture mp ON mp.id = m.mpid
                    WHERE m.boxoffice_collection >= :collection AND mp.budget <= :budget
                    "
                );
                $stmt->bindParam(':collection', $collection);
                $stmt->bindParam(':budget', $budget);

            }
            else
            {
                // Get all Movie produced by USA producer
                $stmt = $conn->prepare(
                    "SELECT p.name as person_name, mp.name as movie_name, m.boxoffice_collection as collection, mp.budget
                    FROM Role r
                    JOIN People p ON r.pid = p.id AND r.role_name = 'Producer' AND p.nationality = 'USA'
                    JOIN Movie m ON m.mpid = r.mpid
                    JOIN MotionPicture mp ON mp.id = m.mpid
                    "
                );
            }

            $stmt->execute();

            $result = $stmt->fetchAll();
            echo json_encode($result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    ?>

</script>


<script src="./javascript/utils.js"></script>

<script src="./javascript/american_producers.js"></script>

</html>
