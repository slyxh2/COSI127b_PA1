<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Bootstrap JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./style/home.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSI 127b</title>
    
</head>
<body>
        <div id="user-inf-block">

        </div>

    <div id="login-modal">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Login
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="Please Enter Your Email" id="user-email"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="login-btn">Login</button>
            </div>
            </div>
        </div>
        </div>
    </div>    


    <div class="container">
        <h1 style="text-align:center">Welcome To Movie Collection</h1>
        <h3 style="text-align:center">You can find ererything about Movie!</h3>
    </div>

    <div>
        <a href="./motion.php"><button>See All Motion Picture</button></a>
        <a href="./actor.php"><button>See All People</button></a>
        <a href="./award.php"><button>See Award</button></a>
        <a href="./movies.php"><button>See Movies Like Number</button></a>
    </div>

    <div style="margin-top:2em">
        <a href="./director.php"><button>Director For TV series</button></a>
        <a href="./american_producers.php"><button>See American Collection</button></a>
    </div>

    <div style="margin-top:2em">
        <a href="./thriller_top_two.php"><button>See Top 2 Thriller Movies shot exclusively in Boston</button></a>
        <a href="./multiple_roles.php"><button>See People Played Multiple Roles</button></a>
    </div>
    <div style="margin-top:2em">
        <a href="./play_both.php"><button>See the actors who have played a role in both Marvel and Warner Bros</button></a>
    </div>

    <div id="table-list">
        <h4>Content:</h4>
    </div>


</body>
<script>
    let allTable = <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "COSI127b";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Query 1
            $stmt = $conn->prepare("
                SELECT table_name 
                FROM information_schema.tables
                WHERE table_schema = 'COSI127b';
            ");

            $stmt->execute();

            $result = $stmt->fetchAll();
            echo json_encode($result);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    ?>
</script>
<script src="./javascript/utils.js"></script>

<script src="./javascript/index.js"></script>
</html>
