<?php
session_start();
include_once('../connection.php');

if (isset($_SESSION['logged_in'])) {
    // add news
    if (isset($_POST['title'], $_POST['content'])) { // If title and content fields are NOT empty
        $title = $_POST['title'];
        $content = nl2br($_POST['content']); // nl2br - Saves new lines to DB
        
        if (empty($title) or empty($content)) {
            $error = 'All fields are required!'; // Throw an error if empty fields
        }else {
            $query = $pdo->prepare("INSERT INTO news (news_title, news_content, news_postdate) VALUES (?, ?, ?)"); // Insert the new article in DB
            $query->bindValue(1, $title); // bind the values to the query above
            $query->bindValue(2, $content);
            $query->bindValue(3, time());
            
            $query->execute();
            
            header('Location: ../index.php'); // Redirect to index
        }
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CMS Website</title>
        <link rel="stylesheet" href="../Styles/style.css">
        <link rel="stylesheet" href="../Styles/widgEditor.css">

        <!-- Bootstrap core CSS -->
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../Styles/sidebar.css" rel="stylesheet">
        <script type="text/javascript" src="../Scripts/widgEditor.js"></script>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-light border-right" id="sidebar-wrapper">
                <div class="sidebar-heading"><a href="../index.php" id="logo">CMS News Website</a></div>
                <div class="list-group list-group-flush">
                    <a href="../index.php" class="list-group-item list-group-item-action bg-light">News</a>
                    <a href="../events_article.php?id=1" class="list-group-item list-group-item-action bg-light">Events</a>
                    <a href="../about_article.php?id=1" class="list-group-item list-group-item-action bg-light">About Us</a>
                </div>
            </div>
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <?php if (isset($_SESSION['logged_in'])) { ?> <!-- Check if the user has logged in and display "Admin" -->
                                <a class="nav-link" href="index.php">Admin <span class="sr-only">(current)</span></a>
                            <?php } else { ?>
                                <a class="nav-link" href="index.php">Login <span class="sr-only">(current)</span></a>
                            <?php }?>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['logged_in'])) { ?> <!-- Check if the user has logged in and display "Logout" -->
                                <a class="nav-link" href="logout.php">Logout <span class="sr-only">(current)</span></a>
                            <?php } ?>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid center">
                    <h3>Add News Article</h3>
                    <br>
                    <form action="add.php" method="post" autocomplete="off">
                        <input type="text" name="title" placeholder="Title"><br><br>
                        <textarea class="widgEditor" rows="15" cols="50" placeholder="Content" name="content"></textarea><br><br>
                        <input type="submit" value="Submit">
                    </form>
                    <?php if (isset($error)) { ?> <!-- Throw an error -->
                    <small style="color:#aa0000;">
                        <?php echo $error; ?>
                    </small>
                    <?php } ?>
                    <br><br>
                    <a href="../Admin/index.php">&larr; Back</a>
                    <br><br><br>
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
    header('Location: index.php');
}

?>