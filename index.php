<?php require_once 'header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <?php

            if (isset($_GET['sayfa'])) {
                $GelenSayfaDegeri = $_GET['sayfa'];
            } else {
                $GelenSayfaDegeri = "";
            }

            if ($GelenSayfaDegeri == "Anasayfa") {
                require_once 'anasayfa.php';
            } elseif ($GelenSayfaDegeri == "Anketler") {
                require_once 'anketler.php';
            } elseif ($GelenSayfaDegeri == "AnketOlustur") {
                require_once 'anketolustur.php';
            } elseif ($GelenSayfaDegeri == "Profil") {
                require_once 'profil.php';
            } elseif ($GelenSayfaDegeri == "Sorular") {
                require_once 'sorular.php';
            } elseif ($GelenSayfaDegeri == "Anket") {
                require_once 'anket.php';
            } elseif ($GelenSayfaDegeri == "Cevaplar") {
                require_once 'cevaplar.php';
            } else {
                require_once '404.php';
            }

            ?>
        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>