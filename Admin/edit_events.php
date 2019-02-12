<?php
session_start();
include_once('../connection.php');
include_once('../events.php');

$events = new Events;

if (isset($_SESSION['logged_in'])) {
    if (isset($_GET['id'])) { // Get the ID if it's set
        $id = $_GET['id'];
        $data = $events->fetch_data($id); // Get the data
        
        if (isset($_POST['title'], $_POST['content'])) {
        $title = $_POST['title'];
        $content = nl2br($_POST['content']); // nl2br - allows new line storage in DB
        
        if (empty($title) or empty($content)) { // Throw an error if fields are empty
            $error = 'All fields are required!';    
        }else {
            $query = $pdo->prepare("UPDATE events SET event_title = ?, event_content = ? WHERE event_id = ?"); // Update the corresponding article
            $query->bindValue(1, $title); // Bind all the values to the query above
            $query->bindValue(2, $content);
            $query->bindValue(3, $id);
            
            $query->execute(); // Execute the query
            
            header('Location: ../events_article.php?id=1');
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
                        <h3>Edit The Events Page</h3>
                        <br>
                        <form action="edit_events.php?id=1" method="post" autocomplete="off"> <!-- On submit update the specific article -->
                            <input type="text" name="title" placeholder="Title" value="<?php echo $data['event_title']; ?>"><br><br> <!-- Fill out the fields for edit -->
                            <textarea rows="15" cols="50" placeholder="Content" name="content"><?php echo $data['event_content']; ?></textarea><br><br>
                            <input type="submit" value="Submit">
                        </form>
                        <?php if (isset($error)) { ?> <!-- Throw an error -->
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
