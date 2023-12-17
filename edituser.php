<?php

session_start();

//if there's email stay on page
if (isset($_SESSION['email'])) {
    //continue
    $var_id = "";
    $var_email = "";
    $var_fname = "";
    $var_lname = "";
    $var_password = "";
    $var_row_id = "";
    $errors = array();



    //retrieve record data
    if (isset($_GET["record"])) {
        $var_id = $_GET["record"];

        $conn = mysqli_connect("localhost", "root", "", "taskcalendar");
        $query = "SELECT * FROM user_info WHERE user_idn = $var_id";
        $record = mysqli_query($conn, $query);

        if (mysqli_num_rows($record) > 0) {
            $rec = mysqli_fetch_array($record);

            $var_email = $rec["user_email"];
            $var_fname = $rec["user_fname"];
            $var_lname = $rec["user_lname"];
            $var_password = $rec["user_password"];
        } else {
            echo "<p style='color:red;'>Record is no longer existing...</p>";
        }
        mysqli_close($conn);
    }

    //if na click ang button do this
    if (isset($_POST['btnSaveChanges'])) {
        $var_row_id = $_POST['UserRowId'];
        $var_email = trim($_POST['TxtEmail']);
        $var_fname = trim($_POST['TxtFirstName']);
        $var_lname = trim($_POST['TxtLastName']);
        $var_password = password_hash($_POST["TxtPassword"], PASSWORD_BCRYPT);

        //error trapping
        //et: first name
        if (!ctype_alpha(str_replace(' ', '', $var_fname))) {
            $errors[] = "<p style='color:red;' class='h5 text-center mx-auto mt-1 mb-0'>Invalid First Name: Please enter only letters and spaces.</p>";
        }
        //et: last name
        if (!ctype_alpha(str_replace(' ', '', $var_lname))) {
            $errors[] = "<p style='color:red;' class='h5 text-center mx-auto mt-1 mb-0'>Invalid Last Name: Please enter only letters and spaces.</p>";
        }
        //et: email address
        if (!filter_var($var_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "<p style='color:red;' class='h5 text-center mx-auto mt-1 mb-0'>Invalid Email Address: Please enter only letters and spaces.</p>";
        }

        if (!empty($errors)) {
            foreach ($errors as $errormessage) {
                echo $errormessage;
            }
        }
        else {
            $conn = mysqli_connect("localhost","root","","taskcalendar");
            if (!$conn->connect_error) {
                $query = "CALL sp_updateUser($var_row_id, '$var_password', '$var_fname', '$var_lname')";
                $result = mysqli_query($conn,$query);
                if ($result) {
                    echo "<p style='color:green;' class='h5'>Edited successfully.<p>";
                    header("Location: listalluser.php");
                } else {
                    echo "<p style='color:red;' class='h5'>Edit FAILED.<p>";
                    echo "<a href='listalluser.php' class='btn btn-secondary'>Go back</a>";
                }
            } else {
                die('Connection failed: ' . $conn->connect_error);
            }
        }
        mysqli_close($conn);
    }
}
//if not go back to login
else {
    sesh_out();
}

function sesh_out()
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mx-auto mt-3 pt-5">
        <div class="card w-50 mx-auto shadow">
            <a href="listalluser.php" class="text-decoration-none h1 mx-5 mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z" />
                </svg>
            </a>
            <div class="card-body p-5 pt-3">
                <div class="row justify-content-center">
                    <div class="">
                        <h2 class="mb-5">Edit User</h2>
                        <form action="edituser.php" method="POST">
                            <div class="form-group">
                                <input type="hidden" value="<?php echo $var_id;?>" name="UserRowId">
                                <label for="firstName">First Name:</label>
                                <input type="text" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="firstName" name="TxtFirstName" placeholder="Enter First Name" value="<?php echo $var_fname; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="lastName" name="TxtLastName" placeholder="Enter Last Name" required value="<?php echo $var_lname; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="email" name="TxtEmail" placeholder="Enter Email Address" readOnly required value="<?php echo $var_email; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control placeholder-gray border-bottom border-3 my-1 border-0 rounded-0" id="password" name="TxtPassword" placeholder="Enter Password" required />
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-lg btn-primary" name="btnSaveChanges" onclick="return confirm('Are you sure you want to save changes?')">SAVE CHANGES</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>