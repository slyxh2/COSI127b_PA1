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
        <h1 style="text-align:center">Award</h1><br>
    </div>
    <div class="container">

        <form method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter Award Number(default as 0)" name="award-num">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="awardNumSubmit">Query Award Num</button>
                </div>
            </div>
        </form>

        <form method="post">
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="oldAndYoungSubmit">Find the youngest and oldest actors to win at least one award</button>
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
    let awardArray = <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        if(!isset($_POST["oldAndYoungSubmit"])) {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                $awardNum = 0;
            
                // Check award number submit
                if(isset($_POST["awardNumSubmit"])) {
                    $awardNum = $_POST["award-num"]; 
                }
            
                // Query 6
                $stmt = $conn->prepare("
                    SELECT
                        p.name AS person_name,
                        mp.name AS movie_name,
                        a.award_year,
                        COUNT(*) AS award_count
                    FROM
                        Award a
                    JOIN
                        People p ON a.pid = p.id
                    JOIN
                        MotionPicture mp ON a.mpid = mp.id
                    WHERE
                        a.award_year IN (
                            SELECT award_year
                            FROM Award
                            GROUP BY award_year
                            HAVING COUNT(DISTINCT award_name) >= :awardNum
                        )
                    GROUP BY
                        p.name, mp.name, a.award_year
                    HAVING
                        COUNT(*) >= :awardNum"
                );
                $stmt->bindParam(':awardNum', $awardNum);
            
                $stmt->execute();
                $result = $stmt->fetchAll();
                echo json_encode($result);
            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }else{
            echo json_encode(null);
        }

    ?>

</script>
<script>
    let oldAndYoungPerson = <?php
    if(isset($_POST["oldAndYoungSubmit"])){
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $awardNum = 0;
        
            // Check award number submit
            if(isset($_POST["awardNumSubmit"])) {
                $awardNum = $_POST["award-num"]; 
            }
        
            // Query 7
            $stmt = $conn->prepare("
            SELECT youngest.name AS youngest_name, youngest.age_at_award AS youngest_age, oldest.name AS oldest_name, oldest.age_at_award AS oldest_age
            FROM
                (
                    SELECT p.name, YEAR(a.award_year) - YEAR(p.dob) AS age_at_award
                    FROM People p
                    JOIN Award aw ON p.id = aw.pid
                    JOIN
                        (
                            SELECT
                                pid,
                                MIN(award_year) AS min_award_year
                            FROM
                                Award
                            GROUP BY
                                pid
                        ) AS a_years ON aw.pid = a_years.pid
                    JOIN Award a ON aw.pid = a.pid AND aw.award_year = a_years.min_award_year
                    ORDER BY age_at_award ASC
                    LIMIT 1
                ) AS youngest,
                (
                    SELECT p.name, YEAR(a.award_year) - YEAR(p.dob) AS age_at_award
                    FROM People p
                    JOIN Award aw ON p.id = aw.pid
                    JOIN
                        (
                            SELECT
                                pid,
                                MAX(award_year) AS max_award_year
                            FROM
                                Award
                            GROUP BY
                                pid
                        ) AS a_years ON aw.pid = a_years.pid
                    JOIN Award a ON aw.pid = a.pid AND aw.award_year = a_years.max_award_year
                    ORDER BY age_at_award DESC
                    LIMIT 1
                ) AS oldest"
            );
        
            $stmt->execute();
            $result = $stmt->fetchAll();
            echo json_encode($result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }else{
        echo json_encode(null);
    }
    ?>
</script>


<script src="./javascript/utils.js"></script>
<script src="./javascript/award.js"></script>

</html>
