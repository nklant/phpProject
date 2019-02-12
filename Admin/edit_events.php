<?php
session_start();
include_once('../connection.php');
include_once('../events.php');

$events = new Events;

if (isset($_SESSION['logged_in'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $data = $events->fetch_data($id);
        
        if (isset($_POST['title'], $_POST['content'])) {
        $title = $_POST['title'];
        $content = nl2br($_POST['content']); // nl2br - allows new line storage in DB
        
        if (empty($title) or empty($content)) {
            $error = 'All fields are required!';    
        }else {
            $query = $pdo->prepare("UPDATE events SET event_title = ?, event_content = ? WHERE event_id = ?");
            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, $id);
            
            $query->execute();
            
            header('Location: ../events_article.php?id=1');
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
                        <h3>Edit The Events Page</h3>
                        <br>
                        <form action="edit_events.php?id=1" method="post" autocomplete="off">
                            <input type="text" name="title" placeholder="Title" value="<?php echo $data['event_title']; ?>"><br><br>
                            <textarea rows="15" cols="50" placeholder="Content" name="content"><?php echo $data['event_content']; ?></textarea><br><br>
                            <input type="submit" value="Submit">
                        </form>
                        <?php if (isset($error)) { ?>
                        <small style="color:#aa0000;">
                            <?php echo $error; ?>
                        </small>
                        <?php } ?>
                        <br><br>
                        <a href="../events_article.php?id=1">&larr; Back</a>
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
        header('Location: ../index.php');
}

?>
