<?php
require_once 'src/islemler/baglanti.php';
require_once 'src/islemler/fonksiyonlar.php';


$KullaniciAdi = $KullaniciSoyAdi = $KullaniciEmail = $KullaniciSifre = $KullaniciTekrarSifre = "";
$KullaniciAdiErr = $KullaniciSoyAdiErr = $KullaniciEmailErr = $KullaniciSifreErr = $KullaniciTekrarSifreErr = $KullaniciSifreUyusmuyorErr = $KullaniciVarErr = "";

if (isset($_POST['KayitOl'])) {
    $deger = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_email=?");
    $deger->execute([filter_var($_POST['kullanici_email'], FILTER_VALIDATE_EMAIL)]);
    $deger->fetchAll(PDO::FETCH_ASSOC);


    if (empty($_POST['kullanici_adi'])) {
        $KullaniciAdiErr = "Lütfen boş alan bırakmayınız.";
    } else {
        $KullaniciAdi = Filtrele($_POST['kullanici_adi']);
    }
    if (empty($_POST['kullanici_soyadi'])) {
        $KullaniciSoyAdiErr = "Lütfen boş alan bırakmayınız.";
    } else {
        $KullaniciSoyAdi = Filtrele($_POST['kullanici_soyadi']);
    }
    if (empty($_POST['kullanici_email'])) {
        $KullaniciEmailErr = "Lütfen boş alan bırakmayınız.";
    } elseif (!filter_var($_POST['kullanici_email'], FILTER_VALIDATE_EMAIL)) {
        $KullaniciEmailErr = "Email Hatalı!";
    } else {
        $KullaniciEmail = Filtrele($_POST['kullanici_email']);
    }
    if (empty($_POST['kullanici_sifre'])) {
        $KullaniciSifreErr = "Lütfen boş alan bırakmayınız.";
    } else {
        $KullaniciSifre = Sifrele($_POST['kullanici_sifre']);
    }
    if (empty($_POST['kullanici_tekrarsifre'])) {
        $KullaniciTekrarSifreErr = "Lütfen boş alan bırakmayınız.";
    } else {
        $KullaniciTekrarSifre = Sifrele($_POST['kullanici_tekrarsifre']);
    }
    if ($_POST['kullanici_sifre'] != $_POST['kullanici_tekrarsifre']) {
        $KullaniciSifreUyusmuyorErr = "Şifreler birbiri ile uyuşmadı!";
    }
    if ($deger->rowCount()) {
        $KullaniciVarErr = "Bu Email'e sahip kullanıcı bulunmaktadır.";
    }
    if (empty($KullaniciAdiErr) && empty($KullaniciSoyAdiErr) && empty($KullaniciEmailErr) && empty($KullaniciSifreErr) && empty($KullaniciTekrarSifreErr) && empty($KullaniciSifreUyusmuyorErr) && empty($KullaniciVarErr)) {

        $kayit = $db->prepare("INSERT INTO kullanicilar SET kullanici_adi=?, kullanici_soyadi=?, kullanici_email=?, kullanici_sifre=?");
        $kayit->execute([
            $KullaniciAdi,
            $KullaniciSoyAdi,
            $KullaniciEmail,
            $KullaniciSifre,
        ]);
        if ($kayit) {
            header('location: giris.php');
        }
    }
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $ayarlar['site_baslik'] ?></title>
    <link rel="shortcut icon" type="image/png" href="src/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="src/assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-75">
                    <div class="col-md-10 col-lg-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="kayit.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="src/assets/images/logos/dark-logo.svg" width="180" alt="" />
                                </a>
                                <form method="POST">
                                    <div class="col-md-12 mt-4">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 ">
                                                <label for="exampleInputText1" class="form-label">Kullanıcı Adı</label>
                                                <input type="text" class="form-control shadow" id="exampleInputText1" aria-describedby="textHelp" name="kullanici_adi" value="<?= $KullaniciAdi ?>" />
                                                <label class="form-label text-danger"><?= $KullaniciAdiErr ?></label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="exampleInputText2" class="form-label">Kullanıcı Soyadı</label>
                                                <input type="text" class="form-control shadow" id="exampleInputText1" aria-describedby="textHelp" name="kullanici_soyadi" value="<?= $KullaniciSoyAdi ?>" />
                                                <label class="form-label text-danger"><?= $KullaniciSoyAdiErr ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email Adresi</label>
                                        <input type="email" class="form-control shadow" id="exampleInputEmail1" aria-describedby="emailHelp" name="kullanici_email" value="<?= $KullaniciEmail ?>" />
                                        <label class="form-label text-danger"><?= $KullaniciEmailErr ?></label>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Şifre</label>
                                        <input type="password" class="form-control shadow" id="exampleInputPassword1" name="kullanici_sifre" />
                                        <label class="form-label text-danger"><?= $KullaniciSifreErr ?></label>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Tekrar Şifre</label>
                                        <input type="password" class="form-control shadow" id="exampleInputPassword1" name="kullanici_tekrarsifre" />
                                        <label class="form-label text-danger"><?= $KullaniciTekrarSifreErr ?></label>
                                    </div>
                                    <label class="form-label text-danger"><?= $KullaniciSifreUyusmuyorErr ?></label>
                                    <label class="form-label text-danger"><?= $KullaniciVarErr ?></label>
                                    <button name="KayitOl" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Kayıt Ol</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Zaten bir hesabın var mı?</p>
                                        <a class="text-primary fw-bold ms-2" href="giris.php">Giriş Yap</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="src/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>