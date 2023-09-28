<div class="card shadow-lg w-100">
    <div class="d-sm-flex d-block mb-9 m-4">
        <div class="col-md-12">
            <div class="row">
                <?php
                require_once 'src/islemler/baglanti.php';
                $KullaniciId = base64_decode(urldecode($_SESSION['kullanici_id']));
                $deger = $db->prepare("SELECT * FROM anketler WHERE kullanici_id = {$_SESSION['kullanici_id']}");
                $deger->execute();
                $anketler = $deger->fetchAll(PDO::FETCH_ASSOC);
                foreach ($anketler as $key => $anket) {
                    if ($anket['soru_durumu'] == "Soru Eklenmedi.") { ?>
                        <div class="col-md-4">
                            <div class="card bg-dark text-center">
                                <div class="card-body">
                                    <h4 class="card-title text-white"><?= $anket['anket_baslik'] ?></h4>
                                </div>
                                <div class="card-footer">
                                    <a href="index.php?sayfa=Sorular&anket_id=<?= LinkSifrele($anket['anket_id']) ?>" class="btn btn-primary">Düzenle</a>
                                    <a href="silislemleri.php?AnketSil=AnketSil&anket_id=<?= LinkSifrele($anket['anket_id']) ?>" class="btn btn-danger">Sil</a>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($anket['soru_durumu'] == "Soru Eklendi.") { ?>
                        <div class="col-md-4">
                            <div class="card bg-dark text-center">
                                <div class="card-body">
                                    <h4 class="card-title text-white"><?= $anket['anket_baslik'] ?></h4>
                                </div>
                                <div class="card-footer col-md-12">
                                    <a href="index.php?sayfa=Anket&anket_id=<?= LinkSifrele($anket['anket_id']) ?>" class="col-12 btn btn-primary">Anketi Gör</a>
                                    <a href="index.php?sayfa=Cevaplar&anket_id=<?= LinkSifrele($anket['anket_id']) ?>" class="col-12 mt-2 btn btn-primary">Cevapları Gör</a>
                                    <a href="silislemleri.php?AnketSil=AnketSil&anket_id=<?= LinkSifrele($anket['anket_id']) ?>" class="col-12 mt-2 col-12  btn btn-danger">Sil</a>
                                </div>
                            </div>
                        </div>
                <?php }
                }

                ?>
            </div>
        </div>
    </div>
</div>