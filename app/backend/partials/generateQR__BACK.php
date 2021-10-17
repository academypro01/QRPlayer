<?php
Main::checkLogin();
if(isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $music = $_FILES['music'];
    $data = $_POST['frm'];
    Main::newQR($data, $music);
}
?>
<h1 class='text-center'>
    ساخت QR
</h1>
<hr>
<form method='POST' enctype='multipart/form-data' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?page=generateQR'); ?>" class="form">
    <div class="form-group">
        <label for="title">عنوان QR</label>
        <input type="text" name="frm[title]" id="title" class='form-control' required placeholder='عنوان را انتخاب کنید'>
    </div>
    <div class="form-group">
        <label for="footer">متن کوتاه</label>
        <input type="text" name="frm[footer]" id="footer" class='form-control' required placeholder='یک متن کوتاه را وارد کنید'>
    </div>
    <div class="form-group">
        <label for="music">موزیک QR</label>
        <input type="file" name="music" id="music" class='form-control' required>
    </div>
    <div class="form-group">
        <input type="submit" value="ثبت اطلاعات" class='form-control btn btn-dark' name='btn'>
    </div>
</form>