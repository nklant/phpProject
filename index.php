<?php
session_start();
include_once('connection.php');
include_once('news.php');
$news = new News; // Initialize the News class
$newsAll = $news->fetch_all(); // fetch all the data
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CMS Website</title>
    <link rel="stylesheet" href="Styles/style.css">
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="Styles/sidebar.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading"><a href="index.php" id="logo">CMS News Website</a></div>
            <div class="list-group list-group-flush">
                <a href="index.php" class="list-group-item list-group-item-action bg-light">News</a>
                <a href="events_article.php?id=1" class="list-group-item list-group-item-action bg-light">Events</a>
                <a href="about_article.php?id=1" class="list-group-item list-group-item-action bg-light">About Us</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logged_in'])) { ?> <!-- Check if the user has logged in and display "Admin" -->
                            <a class="nav-link" href="Admin/index.php">Admin <span class="sr-only">(current)</span></a>
                        <?php } else { ?>
                            <a class="nav-link" href="Admin/index.php">Login <span class="sr-only">(current)</span></a>
                        <?php }?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logged_in'])) { ?> <!-- Check if the user has logged in and display "Logout" -->
                            <a class="nav-link" href="Admin/logout.php">Logout <span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid">
                <ul>
                    <?php foreach($newsAll as $news) { ?> <!-- Foreach loop to display all the news from DB -->
                    <li>
                        <a href="news_article.php?id=<?php echo $news['news_id']; ?>"> <!-- Echo the id of the news article on select -->
                            <?php echo $news['news_title']; ?></a> - <!-- Get the title from DB -->
                        <small>posted on <?php echo date('l, jS', $news['news_postdate']); ?></small> <!-- Get the timestamp from DB and format the display type -->
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
