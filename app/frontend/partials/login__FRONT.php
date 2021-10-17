<?php
if(isset($_POST['login_btn']) && $_SERVER['REQUEST_METHOD']) {
    $data = $_POST['frm'];
    self::login($data);
}
?>
<h1 class="text-center">
    ورود به پنل کاربری
</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?page=login'); ?>" method='POST' class="form">
    <div class="form-group">
        <label for="email">آدرس ایمیل</label>
        <input type="email" id='email' name='frm[email]' placeholder='آدرس ایمیل خود را وارد کنید' required autofocus>
    </div>
    <div class="form-group">
        <label for="password">رمزعبور</label>
        <input minlength='8' type="password" id='password' name='frm[password]' placeholder='رمزعبور خود را وارد کنید' required>
    </div>
    <div class="form-group">
        <input type="submit" value="ورود" name='login_btn' class='form-control btn btn-dark'>
    </div>
</form>