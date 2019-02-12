<?php
session_start();
include_once('connection.php');
include_once('news.php');

$article = new News;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $article->fetch_data($id);
    
    ?>
                                            <!-- This file is reusable for every news article -->
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
                    <a href="index.php" class="list-group-item list-group-item-action">News</a>
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
                    <h4 id="underline">
                        <?php echo $data['news_title']; ?> -
                        <small>
                            posted on <?php echo date('l, jS', $data['news_postdate']); ?> <!-- Echo and format the timestamp -->
                            
                        </small>
                    </h4>
                    
                    <p><?php echo $data['news_content']; ?></p> <!-- Echo the new content from DB -->
                    <a href="index.php">&larr; Back</a> 
                    <?php if (isset($_SESSION['logged_in'])) { ?> <!-- Check if logged in to display the "Edit" button -->
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="edit.php?id=<?php echo $data['news_id']; ?>">&#9988; Edit</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

    <?php
}else {
    header('Location: index.php'); // If no ID is provided on page load, redirect to index.php
    exit();
}

?>
