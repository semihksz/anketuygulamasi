<?php
$KullaniciId = $_SESSION['kullanici_id'];
$KullaniciAdi = $_SESSION['kullanici_adi'];
$KullaniciSoyadi = $_SESSION['kullanici_soyadi'];
$KullaniciEmail = $_SESSION['kullanici_email'];
$KullaniciSifre = $_SESSION['kullanici_sifre'];
$KullaniciRol = $_SESSION['kullanici_rol'];

$KullaniciAdi = $KullaniciSoyadi = $KullaniciEmail = $KullaniciSifre = "";
$KullaniciAdiErr = $KullaniciSoyadiErr = $KullaniciEmailErr = $KullaniciSifreErr = "";

if (isset($_POST['ProfilGuncelle'])) {
    if (empty($_SESSION['kullanici_adi'])) {
        $KullaniciAdiErr = "Lütfen boş alan bırakmayınız!";
    } else {
        $KullaniciAdi = Filtrele($_POST['KullaniciAdi']);
    }

    if (empty($_SESSION['kullanici_soyadi'])) {
        $KullaniciSoyadiErr = "Lütfen boş alan bırakmayınız!";
    } else {
        $KullaniciSoyadi = Filtrele($_POST['KullaniciSoyadi']);
    }

    if (empty($_SESSION['kullanici_email'])) {
        $KullaniciEmailErr = "Lütfen boş alan bırakmayınız!";
    } else {
        $KullaniciEmail = Filtrele($_POST['KullaniciEmail'], FILTER_VALIDATE_EMAIL);
    }

    if (!empty($KullaniciAdiErr) || !empty($KullaniciSoyadiErr) || !empty($KullaniciEmailErr)) {
        if ($_SESSION['kullanici_rol'] == "Kullanıcı") {
            $guncelle = $db->prepare("UPDATE kullanicilar SET 
            KullaniciAdi =: kullanici_adi,
            KullaniciSoyadi =: kullanici_soyadi,
            KullaniciEmail =: kullanici_email,
            KullaniciSifre =: kullanici_Sifre,
            KullaniciRol =: kullanici_rol WHERE KullaniciId =: kullanici_id
        ");
            $guncelle->execute([
                'KullaniciAdi' => $KullaniciAdi,
                'KullaniciSoyadi' => $KullaniciSoyadi,
                'KullaniciEmail' => $KullaniciEmail,
                'KullaniciSifre' => $KullaniciSifre,
                'KullaniciRol' => $KullaniciRol,
                'KullaniciId' => $KullaniciId,
            ]);
        }
        if ($guncelle) {
            echo '<div class="alert alert-success" role="alert">
            Güncelleme Başarılı
        </div>';
        }
    }
}

?>


<div class="card shadow-lg w-100">
    <div class="card-body">
        <div class="d-sm-flex d-block align-items-center justify-content-center mb-9">
            <div class="col-md-10 mb-3">
                <h1 class="mb-5">Profil</h1>
                <form method="post">
                    <input type="hidden" name="KullaniciId" class="form-control" value="<?= $_SESSION['kullanici_rol'] ?>">
                    <input type="hidden" name="KullaniciId" class="form-control" value="<?= $_SESSION['kullanici_id'] ?>">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Kullanıcı Adı</label>
                            <input type="text" name="KullaniciAdi" class="form-control" value="<?= $_SESSION['kullanici_adi'] ?>">
                            <label class="text-danger"><?= $KullaniciAdiErr ?></label>
                        </div>
                        <div class="col">
                            <label class="form-label">Kullanıcı Soyadı</label>
                            <input type="text" name="KullaniciSoyadi" class="form-control" value="<?= $_SESSION['kullanici_soyadi'] ?>">
                            <label class="text-danger"><?= $KullaniciSoyadiErr ?></label>
                        </div>
                    </div>
                    <label class="form-label">Kullanıcı Email</label>
                    <input type="email" name="KullaniciEmail" class="form-control" value="<?= $_SESSION['kullanici_email'] ?>">
                    <label class="text-danger"><?= $KullaniciEmailErr ?></label><br>
                    <label class="form-label mt-3">Kullanıcı Şifre</label>
                    <input type="password" name="KullaniciSifre" class="form-control" value="">
                    <button class="btn btn-primary mt-3 w-75 d-flex justify-content-center mx-auto" name="ProfilGuncelle">Profili Düzenle</button>

                </form>
            </div>
        </div>
    </div>
</div>