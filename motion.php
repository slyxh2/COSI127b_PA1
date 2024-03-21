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
        <h1 style="text-align:center">Motion Picture</h1><br>
    </div>
    <div class="container">

        <form id="nameForm" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter Motion Picture's Name" name="motion-name" id="inputName">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="nameSubmit">Query Name</button>
                </div>
            </div>
        </form>

        <form id="emailForm" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter User Email to see His/Her Like" name="user-email" id="email">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="emailSubmit">Query User Like</button>
                </div>
            </div>
        </form>

        <form id="countryForm" method="post">
            <div class="input-group mb-3">
                <select id="country-select" name="country">
                    <option value="" disabled selected>Select an country</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="countrySubmit">Query Country</button>
                </div>
            </div>
        </form>

        <form id="avgForm" method="post">
            <div class="input-group mb-3">

            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" name="avgSubmit">Find the motion pictures that have a higher rating than the average rating of all comedy motion pictures</button>
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
    let motionArray = <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $type = 'default';

            // check motion name submit
            if(isset($_POST["nameSubmit"]))
            {
                $motionName = $_POST["motion-name"]; 
                // Query 2
                $stmt = $conn->prepare(
                    "SELECT mp.id, mp.name, mp.production, mp.budget, mp.rating
                    FROM MotionPicture mp
                    WHERE mp.name = :motionName
                    "
                );
                $stmt->bindParam(':motionName', $motionName);
                $type = 'motion';
            }
            // check user name submit
            elseif(isset($_POST["emailSubmit"]))
            {
                $userEmail = $_POST["user-email"];
                // Query 3
                $stmt = $conn->prepare(
                    "SELECT mp.id, mp.name, mp.production, mp.budget, mp.rating
                    FROM MotionPicture mp
                    JOIN Likes l ON l.mpid = mp.id
                    WHERE l.uemail = :userEmail;
                    "
                );
                $stmt->bindParam(':userEmail', $userEmail);
                $type = 'email';

            }
            // check country submit
            elseif(isset($_POST["countrySubmit"]))
            {
                $country = $_POST["country"];
                // Query 4
                $stmt = $conn->prepare(
                    "SELECT mp.name
                    FROM Location l
                    JOIN MotionPicture mp ON l.mpid = mp.id
                    WHERE l.country = :country
                    "
                );
                $stmt->bindParam(':country', $country);
                $type = 'country';

            }
            // check average submit
            elseif(isset($_POST["avgSubmit"]))
            {
                // Query 13
                $stmt = $conn->prepare(
                    "SELECT mp.name AS movie_name, mp.rating
                    FROM MotionPicture mp
                    JOIN Genre g ON mp.id = g.mpid
                    WHERE g.genre_name = 'comedy' AND mp.rating > (
                            SELECT AVG(mp1.rating)
                            FROM MotionPicture mp1
                            JOIN Genre g1 ON mp1.id = g1.mpid
                            WHERE g1.genre_name = 'comedy'
                    )
                    ORDER BY mp.rating DESC"
                );
                $type = 'average';

            }
            else
            {
                // Get all motion picture
                $stmt = $conn->prepare(
                    "SELECT mp.id, mp.name, mp.production, mp.budget, mp.rating
                    FROM MotionPicture mp
                    "
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

<script>
    const allCountry = <?php
        try {
            // Get all Country
            $stmt = $conn->prepare(
                "SELECT DISTINCT l.country
                FROM Location l
                "
            );

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
<script src="./javascript/motion.js"></script>

</html>
