<?php
    include("dbconn.inc.php");
    include("shared.php");
    
    $conn = dbConnect();
    
    $ProfileID = $Name = $Gender = $MaritalStatus = $FamilySize = $PetType = $ResidentType = '';
    $errMsg = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Name = $_POST['name'];
        $Gender = $_POST['gender'];
        $MaritalStatus = $_POST['maritalStatus'];
        $FamilySize = $_POST['familySize'];
        $PetType = $_POST['petType'];
        $ResidentType = $_POST['residentType'];
    
        $sql = "INSERT INTO UserProfiles (Name, Gender, MaritalStatus, FamilySize, PetType, ResidentType) VALUES (?, ?, ?, ?, ?, ?)";
    
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sssiss', $Name, $Gender, $MaritalStatus, $FamilySize, $PetType, $ResidentType);
    
            if ($stmt->execute()) {
                $lastInsertID = mysqli_insert_id($conn);
    
                // redirecting users to pets.php with the selected PetType from form
                header('Location: pets.php?type=' . urlencode($PetType));
                exit();
                // Redirect to pets.php with the selected PetType and a success message
                header('Location: pets.php?type=' . urlencode($PetType) . '&success=1');
                exit();
    
            } else {
                $errMsg = "<p style='color: #cc0000;'>Error creating user profile: " . $stmt->error . "</p>";
            }
    
            $stmt->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CTEC 4321 Project: PetMatch</title>
        <link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/style.css' type='text/css'>
    </head>
    <body>
        <div class="navbar">
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
        </div>
            <main>
                <h2>PetMatch User Form</h2>
                <form method="post" action="petMatch.php">
                    <label for="name">Name:</label>
                    <input type="text" name="name" required>
        
                    <label for="gender">Gender:</label>
                    <select name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="nonbinary">Non-binary</option>
                        <option value="agender">Agender</option>
                        <option value="preferNotToSay">Prefer not to say</option>
                    </select>
        
                    <label for="maritalStatus">Marital Status:</label>
                    <select name="maritalStatus" required>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                        <option value="widowed">Widowed</option>
                    </select>
        
                    <label for="familySize">Family Size:</label>
                    <input type="number" name="familySize" required>
        
                    <label for="petType">Preferred Pet Species:</label>
                    <select name="petType" required>
                        <option value="Cat">Cats</option>
                        <option value="Dog">Dogs</option>
                        <option value="Rabbit">Rabbits</option>
                        <option value="Bird">Birds</option>
                    </select>
        
                    <label for="residentType">Resident Type:</label>
                    <select name="residentType" required>
                        <option value="house">House</option>
                        <option value="apartment">Apartment</option>
                        <option value="dormitory">Dormitory</option>
                    </select>
        
                    <button type="submit">Create Profile</button>
                </form>
                <?php echo $errMsg; ?>
            </main>
        <footer>
            <div class="container">
                <p>&copy; CTEC 4321 Term Project | Lena Tran | Not affiliated with PetSmart</p>
            </div>
        </footer>
    </body>
</html>
