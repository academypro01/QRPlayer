<?php
Main::checkLogin();
if(!isset($_GET['id'])) {
    Main::setMessage('ویرایش نشد', 'dashboard.php?page=qrlist');
}
$id = Main::validate($_GET['id']);
$qrdata = Main::editqr($id);
if($qrdata == false) {
    Main::setMessage('ویرایش نشد', 'dashboard.php?page=qrlist');
}

if(isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['frm'];
    Main::updateqr($data, $id);
}
?>
<h1 class='text-center'>
    ویرایش متن QR
</h1>
<hr>
<form method='POST' enctype='multipart/form-data' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?page=editqr&id='.$id); ?>" class="form">
    <div class="form-group">
        <label for="title">عنوان QR</label>
        <input value="<?php echo $qrdata['title']; ?>" type="text" name="frm[title]" id="title" class='form-control' required placeholder='عنوان را انتخاب کنید'>
    </div>
    <div class="form-group">
        <label for="footer">متن کوتاه</label>
        <input value="<?php echo $qrdata['footer']; ?>" type="text" name="frm[footer]" id="footer" class='form-control' required placeholder='یک متن کوتاه را وارد کنید'>
    </div>
    <div class="form-group">
        <input type="submit" value="بروزرسانی اطلاعات" class='form-control btn btn-dark' name='btn'>
    </div>
</form>

