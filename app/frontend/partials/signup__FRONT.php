<?php
if(isset($_POST['signup_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['frm'];
    Main::signup($data);
}
?>
<h1 class='text-center'>
    فرم ثبت نام
</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?page=signup'); ?>" method='POST' class="form">
    <div class="form-group">
        <label for="email">آدرس ایمیل</label>
        <input id='email' type="email" name='frm[email]' required autofocus placeholder='ایمیل خود را وارد کنید'>
    </div>
    <div class="form-group">
        <label for="password">رمزعبور</label>
        <input minlength='8' id='password' type="password" name='frm[password]' required placeholder='رمزعبور خود را وارد کنید'>
    </div>
    <div class="form-group">
        <label for="password_confirm">تایید رمزعبور</label>
        <input minlength='8' id='password_confirm' type="password" name='frm[password_confirm]' required placeholder='رمزعبور خود را وارد کنید'>
    </div>
    <div class="form-group">
        <input type="submit" value="ثبت نام" class='btn btn-dark' name='signup_btn'>
    </div>
</form>