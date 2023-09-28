<?php

require_once 'src/islemler/baglanti.php';
require_once 'src/islemler/fonksiyonlar.php';

if (isset($_SESSION['GirisKontrol']) && $_SESSION['GirisKontrol'] == true) {
    header("location:index.php?sayfa=Anasayfa");
}

$KullaniciEmail = $KullaniciSifre = "";
$KullaniciEmailErr = $KullaniciSifreErr = $GirisErr = "";

if (isset($_POST['GirisYap'])) {
    if (empty($_POST['kullanici_email'])) {
        $KullaniciEmailErr = "Lütfen boş alan bırakmayınız!";
    } elseif (!filter_var($_POST['kullanici_email'], FILTER_VALIDATE_EMAIL)) {
        $KullaniciEmailErr = "Email Hatalı!";
    } else {
        $KullaniciEmail = Filtrele($_POST['kullanici_email'], FILTER_VALIDATE_EMAIL);
    }
    if (empty($_POST['kullanici_sifre'])) {
        $KullaniciSifreErr = "Lütfen boş alan bırakmayınız!";
    } else {
        $KullaniciSifre = Sifrele($_POST['kullanici_sifre']);
    }

    if (empty($KullaniciEmailErr) && empty($KullaniciSifreErr)) {

        $deger = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_email=? AND kullanici_sifre=?");
        $deger->execute([
            $KullaniciEmail,
            $KullaniciSifre,
        ]);
        $giris = $deger->fetch(PDO::FETCH_ASSOC);
        $giriskontrol = $deger->rowCount();
        if ($giriskontrol > 0) {
            foreach ($giris as $key => $value) {
                $_SESSION['GirisKontrol'] = true;
                $_SESSION[$key] = $value;
            }
            header("Location: index.php?sayfa=Anasayfa");
            exit; // İşlem tamamlandıktan sonra kodun devam etmesini önlemek için exit() kullanın
        } else {
            $GirisErr = "Giriş Bilgileri Hatalı!";
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
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="giris.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="src/assets/images/logos/dark-logo.svg" width="180" alt="" />
                                </a>
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail2" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" name="kullanici_email" />
                                        <label class="form-label text-danger"><?= $KullaniciEmailErr ?></label>
                                    </div>

                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Şifre</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="kullanici_sifre" />
                                        <label class="form-label text-danger"><?= $KullaniciSifreErr ?></label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" />
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Beni Hatırla
                                            </label>
                                        </div>
                                        <a class="text-primary fw-bold" href="#">Şifremi Unuttum ?</a>
                                    </div>
                                    <label class="form-label text-danger"><?= $GirisErr ?></label>
                                    <button name="GirisYap" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Giriş Yap</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Üye Değil Misin?</p>
                                        <a class="text-primary fw-bold ms-2" href="kayit.php">Kayıt Ol</a>
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