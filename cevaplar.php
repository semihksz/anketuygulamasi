<div class="card shadow-lg w-100">
    <div class="card-body">
        <div class="d-sm-flex d-block align-items-center justify-content-center mb-9">
            <div class="mb-3 mb-sm-0"></div>
            <div class="col-md-10 ">
                <?php

                require_once 'src/islemler/baglanti.php';
                require_once 'src/islemler/fonksiyonlar.php';

                $AnketId = LinkSifreCoz($_GET['anket_id']);

                $deger = $db->prepare("SELECT * FROM sorular WHERE anket_id = {$AnketId}");
                $deger->execute();
                $sorular = $deger->fetchAll(PDO::FETCH_ASSOC);

                foreach ($sorular as $soru) { ?>
                    <ul class="list-group list-group-numbered">
                        <li class="list-group-item active"><?= $soru['soru'] ?></li>
                        <?php
                        $deger = $db->prepare("SELECT * FROM cevaplar WHERE soru_id=?");
                        $deger->execute([
                            $soru['soru_id']
                        ]);
                        $CevapSayisi = $deger->rowCount();
                        $cevaplar = $deger->fetchAll(PDO::FETCH_ASSOC);
                        $iyi = 0;
                        $orta = 0;
                        $kotu = 0;

                        foreach ($cevaplar as $cevap) {
                            if ($cevap['cevap'] == "iyi") {
                                $iyi++;
                            } elseif ($cevap['cevap'] == "orta") {
                                $orta++;
                            } elseif ($cevap['cevap'] == "kotu") {
                                $kotu++;
                            }
                        }
                        if ($CevapSayisi == 0) {
                            echo "Bu soruya cevap verilmemiştir.";
                        } else {
                            $iyiyuzdehesaplama = ($iyi / $CevapSayisi) * 100;
                            $ortayuzdehesaplama = ($orta / $CevapSayisi) * 100;
                            $kotuyuzdehesaplama = ($kotu / $CevapSayisi) * 100;

                            echo "İyi: %" . number_format($iyiyuzdehesaplama, 2)  . "<br>";
                            echo "Orta: %" . number_format($ortayuzdehesaplama, 2) . "<br>";
                            echo "Kötü: %" . number_format($kotuyuzdehesaplama, 2) . "<br>";
                        }

                        ?>
                    </ul>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>