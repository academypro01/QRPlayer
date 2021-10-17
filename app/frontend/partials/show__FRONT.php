<?php
if(!isset($_GET['qr'])) {
  Main::setMessage('پیدا نشد', 'index.php');
}
$qr = Main::validate($_GET['qr']);
$qrdata = Main::showqr($qr);
?>
<div class="musicPlayer">

 <section>

    <div class="wrapper">
      <div class="polka-dot text-light text-center"><?php echo $qrdata['title']; ?></div>
      <div class="player-wrapper">
        <div class="player-container">
          <div class="player">
            <div class="cassete">
              <div class="rotator-container">
                <div class="cog left-cog">
                  <div class="chil1"></div>
                  <div class="chil2"></div>
                  <div class="cog-img"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                      <path d="M23.9,13l4.1-2.3l-4.1-7.1l-4.1,2.3l-1.6-0.8V0.3H9.9v4.8L8.2,5.9L4.1,3.6L0,10.7L4.1,13V15L0,17.3l4.1,7.1l4.1-2.3l1.6,1
	v4.7h8.2v-4.7l1.6-1l4.1,2.3l4.1-7.1L23.9,15C23.9,15,23.9,13,23.9,13z M14,16.7c-1.5,0-2.6-1.2-2.6-2.6c0-1.5,1.2-2.6,2.6-2.6
	s2.6,1.2,2.6,2.6S15.5,16.7,14,16.7z" />
                    </svg></div>
                </div>

                <div class="cog right-cog">
                  <div class="chil1"></div>
                  <div class="chil2"></div>
                  <div class="cog-img"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                      <path d="M23.9,13l4.1-2.3l-4.1-7.1l-4.1,2.3l-1.6-0.8V0.3H9.9v4.8L8.2,5.9L4.1,3.6L0,10.7L4.1,13V15L0,17.3l4.1,7.1l4.1-2.3l1.6,1
	v4.7h8.2v-4.7l1.6-1l4.1,2.3l4.1-7.1L23.9,15C23.9,15,23.9,13,23.9,13z M14,16.7c-1.5,0-2.6-1.2-2.6-2.6c0-1.5,1.2-2.6,2.6-2.6
	s2.6,1.2,2.6,2.6S15.5,16.7,14,16.7z" />
                    </svg></div>
                </div>
              </div>
            </div>
          </div>
          <div class="screws one"></div>
          <div class="screws two"></div>
          <div class="screws three"></div>
          <div class="screws four"></div>
          <div class="base">
            <div class="bottom-base"></div>
          </div>
        </div>
      </div>
      <div class="controls-container">
        <button class="btn play" onclick="bgmPlay()"></button>
        <button class="btn"></button>
        <button onclick="bgmStop()" class="btn"></button>
        <button class="btn"></button>
      </div>
    </div>
    <p><?php echo $qrdata['footer']; ?></p>
  </section>
  <audio id='player_audio' src='<?php echo ROOT_LINK.'/public/musics/'.$qrdata['music'];  ?>' type="audio/mp3"></audio>
  </div>