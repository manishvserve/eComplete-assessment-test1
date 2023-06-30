<?php 
    session_start();
    if(isset($_SESSION['error'])){
        $error = $_SESSION['error'];
    }else{
        $error = "";
    }
    if(isset($_SESSION['success'])){
        $success = $_SESSION['success'];
    }else{
        $success = "";
    }
    
    // $success = $_SESSION['success'];
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $surname = isset($_GET['surname']) ? $_GET['surname'] : '';
    $dob = isset($_GET['dob']) ? $_GET['dob'] : '';
    $idNumber = isset($_GET['id_number']) ? $_GET['id_number'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Test1</title>
</head>
<body>
    <div class="container-fluid">
        
        <div class="row text-center">
            <!-- Heading -->
            <div class="col-12 ">
                <h2>Test 1</h2>
            </div>
            <!-- Success Msg -->
            <div class="col-12">
                <b><p class="mb-3 text-success"><?php echo $success; ?></p></b>
            </div>
        </div>
        <!-- Form -->
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-4">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <!-- Name -->
                    <label for="name"><strong>Name</strong></label>
                    <input autocomplete="off" class="form-control mb-3" type="text" name="name" id="name" value="<?php echo $name; ?>" pattern="[A-Za-z]+" title="Only alphabet characters are allowed" required>
                    <!-- Surname -->
                    <label for="surname"><strong>Surname</strong></label>
                    <input autocomplete="off" class="form-control mb-3" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" pattern="[A-Za-z]+" title="Only alphabet characters are allowed"  required>
                    <!-- ID Number -->
                    <label for="id_number"><strong>ID Number</strong></label>
                    <input autocomplete="off" class="form-control mb-3" maxlength="13" oninput="checkMaxLength(this)" type="number" name="id_number" id="id_number" value="<?php echo $idNumber; ?>" required>
                    <p class="mb-3 text-danger"><?php echo $error; ?></p>
                    <!-- Date of Birth -->
                    <label for="dob"><strong>Date of Birth</strong></label>
                    <input autocomplete="off" class="form-control mb-3" type="date" name="dob" id="dob" value="<?php echo $dob; ?>" required>
                    <!-- Post Button -->
                    <input class="btn btn-primary mb-3" type="submit" value="POST">
                    <!-- Cancel Button -->
                    <input class="btn btn-danger mb-3" type="reset" value="CANCEL" onclick="refreshPage()">
                    <!-- <a href="" class="brn brn-danger" >CANCEL</a> -->
                </form>
            </div>
            <div class="col-4">
            </div>
        </div>
    </div>
    <script>
        // Get the current date
        var currentDate = new Date().toISOString().split('T')[0];
        
        // Calculate the date one day before the current date
        var oneDayBefore = new Date();
        oneDayBefore.setDate(oneDayBefore.getDate() - 1);
        var oneDayBeforeDate = oneDayBefore.toISOString().split('T')[0];
        
        // Set the minimum and maximum date attributes of the input field
        document.getElementById('dob').setAttribute('max', oneDayBeforeDate);
        // document.getElementById('dob').setAttribute('min', oneDayBeforeDate);

        function checkMaxLength(input) {
            if (input.value.length > input.maxLength) {
                input.value = input.value.slice(0, input.maxLength); // Trim the value to the maximum length
            }
        }
        function refreshPage() {
            // Reload the page
            location.reload();
        }
    </script>
</body>
</html>

<?php
    require_once  __DIR__ . '\config.php';
    $_SESSION['error'] = '';
    $_SESSION['success'] = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name       = $_POST["name"];
        $surname    = $_POST["surname"];
        $id_number  = $_POST["id_number"];
        $dob        = $_POST["dob"];
        $dob        = date_create($dob);
        $dob        = date_format($dob,"d/m/Y");

        $data = [
            'name'      => $name,
            'surname'   => $surname,
            'id_number' => $id_number,
            'dob'       => $dob
            ];

        // ID Number Validation
        $filter = ['id_number' => $id_number];
        $count = $collection->countDocuments($filter);

        if ($count > 0) { // Return Error
            // Step 3: Duplicate ID number found
            // $error = "Duplicate ID number found. Please enter a different ID number.";
            $_SESSION['error'] = 'Duplicate ID number found. Please enter a different ID number.';
            unset($_SESSION['success']);
            $formData = $_POST; // Store the submitted form data
            // Step 4: Redirect back to the form page with error message and submitted data
            header("Location: index.php?id_number=" . urlencode($id_number). "&dob=" . urlencode($_POST["dob"]). "&name=" . urlencode($name). "&surname=" . urlencode($surname));
            exit();
        } else { // Data Added to database
            // $success = "";
            $_SESSION['success'] = 'Data Insert Successfully';
            unset($_SESSION['error']);
            // Step 4: Redirect back to the form page with error message and submitted data
            header("Location: index.php?success=" . urlencode($success));
            exit();
        }
            
    }
?> 