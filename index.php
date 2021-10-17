<?php
require_once 'Main.php';
if(isset($_GET['page'])) {
    $requested_page = basename(filter_var($_GET['page'], FILTER_SANITIZE_STRING));
    if(file_exists(ROOTPATH."app".DS.'frontend'.DS.'partials'.DS.$requested_page.'__FRONT.php')) {
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
    <?php Main::flinker('head'); ?>
</head>
<body>
    
    <?php Main::flinker('nav'); ?>
    <main class="container mt-4 p-4">
    <?php Main::flinker($page); ?>
    </main>

 <!-- Java Script Files  -->
 <?php Main::flinker('footer'); ?>
</body>
</html>