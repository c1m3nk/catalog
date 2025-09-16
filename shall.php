<!DOCTYPE html>
<html lang="en">
<?php include "component/header.php"?>

<body>
<?php include "component/navbar.php"?>

    <?php 
    $page = (isset($_GET['page'])) ? $_GET['page'] : "shall";
    if ($page == "shall") {
        include "page/shall.php";
    } elseif ($page == "detail") {
        include "page/detail.php";
    } elseif ($page == "home") {
        include "page/home.php";
    } else {
        echo "<h1>404 Not Found</h1>";
    }
    ?>

<?php include "component/footer.php"?>
</body>

</html>