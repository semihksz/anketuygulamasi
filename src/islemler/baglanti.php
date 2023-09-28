<?php
ob_start();
session_start();

$host       =   "localhost";
$dbname     =   "anket_uygulamasi";
$username   =   "root";
$password   =   "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $hata) {
    echo $hata->getMessage();
}



$deger = $db->prepare("SELECT * FROM ayarlar");
$deger->execute();
$ayarlar = $deger->fetch(PDO::FETCH_ASSOC);
