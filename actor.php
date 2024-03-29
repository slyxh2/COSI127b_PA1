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
        <h1 style="text-align:center">All People</h1><br>
    </div>
    <div class="container">

        <form id="nameForm" method="post">
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="topFiveSubmit">Find the top 5 movies with the highest number of people playing a role</button>
                </div>
            </div>
        </form>

        <form id="nameForm" method="post">
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="sameBirthSubmit">Find actors who share the same birthday</button>
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
    let peopleArray = <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $type = 'default';


            // check country submit
            if(isset($_POST["topFiveSubmit"]))
            {
                // Query 14
                $stmt = $conn->prepare(
                    "SELECT mp.name AS movie_name, COUNT(DISTINCT r.pid) AS people_count, COUNT(r.role_name) AS role_count
                    FROM MotionPicture mp
                    JOIN Role r ON mp.id = r.mpid
                    GROUP BY mp.name
                    ORDER BY people_count DESC
                    LIMIT 5
                    "
                );
                $type = 'top-five';

            }
            elseif(isset($_POST["sameBirthSubmit"]))
            {
                // Query 15
                $stmt = $conn->prepare(
                    "SELECT p1.name AS name1, p2.name AS name2, p1.dob
                    FROM People p1
                    JOIN People p2 ON p1.dob = p2.dob AND p1.id < p2.id
                    "
                );
                $type = 'same-birth';
            }
            else
            {
                // Get all People
                $stmt = $conn->prepare(
                    "SELECT p.id, p.name, p.nationality, p.DOB, p.gender FROM People p"
                );
            }

            $stmt->execute();

            $result = $stmt->fetchAll();
            $typeElement = array(
                'type' => $type
            );

            $result[] = $typeElement;
            echo json_encode($result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    ?>

</script>


<script src="./javascript/utils.js"></script>

<script src="./javascript/actor.js"></script>

</html>
