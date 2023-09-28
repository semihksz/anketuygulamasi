<div class="card shadow-lg w-100">
    <div class="card-body">
        <div class="d-sm-flex d-block align-items-center justify-content-center mb-9">
            <div class="mb-3 mb-sm-0"></div>
            <div class="col-md-8">
                <?php
                require_once 'src/islemler/baglanti.php';
                require_once 'src/islemler/fonksiyonlar.php';

                $AnketId = LinkSifreCoz($_GET['anket_id']);
                $KullaniciId = LinkSifrele($_SESSION['kullanici_id']);
                $deger = $db->prepare("SELECT * FROM sorular WHERE anket_id = {$AnketId}");
                $deger->execute();
                $sorular = $deger->fetchAll(PDO::FETCH_ASSOC);
                $SoruSayisi = $deger->rowCount();
                $Numaralandırma = 0;

                $SoruErr = "";
                if (isset($_POST['AnketiGonder'])) {

                    if (isset($_POST['soru'])) {
                        $GelenCevaplar = $_POST['soru'];
                        $SoruId = $_POST['soru_id'];
                        $Cevaplar = array_combine($SoruId, $GelenCevaplar);
                        $IpAdresi = $_SERVER['REMOTE_ADDR'];
                        $Tarih = time();
                        $BelirlenecekZaman = 15; //saniye olarak

                        $ZamanFarki = $Tarih - $BelirlenecekZaman;

                        $oykullanacakdeger = $db->prepare("SELECT * FROM oykullananlar WHERE oykullanan_ipadresi=? and oykullanan_tarih >= ?");
                        $oykullanacakdeger->execute([
                            $IpAdresi,
                            $ZamanFarki
                        ]);
                        $oykullanacaksayisi = $oykullanacakdeger->rowCount();
                        if ($oykullanacaksayisi > 0) {
                            echo "daha önce oy kullandığınız belirlendir. lütfen 2 dakika bekleyiniz ve tekrar oyunuzu kullanınız.";
                        } else {
                            foreach ($Cevaplar as $SoruId => $Cevap) {
                                $kaydet = $db->prepare("INSERT INTO cevaplar SET anket_id=?, soru_id=?, cevap=?");
                                $kaydet->execute([
                                    $AnketId,
                                    $SoruId,
                                    $Cevap
                                ]);
                            }
                            if ($kaydet) {
                                $oykullanankaydet = $db->prepare("INSERT INTO oykullananlar SET oykullanan_ipadresi=?, oykullanan_tarih=?");
                                $oykullanankaydet->execute([
                                    $IpAdresi,
                                    $Tarih
                                ]);
                            }
                            if ($oykullanankaydet) {
                                echo "oy kullanma başarılı. teşekkürler";
                            }
                        }
                    } else {
                        $SoruErr = "Lütfen Boş Alan Bırakmayınız!";
                    }
                }
                foreach ($sorular as $soru) {
                    $Numaralandırma++; ?>
                    <form method="post">
                        <ul class="list-group">
                            <li class="list-group-item active"><?= $Numaralandırma . ". " ?><?= $soru['soru'] . " <label class='text-danger fs-5'>*<label>" ?></li>
                            <li class="list-unstyled m-3 d-flex justify-content-between">
                                <input type="hidden" class="form-control" name="soru_id[]" value="<?= $soru['soru_id'] ?>">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="<?= "soru[]" . $Numaralandırma ?>" value="iyi">
                                    <i class="fa-solid fa-face-laugh-beam display-4" style="color: green;"></i>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="<?= "soru[]" . $Numaralandırma ?>" value="orta">
                                    <i class="fa-solid fa-face-meh display-4" style="color: orange;"></i>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="<?= "soru[]" . $Numaralandırma ?>" value="kotu">
                                    <i class="fa-solid fa-face-sad-cry display-4" style="color: red;"></i>
                                </div>
                            </li>
                            <label class="form-label text-danger"><?= $SoruErr ?></label>
                        </ul>

                    <?php }

                    ?>
                    <button type="submit" class="btn btn-success mt-4 w-100" name="AnketiGonder">Anketi Gönder</button>
                    </form>

            </div>

        </div>
    </div>
</div>