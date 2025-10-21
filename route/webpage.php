<?php 
    $page = (isset($_GET['page'])) ? $_GET['page'] : "home";
    if ($page == "home") {
        include "page/home.php";
    } elseif ($page == "detail") {
        include "page/detail.php";
    } elseif ($page == "shall") {
        include "page/shall.php";
    } else {
        echo "<h1>404 Not Found</h1>";
    }
    ?>