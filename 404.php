<?php
require_once 'Main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php Main::flinker('head'); ?>
</head>
<body>
    
    <?php Main::flinker('nav'); ?>
    <main class="container mt-4 p-4">
    <?php Main::flinker('404'); ?>
    </main>

 <!-- Java Script Files  -->
 <?php Main::flinker('footer'); ?>
</body>
</html>