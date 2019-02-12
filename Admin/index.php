<?php
session_start();
include_once('../connection.php');
if (isset($_SESSION['logged_in'])) {
    // display admin index
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CMS Website</title>
    <link rel="stylesheet" href="../Styles/style.css">
    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Styles/sidebar.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading"><a href="../index.php" id="logo">CMS News Website</a></div>
            <div class="list-group list-group-flush">
                <a href="../index.php" class="list-group-item list-group-item-action bg-light">News</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">About Us</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logged_in'])) { ?>
                        <a class="nav-link" href="index.php">Admin <span class="sr-only">(current)</span></a>
                        <?php } else { ?>
                        <a class="nav-link" href="index.php">Login <span class="sr-only">(current)</span></a>
                        <?php }?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logged_in'])) { ?>
                        <a class="nav-link" href="logout.php">Logout <span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid center">
                <h3>This is the Admin Page</h3>
                <br>
                <ul>
                    <li><a href="add.php">Add News Article</a></li>
                    <li><a href="editchoose.php">Edit News Article</a></li>
                    <li><a href="del.php">Delete News Article</a></li>
                </ul>
                <br>
                <a href="../index.php">&larr; Back</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
}else {
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']); // password encryption on login, corresponding to database

        if (empty($username) or empty($password)) {
            $error = 'Please enter username and password!';
        }else {
            $query = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            $query->bindValue(1, $username);
            $query->bindValue(2, $password); // bind these two into the query above
            
            $query->execute(); // execute the query
            
            $num = $query->rowCount(); // get the amount of rows!
            
            if ($num == 1) {
                // user credentials are correct
                $_SESSION['logged_in'] = true;
                header('Location: index.php');
                exit(); // exit to hide the login page
            }else {
                // user credentials are wrong
                $error = 'Username or Password Incorrect!';
            }
        }
    }
    
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CMS Website</title>
    <link rel="stylesheet" href="../Styles/style.css">
    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Styles/sidebar.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading"><a href="../index.php" id="logo">CMS News Website</a></div>
            <div class="list-group list-group-flush">
                <a href="../index.php" class="list-group-item list-group-item-action bg-light">News</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">About Us</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logged_in'])) { ?>
                        <a class="nav-link" href="Admin/index.php">Admin <span class="sr-only">(current)</span></a>
                        <?php } else { ?>
                        <a class="nav-link" href="Admin/index.php">Login <span class="sr-only">(current)</span></a>
                        <?php }?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logged_in'])) { ?>
                        <a class="nav-link" href="Admin/logout.php">Logout <span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid center">
                <h3>Login</h3>
                <br>
                <form action="index.php" method="post" autocomplete="off">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Login">
                </form>
                <?php if (isset($error)) { ?>
                <small style="color:#aa0000;">
                    <?php echo $error; ?></small>
                <?php } ?>
                <br><br>
                <a href="../index.php">&larr; Back</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
}
?>
