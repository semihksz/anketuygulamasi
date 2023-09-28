<?php
require_once 'src/islemler/baglanti.php';
require_once 'src/islemler/fonksiyonlar.php';


$AnketId = LinkSifreCoz($_GET['anket_id']);
$KullaniciId = LinkSifrele($_SESSION['kullanici_id']);

$deger = $db->prepare("SELECT * FROM anketler WHERE anket_id = {$AnketId}");
$deger->execute();
$anketler = $deger->fetch(PDO::FETCH_ASSOC);
$SoruSayisi = $anketler['anket_soru_sayisi'];

if (isset($_GET['AnketSil'])) {
    $AnketSil = $db->prepare("DELETE FROM anketler WHERE anket_id = {$AnketId}");
    $AnketSil->execute();
    for ($i = 1; $i <= $SoruSayisi; $i++) {
        $SoruSil = $db->prepare("DELETE FROM sorular WHERE anket_id = {$AnketId}");
        $SoruSil->execute();
    }

    if ($AnketSil && $SoruSil) {
        header("location:index.php?sayfa=Anketler&kullanici_id=$KullaniciId");
    }
}
