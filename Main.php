<?php
require_once 'config.php';
require_once 'app/tc-lib-barcode/vendor/autoload.php';
class Main {
    // Link images easily
    public static function linkimage($name) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $name = basename($name);
        if(file_exists(ROOTPATH."public/images/$name")) {
            echo ROOT_LINK."/public/images/$name";
        }
    }

    // link CSS File
    public static function linkcss($name) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $name = basename($name);
        if(file_exists(ROOTPATH."public/css/$name")) {
            echo ROOT_LINK."/public/css/$name";
        }
    }

    // Link JS File
    public static function linkjs($name) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $name = basename($name);
        if(file_exists(ROOTPATH."public/js/$name")) {
            echo ROOT_LINK."/public/js/$name";
        }
    }


    // link a frontend php files
    public static function flinker($name) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $array = explode('.',$name);
        $name = basename($array[0]);
        if(file_exists(ROOTPATH."app".DS."frontend".DS."partials".DS.$name.'__FRONT.php')) {
            include_once ROOTPATH."app".DS."frontend".DS."partials".DS.$name.'__FRONT.php';
        }
    }

    // link a backend php files
    public static function blinker($name) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $array = explode('.',$name);
        $name = basename($array[0]);
        if(file_exists(ROOTPATH."app".DS."backend".DS."partials".DS.$name.'__BACK.php')) {
            include_once ROOTPATH."app".DS."backend".DS."partials".DS.$name.'__BACK.php';
        }
    }

    // validation method to sanitize data
    public static function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // database connection
    public static function dbsConnection() {
        $connection = mysqli_connect(DBS_SERVER, DBS_USER, DBS_PASS, DBS_NAME);
        mysqli_query($connection, "SET NAMES utf8");
        if(!$connection) {
            die('DBS Connection Error!');
        }
        return $connection;
    }

    //set session message
    public static function setMessage($message, $location = NULL) {
        $message = self::validate($message);
        $_SESSION['status_message'] = $message;
        if($location != NULL) {
            header("refresh:0, url=$location");die;
        }
    }

    // get session message
    public static function getMessage() {
        if(isset($_SESSION['status_message']) && $_SESSION['status_message'] != NULL) {
            echo "<script>Swal.fire('".$_SESSION['status_message']."')</script>";
            $_SESSION['status_message'] = NULL;
            unset($_SESSION['status_message']);
        }
    }

    // check email exists
    public static function checkEmail($email) {
        $email = self::validate($email);
        $connection = self::dbsConnection();
        $sql = "SELECT id FROM users_tbl WHERE email='$email'";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0) {
            return true;
        }else{
            return false;
        }
    }



    // generate Token
    public static function token() {
        $username = filter_var($_SESSION['username'], FILTER_SANITIZE_STRING);
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $token = md5($username.$ip.$user_agent.SALT);
        return $token;
    }

    // signup method
    public static function signup($data) {
        $email = self::validate($data['email']);
        $password = self::validate($data['password']);
        $password_confirm = self::validate($data['password_confirm']);

        if($password != $password_confirm) {
            self::setMessage("پسورد ها یکسان نیست", 'index.php?page=signup');
        }

        if(self::checkEmail($email)) {
            self::setMessage('ایمیل وجود دارد', 'index.php?page=signup');
        }

        $password = sha1($password.SALT);

        $connection = self::dbsConnection();
        $sql = "INSERT INTO users_tbl (email, password) VALUES ('$email', '$password')";

        if(mysqli_query($connection, $sql)) {
            self::setMessage('ثبت نام انجام شد', 'index.php?page=login');
        }else{
            self::setMessage('ثبت نام انجام نشد', 'index.php?page=signup');
        }
    }

    // user login method
    public static function login($data) {
        $email = self::validate($data['email']);
        $password = self::validate($data['password']);

        if(!self::checkEmail($email)) {
            self::setMessage('اطلاعات صحیح نیست', 'index.php?page=login');
        }

        $password = sha1($password.SALT);

        $connection = self::dbsConnection();
        $sql = "SELECT * FROM users_tbl WHERE email='$email'";

        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row['password'] != $password) {
            self::setMessage('اطلاعات صحیح نیست', 'index.php?page=login');
        }

        if($row['isActive'] == '0') {
            self::setMessage('اکانت غیرفعال است', 'index.php?page=login');
        }

        $_SESSION['username'] = $row['email'];
        $_SESSION['user_id']  = $row['id'];
        $_SESSION['isAdmin']  = $row['isAdmin'];
        $_SESSION['token']    = self::token();

        header("Location: dashboard.php");die;
    }

    // check user login
    public static function checkLogin() {
        if(isset($_SESSION['token'])) {
            $token = $_SESSION['token'];
            if($token != self::token()) {
                self::setMessage('دوباره وارد شوید', 'index.php?page=login');
            }
        }else{
            self::setMessage('دوباره وارد شوید', 'index.php?page=login');
        }
    }

    // upload music
    public static function upload($music) {
        self::checkLogin();
        $name = self::validate($music['name']);
        $type = self::validate($music['type']);
        $size = self::validate($music['size']);
        $error = self::validate($music['error']);
        $temp_name = $music['tmp_name'];

        // while lists
        $valid_size = 5*1024*1024;
        $valid_type = 'audio/mpeg';
        $valid_ext  = 'mp3';

        if($error != '0') {
            self::setMessage('دوباره امتحان کنید', 'dashboard.php?page=generateQR');
        }

        // check type
        if($type != $valid_type) {
            self::setMessage('فرمت mp3 انتخاب کنید', 'dashboard.php?page=generateQR');
        }

        // get extension
        $array = explode('.', $name);
        $ext = end($array);
        
        // check extension
        if($ext != $valid_ext) {
            self::setMessage('فرمت mp3 انتخاب کنید', 'dashboard.php?page=generateQR');
        }

        // generate new name
        $new_name = uniqid("QR".rand(999,99999));
        $new_name2 = $new_name.'.mp3';
        
        $upload_path = ROOTPATH.'public'.DS.'musics'.DS;
        
        $full_path = $upload_path.$new_name2;
        
        if(move_uploaded_file($temp_name, $full_path)) {
            return $new_name2;
        }else{
            self::setMessage('دوباره امتحان کنید', 'dashboard.php?page=generateQR');
        }

    }

    // qr code png generator
    public static function qrpng($id) {
        self::checkLogin();
        $link = ROOT_LINK."/?page=show&qr=$id";
        $barcode = new \Com\Tecnick\Barcode\Barcode();
        $targetPath = ROOTPATH.'public'.DS."qr-code".DS;
        
        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $bobj = $barcode->getBarcodeObj('QRCODE,H', $link, - 16, - 16, 'black', array(
            - 2,
            - 2,
            - 2,
            - 2
        ))->setBackgroundColor('#fff');
        
        $imageData = $bobj->getPngData();
        
        file_put_contents($targetPath . $id . '.png', $imageData);

    }

    // add new QR Code
    public static function newQR($data, $file) {
        self::checkLogin();
        $QRmusic = self::upload($file);
        $title = self::validate($data['title']);
        $footer = self::validate($data['footer']);
        $user_id = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : die;
        $qr_id = uniqid("QRrQ".rand(999,99999));

        $connection = self::dbsConnection();

        $sql = "INSERT INTO qrcodes (user_id, title, footer, music, qr_id) VALUES ('$user_id', '$title', '$footer', '$QRmusic', '$qr_id')";

        mysqli_query($connection, $sql);
        self::qrpng($qr_id);
        self::setMessage('با موفقیت ثبت شد', 'dashboard.php?page=generateQR');
    }

    // get QR Code List
    public static function qrlist() {
        self::checkLogin();
        $user_id = self::validate($_SESSION['user_id']);
        $connection = self::dbsConnection();
        $sql = "SELECT * FROM qrcodes WHERE user_id='$user_id' ORDER BY id DESC";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0) {
            return $result;
        }
    }

    // delete qr code
    public static function deleteqr($id) {
        self::checkLogin();
        $id = self::validate($id);
        $connection = self::dbsConnection();
        $user_id = self::validate($_SESSION['user_id']);
        $sql = "DELETE FROM qrcodes WHERE qr_id='$id' AND user_id='$user_id'";
        $sql2 = "SELECT music FROM qrcodes WHERE qr_id='$id' AND user_id='$user_id'";
        $result = mysqli_query($connection, $sql2);
        $row = mysqli_fetch_assoc($result);
        $music_name = $row['music'];
        mysqli_query($connection, $sql);
        unlink(ROOTPATH.'public/musics/'.$music_name);
        unlink(ROOTPATH.'public/qr-code/'.$id.'.png');
        self::setMessage('حذف شد', 'dashboard.php?page=qrlist');
    }

    // edit qr code
    public static function editqr($id) {
        self::checkLogin();
        $id = self::validate($id);
        $connection = self::dbsConnection();
        $user_id = self::validate($_SESSION['user_id']);
        $sql = "SELECT * FROM qrcodes WHERE qr_id='$id' AND user_id='$user_id'";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        }else{
            return false;
        }
    }

    // update qr data
    public static function updateqr($data, $id) {
        $id = self::validate($id);
        $title = self::validate($data['title']);
        $footer = self::validate($data['footer']);

        $connection = self::dbsConnection();
        $user_id = self::validate($_SESSION['user_id']);

        $sql = "UPDATE qrcodes SET title='$title', footer='$footer' WHERE qr_id='$id' AND user_id='$user_id'";
        if(mysqli_query($connection, $sql)) {
            self::setMessage('ویرایش شد', 'dashboard.php?page=qrlist');
        }else{
            self::setMessage('ویرایش نشد', 'dashboard.php?page=qrlist');
        }
    }

    // show qr method
    public static function showqr($id) {
        $id = self::validate($id);
        $connection = self::dbsConnection();
        $sql = "SELECT * FROM qrcodes WHERE qr_id='$id'";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0) {
           $row = mysqli_fetch_assoc($result);
           return $row;
        }else{
            self::setMessage('پیدا نشد', 'index.php');
        }
    }
}