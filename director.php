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
        <h1 style="text-align:center">Director For TV series</h1><br>
    </div>
    <div class="container">

        <form id="nameForm" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter Zip Code" name="zip-code">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="zipSubmit">Query Zip</button>
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
    let directorArray = <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // check country submit
            if(isset($_POST["zipSubmit"]))
            {
                $zipCode = $_POST["zip-code"]; 
                // Query 5
                $stmt = $conn->prepare(
                    "SELECT DISTINCT mp.name as tv_name, p.name as director_name
                    FROM Role r
                    JOIN People p ON p.id = r.pid
                    JOIN Location l ON l.mpid = r.mpid
                    JOIN Series s ON s.mpid = r.mpid
                    JOIN MotionPicture mp ON mp.id = r.mpid
                    WHERE r.role_name = 'Director' AND l.zip = :zipCode
                    "
                );
                $stmt->bindParam(':zipCode', $zipCode);
            }
            else
            {
                // Get all Director for TV series
                $stmt = $conn->prepare(
                    "SELECT DISTINCT mp.name as tv_name, p.name as director_name
                    FROM Role r
                    JOIN People p ON p.id = r.pid
                    JOIN Series s ON s.mpid = r.mpid
                    JOIN MotionPicture mp ON mp.id = r.mpid
                    WHERE r.role_name = 'Director'
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

<script src="./javascript/director.js"></script>

</html>
