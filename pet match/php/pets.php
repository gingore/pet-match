<?php
    include("dbconn.inc.php");
    include("shared.php");

    $conn = dbConnect();

    $PetID = $PetName = $Gender = $PetType = $Breed = $BirthDate = $PetAge = '';
    $errMsg = '';
    
    $sqlTypes = "SELECT DISTINCT PetType FROM Pets";
    $resultTypes = $conn->query($sqlTypes);
    
    $selectedType = isset($_GET['type']) ? $_GET['type'] : '';
    
    $filterClause = $selectedType ? "WHERE PetType = '$selectedType'" : '';
    
    $sqlPets = "SELECT PetName, Gender, PetType, Breed, PetAge, ImageURL FROM Pets $filterClause";
    $resultPets = $conn->query($sqlPets);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pets Card View</title>
        <link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/petsStyle.css' type='text/css'>
    </head>
    <body>
        <div class="nav-div">
            <header>
                <div class="container">
                    <a href="home.php" class="logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/01/PetSmart.svg/1280px-PetSmart.svg.png" alt="Petsmart Logo" width="200px" height="auto">
                    </a>
                    <ul class="links">
                        <li><a href="home.php">Home</a></li>
                        <li><a href="pets.php">Adopt</a></li>
                        <li><a href="petMatch.php">Form</a></li>
                    </ul>
                </div>
            </header>
    
            <div class="filter">
                <form method="get" action="pets.php">
                    <label for="petType">Filter by Pet Type:</label>
                    <select id="petType" name="type" onchange="this.form.submit()">
                        <option value="">All</option>
                        <?php
                        while ($typeRow = $resultTypes->fetch_assoc()) {
                            echo "<option value='{$typeRow['PetType']}'";
                            if ($typeRow['PetType'] == $selectedType) {
                                echo " selected";
                            }
                            echo ">{$typeRow['PetType']}</option>";
                            }
                        ?>
                    </select>
                </form>
            </div>
        </div>
    
        <div class="card-container">
            <?php
            if ($resultPets) {
                while ($row = $resultPets->fetch_assoc()) {
                    ?>
                    <div class="card">
                        <img src="<?= $row['ImageURL'] ?>" alt="<?= $row['PetName'] ?> Image">
                        <h2><b><?= $row['PetName'] ?></b></h2> 
                        <p><b><?= $row['Gender'] ?></b> | <b><?= $row['PetType'] ?></b> | <b><?= $row['Breed'] ?></b> | <b><?= $row['PetAge'] ?></b></p>
                    </div>
                    <?php
                }
                $resultPets->free_result();
            } else {
                echo "Error: " . $conn->error;
            }   
            $conn->close();
            ?>
        </div>
        <footer>
            <div class="container">
                <p>&copy; CTEC 4321 Term Project | Lena Tran | Not affiliated with PetSmart</p>
            </div>
        </footer>
    </body>
</html>
