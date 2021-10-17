<?php
Main::checkLogin();
if(!isset($_GET['id'])) {
    Main::setMessage('حذف نشد', 'dashboard.php?page=qrlist');
}
$id = Main::validate($_GET['id']);
Main::deleteqr($id);