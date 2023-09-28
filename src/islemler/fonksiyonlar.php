<?php

function Oturum()
{
    require_once 'baglanti.php';
    if (!isset($_SESSION['kullanici_email']) or !isset($_SESSION['kullanici_sifre'])) {
        header("location:index.php");
        exit;
    } else {
        return true;
    }
}


function Filtrele($deger)
{

    $bir    =   trim($deger);
    $iki    =   strip_tags($bir);
    $uc     =   htmlspecialchars($iki);
    $sonuc  =   $uc;
    return $sonuc;
}

function Sifrele($deger)
{
    $temizle = str_replace(' ', '', $deger);
    $sifrele = sha1(md5($temizle));
    $kisalt = mb_substr($sifrele, 0, 32);
    $sonuc = $kisalt;
    return $sonuc;
}

function LinkSifrele($link)
{
    $sonuc = urlencode(base64_encode($link));
    return $sonuc;
}

function LinkSifreCoz($link)
{
    $sonuc = urldecode(base64_decode($link));
    return $sonuc;
}
