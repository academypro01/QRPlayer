<div class='text-center'>
    <img class='img-fluid' src="<?php Main::linkimage('404.gif'); ?>" alt="404 Not Found!">
    <p>متاسفانه صفحه شما پیدا نشد :(</p>
    <small>تا چند ثانیه دیگر به صفحه اصلی هدایت خواهید شد</small>
</div>
<?php
header("refresh:10, url=index.php");die;
?>