<?php
session_start();
include_once('../connection.php');
include_once('../news.php');

$news = new News;

if (isset($_SESSION['logged_in'])) {
    if (isset($_GET['id'])) { // If ID is provided, get it
        $id = $_GET['id'];
        $query = $pdo->prepare("DELETE FROM news WHERE news_id = ?");
        $query->bindValue(1, $id); // Bind the value to the query above
        $query->execute(); // Execute the query
        
        header('Location: del.php'); // refresh the page
    }
    
    $newsAll = $news->fetch_all(); // Fetch all the data and store it in the variable
    
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
                    <h3>Delete News Article</h3>
                    <br>
                    <form action="del.php" method="get">
                        <select onchange="this.form.submit();" name="id">
                            <?php foreach ($newsAll as $news) { ?> <!-- Loop through all the news and display them in dropdown -->
                            <option value="<?php echo $news['news_id']; ?>"> <!-- Send ID value on submit -->
                                <?php echo $news['news_title']; ?> <!-- Display the news title -->
                            </option>
                            <?php } ?>
                        </select>
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
    header('Location: ../index.php');
}

?>