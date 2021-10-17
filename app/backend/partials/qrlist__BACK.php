<?php
Main::checkLogin();
$allQR = Main::qrlist();
?>
<div class="my-3">
    <a href="dashboard.php?page=generateQR">
        <button class='form-control btn btn-dark'>
            ساخت QR Code جدید
        </button>
    </a>
    <hr>
    <div class="card-deck justify-content-between d-flex flex-wrap">

    <?php
    if($allQR != NULL):
    while($row = mysqli_fetch_assoc($allQR)):  ?>

    <div class="card m-2" style="width: 18rem;">
    <img src="<?php echo ROOT_LINK.'/public/qr-code/'.$row['qr_id'].'.png'; ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <p class="card-text"><?php echo $row['title']; ?></p>
        <small><?php echo $row['footer']; ?></small>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <a class='text-decoration-none d-inline-block' href="dashboard.php?page=deleteqr&id=<?php echo $row['qr_id']; ?>">
            <button class='btn btn-danger'>حذف</button>
        </a>
        <a class='text-decoration-none d-inline-block' href="dashboard.php?page=editqr&id=<?php echo $row['qr_id']; ?>">
            <button class='btn btn-success'>ویرایش</button>
        </a>
        <a class='text-decoration-none d-inline-block' href="<?php echo ROOT_LINK.'/public/qr-code/'.$row['qr_id'].'.png'; ?>" download>
            <button class='btn btn-primary'>دانلود</button>
        </a>
    </div>
    </div>
    
    <?php endwhile; endif; ?>
    </div>
</div>