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
        <h1 style="text-align:center">Top 2 Thriller Movies shot exclusively in Boston</h1><br>
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
    let topTwoMovieArray = <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query 10
            $stmt = $conn->prepare(
                "SELECT mp.name AS movie_name, MAX(mp.rating) AS rating
                FROM MotionPicture mp
                JOIN Genre g ON mp.id = g.mpid
                JOIN Location l ON mp.id = l.mpid
                WHERE g.genre_name = 'thriller' AND l.city = 'Boston'AND NOT EXISTS (
                    SELECT *
                    FROM Location l1
                    WHERE l1.mpid = mp.id
                    AND l1.city != 'Boston'
                )
                GROUP BY mp.name
                ORDER BY rating DESC
                LIMIT 2;
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
    handleTopTwoMovie(topTwoMovieArray);
    function handleTopTwoMovie(topTwoMovieArray) {
        appendTableThread(['Movie', 'Rating']);
        const tableBody = document.querySelector('#motion-table-body');
        topTwoMovieArray.forEach(movie => {
            const { movie_name, rating } = movie;
            appendTableRow({ movie_name, rating } , tableBody);
        })
    }
</script>

</html>
