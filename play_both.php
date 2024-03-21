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
        <h1 style="text-align:center">The actors who have played a role in both Marvel and Warner Bros</h1><br>
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
    let array = <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query 12
            $stmt = $conn->prepare(
                "SELECT p.name AS person_name, mp.name AS movie_name
                FROM People p
                JOIN Role r ON p.id = r.pid
                JOIN MotionPicture mp ON r.mpid = mp.id
                WHERE mp.production = 'Marvel' AND p.id IN (
                        SELECT p1.id
                        FROM People p1
                        JOIN Role r1 ON p1.id = r1.pid
                        JOIN MotionPicture mp1 ON r1.mpid = mp1.id
                        WHERE mp1.production = 'Warner Bros'
                )                
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

<script>
    handleArray(array);
    function handleArray(topTwoMovieArray) {
        appendTableThread(['Movie Name', 'Actor Name']);
        const tableBody = document.querySelector('#motion-table-body');
        topTwoMovieArray.forEach(movie => {
            const { movie_name, person_name } = movie;
            appendTableRow({ movie_name, person_name }, tableBody);
        })
    }
</script>

</html>
