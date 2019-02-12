<?php
session_start();
include_once('connection.php');
include_once('news.php');

$news = new News;

if (isset($_SESSION['logged_in'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $data = $news->fetch_data($id);
        
        if (isset($_POST['title'], $_POST['content'])) {
        $title = $_POST['title'];
        $content = nl2br($_POST['content']); // nl2br - why?? because line breaks, that's why!!! 
        
        if (empty($title) or empty($content)) {
            $error = 'All fields are required!';    
        }else {
            $query = $pdo->prepare("UPDATE news SET news_title = ?, news_content = ?, news_postdate = ? WHERE news_id = ?");
            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, time());
            $query->bindValue(4, $id);
            
            $query->execute();
            
            header('Location: index.php');
        }
    }
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
                <!-- Sidebar -->
                <div class="bg-light border-right" id="sidebar-wrapper">
                    <div class="sidebar-heading"><a href="index.php" id="logo">CMS News Website</a></div>
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
                        <h3>Edit News Article</h3>
                        <br>
                        <form action="edit.php?id=<?php echo $data['news_id']; ?>" method="post" autocomplete="off">
                            <input type="text" name="title" placeholder="Title" value="<?php echo $data['news_title']; ?>"><br><br>
                            <textarea rows="15" cols="50" placeholder="Content" name="content"><?php echo $data['news_content']; ?></textarea><br><br>
                            <input type="submit" value="Submit">
                        </form>
                        <?php if (isset($error)) { ?>
                        <small style="color:#aa0000;">
                            <?php echo $error; ?>
                        </small>
                        <?php } ?>
                        <br><br>
                        <a href="index.php">&larr; Back</a>
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
        }
    }else {
        header('Location: index.php');
}

?>
