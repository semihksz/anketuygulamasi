<?php

require_once "src/islemler/baglanti.php";
require_once "src/islemler/fonksiyonlar.php";
$KullaniciId = urlencode(base64_encode($_SESSION['kullanici_id']));
if (isset($_POST['anket_olustur'])) {
    $AnketBaslik = $AnketSoruSayisi = "";
    $AnketBosErr = "";

    if (empty($_POST['anket_baslik'])) {
        $AnketBosErr = "Lütfen boş alan bırakmayınız!";
    } else {
        $AnketBaslik    =   Filtrele($_POST['anket_baslik']);
    }

    if (empty($_POST['anket_soru_sayisi'])) {
        $AnketBosErr = "Lütfen boş alan bırakmayınız!";
    } else {
        global $AnketSoruSayisi;
        $AnketSoruSayisi    = Filtrele($_POST['anket_soru_sayisi']);
    }

    if (empty($AnketBosErr)) {
        $ekle = $db->prepare("INSERT INTO anketler SET kullanici_id=?, anket_baslik=?, anket_soru_sayisi=?");
        $ekle->execute([$_SESSION['kullanici_id'], $AnketBaslik, $AnketSoruSayisi]);
        if ($ekle) {
            header("location:index.php?sayfa=Anketler&kullanici_id=$KullaniciId");
        }
    }
}



?>



<div class="card shadow-lg w-100">
    <?php
    if (!empty($AnketBosErr)) { ?>
        <div class="card-header">
            <div class="alert alert-danger text-center" role="alert">
                <strong><?= $AnketBosErr ?></strong>
            </div>
        </div>
    <?php }
    ?>
    <div class="card-body">
        <div class="d-sm-flex justify-content-center align-items-center d-block mb-9">
            <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Anket Oluştur
            </button>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Anket Oluştur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="" class="form-label">Anket Başlığı</label>
                                    <input type="text" name="anket_baslik" class="form-control" aria-describedby="helpId">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Anket Soru Sayısı</label>
                                    <input type="number" name="anket_soru_sayisi" class="form-control" aria-describedby="helpId">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
                                <button type="submit" class="btn btn-success" name="anket_olustur">Oluştur</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>