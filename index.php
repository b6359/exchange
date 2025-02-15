<?php
require_once('ConMySQL.php');

// Start session
session_start();

// Define session variables
$_SESSION['CNAME'] = "EXCHANGE";
$_SESSION['CADDR'] = "Durr&euml;s ";
$_SESSION['CNIPT'] = "A12345678B";
$_SESSION['CADMI'] = "Administrator";
$_SESSION['CMOBI'] = "+355 69 123 4567";
$_SESSION['DPPPP'] = "1000000";

$loginFormAction = $_SERVER['PHP_SELF'];

if (!empty($_POST['username']) && !empty($_POST['password'])) {

    $loginUsername = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize input to prevent SQL injection
    $loginUsername = preg_replace("/[\\'\"<>-]/", '', $loginUsername);
    $password = preg_replace("/[\\'\"<>-]/", '', $password);

    $MM_redirectLoginSuccess = "info.php";
    $MM_redirectLoginFailed = "index.php";

    $conn = new mysqli($hostname_MySQL, $username_MySQL, $password_MySQL, $database_MySQL);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, username, full_name, id_trans, id_filiali, id_usertype FROM app_user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $loginUsername, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $myrow = $result->fetch_assoc();

        $_SESSION['uid'] = $myrow["id"];
        $_SESSION['Username'] = $myrow["username"];
        $_SESSION['full_name'] = $myrow["full_name"];
        $_SESSION['Usertrans'] = $myrow["id_trans"];
        $_SESSION['Userfilial'] = $myrow["id_filiali"];
        $_SESSION['Usertype'] = $myrow["id_usertype"];

        header("Location: " . $MM_redirectLoginSuccess);
        exit();
    } else {
        header("Location: " . $MM_redirectLoginFailed);
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo htmlspecialchars($_SESSION['CNAME']); ?> - Web Exchange System</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/text.css">
    <link rel="stylesheet" type="text/css" href="css/984_width.css">
    <link rel="stylesheet" type="text/css" href="css/layout.css">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/server2.css" />
</head>

<body>
    <div class="ShiritiLogo">
        <div class="logo">
            <a href="index.php">
                <img src="images/header.png" title="<?php echo htmlspecialchars($_SESSION['CNAME']); ?>" alt="<?php echo htmlspecialchars($_SESSION['CNAME']); ?>" height="50px">
            </a>
        </div>
    </div>
    <div class="login">
        <h1>Hyrje në sistem</h1>
        <form method="post" action="index.php">
            <p><input type="text" name="username" placeholder="Perdoruesi" maxlength="16" required></p>
            <p><input type="password" name="password" placeholder="Fjalekalimi" maxlength="16" required></p>
            <p class="submit"><input type="submit" name="commit" value="Login"></p>
        </form>
    </div>
    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
</body>

</html>