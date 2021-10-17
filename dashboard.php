<?php
require_once 'Main.php';
Main::checkLogin();
if(isset($_GET['page'])) {
    $requested_page = basename(filter_var($_GET['page'], FILTER_SANITIZE_STRING));
    if(file_exists(ROOTPATH."app".DS.'backend'.DS.'partials'.DS.$requested_page.'__BACK.php')) {
        $page = $requested_page;
    }else{
        $page = 'index';
    }
}else{
    $page = 'index';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php Main::blinker('head'); ?>
</head>
<body>
    
    <?php Main::blinker('nav'); ?>
    <main class="container mt-4 p-4">
    <?php Main::blinker($page); ?>
    </main>

 <!-- Java Script Files  -->
 <?php Main::blinker('footer'); ?>
</body>
</html>