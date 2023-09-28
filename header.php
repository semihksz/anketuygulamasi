<?php
require_once 'src/islemler/baglanti.php';
require_once 'src/islemler/fonksiyonlar.php';

if (!$_SESSION['kullanici_email'] && !$_SESSION['kullanici_sifre']) {
    header("location:giris.php");
}
$veri = $db->query("SELECT * FROM kullanicilar WHERE kullanici_id={$_SESSION['kullanici_id']}");
$veri->execute();
$kullanicilar = $veri->fetch(PDO::FETCH_ASSOC);
$KullaniciId = base64_encode($_SESSION['kullanici_id']);
Oturum();
?>

<!doctype html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $ayarlar['site_baslik'] ?></title>
    <link rel="shortcut icon" type="image/png" href="src/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="src/assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="index.php?sayfa=Anasayfa" class="text-nowrap logo-img">
                        <img src="src/assets/images/logos/dark-logo.svg" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Anasayfa</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="index.php?sayfa=Anasayfa" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Anasayfa</span>
                            </a>
                        </li>

                        <?php


                        if ($_SESSION['kullanici_rol'] == "Admin") { ?>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Kullanıcı İşlemleri</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?sayfa=Kullanıcılar" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-article"></i>
                                    </span>
                                    <span class="hide-menu">Kullanıcılar</span>
                                </a>
                            </li>

                        <?php } elseif ($_SESSION['kullanici_rol'] == "Kullanıcı") { ?>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Anket İşlemleri</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?sayfa=Anketler" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-article"></i>
                                    </span>
                                    <span class="hide-menu">Anketler</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?sayfa=AnketOlustur" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-alert-circle"></i>
                                    </span>
                                    <span class="hide-menu">Anket Oluştur</span>
                                </a>
                            </li>
                        <?php }



                        ?>


                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Profil</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="index.php?sayfa=Profil" aria-expanded="false">
                                <span>
                                    <i class="ti ti-login"></i>
                                </span>
                                <span class="hide-menu">Profilim</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="src/assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                                    <label class="ms-2"><?= $_SESSION['kullanici_adi'] . ' '  . $_SESSION['kullanici_soyadi'] ?></label>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="index.php?sayfa=Profil" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Profilim</p>
                                        </a>
                                        <a href="index.php?sayfa=ProfilGuncelle" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">Bilgilerimi Düzenle</p>
                                        </a>
                                        <a href="cikis.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Çıkış Yap</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->