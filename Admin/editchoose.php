<?php
session_start();
include_once('../connection.php');
include_once('../news.php');

$news = new News;

if (isset($_SESSION['logged_in'])) {
    if (isset($_GET['id'])) { // Get ID if it's set
        $id = $_GET['id'];
        $data = $news->fetch_data($id); // Fetch all data
        
        header('Location: ../edit.php?id='.$id); // Redirect to selected article for edit
    }
    
    $newsAll = $news->fetch_all(); // Fetch all the data
    
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
                    <h3>Edit News Article</h3>
                    <br>
                    <form action="editchoose.php" method="get">
                        <select onchange="this.form.submit();" name="id">
                            <option value="" disabled selected>Select articles</option>
                            <?php foreach ($newsAll as $news) { ?> <!-- Loop through the data -->
                            <option value="<?php echo $news['news_id']; ?>"> <!-- Select the ID for submit -->
                                <?php echo $news['news_title']; ?> <!-- Echo the title from DB -->
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