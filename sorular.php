<?php
require_once 'src/islemler/baglanti.php';
$AnketId = base64_decode(urldecode($_GET['anket_id']));
$KullaniciId = LinkSifrele($_SESSION['kullanici_id']);
$deger = $db->prepare("SELECT * FROM anketler WHERE anket_id = {$AnketId}");
$deger->execute();
$anketler = $deger->fetch(PDO::FETCH_ASSOC);
$SoruSayisi = $anketler['anket_soru_sayisi'];


$Soru = "";
$SoruErr = "";
if (isset($_POST['SoruEkle'])) {

    for ($i = 1; $i <= $SoruSayisi; $i++) {
        if (empty($_POST['soru'] . $i)) {
            $SoruErr = "Lütfen boş alan bırakmayınız!";
        } else {
            $Soru = Filtrele($_POST['soru' . $i]);
        }
        $SoruDurumu = "Soru Eklendi.";
        $ekle = $db->prepare("INSERT INTO sorular SET kullanici_id=?, anket_id=?, soru=?");
        $ekle->execute([
            $_SESSION['kullanici_id'],
            $AnketId,
            $Soru,
        ]);
        $guncelle = $db->prepare("UPDATE anketler SET
        soru_durumu=:soru_durumu WHERE anket_id=:anket_id
        ");
        $guncelle->execute([
            'soru_durumu' => $SoruDurumu,
            'anket_id' => $AnketId
        ]);

        if ($ekle && $guncelle) {
            header("location:index.php?sayfa=Anketler&kullanici_id=$KullaniciId");
        }
    }
}

?>


<div class="card shadow-lg w-100">
    <div class="d-sm-flex d-bloc m-4">
        <div class="col-md-12">
            <?php
            for ($i = 1; $i <= $SoruSayisi; $i++) { ?>
                <div class="card-body">
                    <form method="post">
                        <label for="" class="form-label"><?= $i ?>. Soru <label class="text-danger">*</label></label>
                        <input type="text" class="form-control" name="soru<?= $i ?>" aria-describedby="helpId">
                        <label class="form-label text-danger"><?= $SoruErr ?></label>
                </div>
            <?php }
            ?>
            <button type="submit" class="btn btn-primary w-100" name="SoruEkle">Soruları Ekle</button>
            </form>
        </div>
    </div>
</div>