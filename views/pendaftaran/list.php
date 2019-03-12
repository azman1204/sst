<?php
use yii\widgets\LinkPager;
// import models
use app\models\Klinik;
use app\models\KumpEtnik;
use app\models\PecahanEtnik;
use app\models\Sekolah;
use app\models\UjianSaringan;
use app\models\Rujukan;
use app\models\UjianPengesahan;
use app\models\KodUjian;
use app\models\Kaunseling;
use yii\helpers\Html;
$user = \Yii::$app->user->identity;
?>
<legend>Senarai Pendaftaran</legend>

<form method="post" action="index.php?r=pendaftaran/list">
<input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
<?php if (! isset($_GET['list'])) : ?>
<div class="card">
    <div class="card-header">Carian</div>
    <div class="card-body">
        <div class="row">
            <div class="col col-md-2">No KP</div>
            <div class="col col-md-4"><input value="<?= $nokp ?>" type="text" name="nokp" class="form-control"></div>
            <div class="col col-md-2">Nama</div>
            <div class="col col-md-4"><input value="<?= $nama ?>" type="text" name="nama" class="form-control"></div>
        </div>
        <?php
        if ($user->level === 'hq') {
            echo $this->render('cari_hq', ['pkd' =>$pkd, 'klinik'=>$klinik, 'sek'=>$sek]);
        } else if ($user->level === 'pkd') {
            echo $this->render('cari_pkd',['klinik'=>$klinik, 'sek'=>$sek]);
        } else {
            echo $this->render('cari_klinik', ['sek2' =>$sek]);
        }
        ?>
        <div class="row">
            <div class="col col-md-2">Tarikh Dari</div>
            <div class="col col-md-4"><input value="<?= $tkh_dari ?>" type="date" name="tkh_dari" class="form-control"></div>
            <div class="col col-md-2">Tarikh Hingga</div>
            <div class="col col-md-4"><input value="<?= $tkh_hingga ?>" type="date" name="tkh_hingga" class="form-control"></div>
        </div>
        <div class="row">
            <div class="col col-md-2">Status Ujian Saringan</div>
            <div class="col col-md-4">
                <select class="form-control">
                    <option value="1">SELESAI</option>
                    <option value="2">TIDAK SELESAI</option>
                </select>
            </div>
            <div class="col-md-2">Diagnosis Sementara</div>
            <div class="col-md-4">
                <?= Html::dropDownList('id_diag_sementara', '', Rujukan::dd('diag_temp'), ['class' => 'form-control']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-2"></div>
            <div class="col col-md-4"><input type="submit" value="Cari" class="btn btn-primary"></div>
        </div>
    </div>
</div>
<?php endif; ?>
</form>
<br>
<?php if ($user-> level === 'klinik') { ?>
<a href="index.php?r=pendaftaran/form" class="btn btn-success btn-sm">Tambah Rekod</a>
<br><br>
<?php } ?>

<div id="mylist">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr style="color:white; font-weight: bold;">
                <td colspan="16" style="background-color:#00b3ee">Pendaftaran</td>
                <td colspan="8" style="background-color:green">Ujian Saringan</td>
                <td colspan="8" style="background-color:red">Ujian Pengesahan</td>
                <td colspan="8" style="background-color:gray"></td>
            </tr>
            <tr>
                <th colspan="16"></th>
                <th colspan="7">FBC</th>
                <th colspan="16"></th>
            </tr>
            <tr>
                <th colspan="14"></th>
                <th colspan="2">Kes Indeks</th>
                <th></th>
                <th colspan="6">Keputusan</th>
                <th></th>
                <th colspan="3">Hb Analisis</th>
                <th colspan="2"></th>
                <th colspan="3">DNA Analisis</th>
                <th></th>
                <th colspan="2">Kaunseling Selepas Ujian</th>
                <th colspan="4"></th>
            </tr>
            <tr>
                <th>Bil</th>
                <?php if ($user-> level === 'klinik') { ?><th>Tindakan</th><?php } ?>
                <th>Nama</th>
                <th>No KP</th>
                <th>Kebenaran Bertulis</th>
                <th>Alamat</th>
                <th>Tel</th>
                <th>Jantina</th>
                <th>Tarikh Lahir</th>
                <th>Umur</th>
                <th>Nama Sekolah</th>
                <th>Klinik Kesihatan</th>
                <th>Kumpulan Etnik</th>
                <th>Pecahan Etnik</th>
                <th>Nama</th>
                <th>No KP</th>
                <th>Tarikh Ujian</th>
                <th>HB</th>
                <th>MCH</th>
                <th>MCB</th>
                <th>MCHC</th>
                <th>RDW</th>
                <th>RDC</th>
                <th>Diagnosis Sementara</th>
                <th>Tarikh Hantar</th>
                <th>Tarikh Keputusan Diperolehi</th>
                <th>Kod Keputusan Ujian</th>
                <th>Kategori Keputusan</th>
                <th>Perlu Diagnosa Molekular</th>
                <th>Tarikh Hantar</th>
                <th>Tarikh Keputusan Diperolehi</th>
                <th>Kod Ujian</th>
                <th>Diagnosa Akhir</th>
                <th>Telah Beri Kaunseling</th>
                <th>Tarikh Kaunseling</th>
                <th>Status ujian Saringan</th>
                <th>Catatan</th>
                <th>Sebab Cicir</th>
                <th>Diagnosis Akhir</th>
            </tr>
        </thead>
        <?php
        $bil = isset($_GET['page']) ? $_GET['page'] : 1;
        $bil = ($bil - 1) * 5 + 1;
        foreach ($dat as $data) {
            $klinik = Klinik::findOne($data->id_klinik);
            $ke = KumpEtnik::findOne($data->kump_etnik);
            $sekolah = Sekolah::findOne($data->id_sekolah);
            $pe = PecahanEtnik::findOne($data->pecahan_etnik);
            $saringan = UjianSaringan::find()->where(['id_pendaftaran' => $data->id])->one();
            if (!$saringan) {
                // maklumat ujian saringan belum disimpan
                $saringan = new UjianSaringan();
            }
            $rujukan = Rujukan::find()
                    ->where(['kat' => 'diag_temp', 'kod' => $saringan->id_diag_sementara])
                    ->one();
            if (!$rujukan) {
                $rujukan = new Rujukan();
            }

            $pengesahan = UjianPengesahan::find()->where(['id_pendaftaran' => $data->id])->one();
            if (!$pengesahan) {
                $pengesahan = new UjianPengesahan();
            }

            $hb = KodUjian::findOne($pengesahan->kod_hbkeputusan);
            if (!$hb) {
                $hb = new KodUjian();
            }

            $dna = KodUjian::findOne($pengesahan->kod_dnakeputusan);
            if (!$dna) {
                $dna = new KodUjian();
            }

            if ($hb->ada_diag === 'T') {
                $diag_akhir = ''; // tiada diagnoasa
            } else if ($hb->diag_akhir !== 'ref') {
                $diag_akhir = $hb->diag_akhir; // hb shj cukup
            } else if ($hb->diag_akhir === 'ref') {
                $diag_akhir = $dna->diag_akhir; // perlu dna
            }

            $kaunseling = Kaunseling::find()->where(['id_pendaftaran' => $data->id])->one();
            if (!$kaunseling) {
                $kaunseling = new Kaunseling();
            }
            ?>
            <tr>
                <td><?= $bil++ ?></td>
                <td>
                    <a href="index.php?r=pendaftaran/edit&id=<?= $data->id ?>" class="fa fa-pencil"></a>
                    <?php if ($user-> level === 'klinik') { ?>
                    <a href="index.php?r=pendaftaran/delete&id=<?= $data->id ?>" class="fa fa-trash"></a>
                    <?php } ?>
                </td>
                <td><?= $data->nama ?></td>
                <td><?= $data->nokp ?></td>
                <td><?= $data->kebenaran === 'Y' ? 'YA' : 'TIDAK' ?></td>
                <td><?= $data->alamat ?></td>
                <td><?= $data->tel ?></td>
                <td><?= $data->jantina === 'L' ? 'Lelaki' : 'Perempuan' ?></td>
                <td><?= $data->tkh_lahir ?></td>
                <td><?= $data->umur ?></td>
                <td><?= $sekolah->nama ?></td>
                <td><?= $klinik->nama ?></td>
                <td><?= $ke->nama ?></td>
                <td><?= $pe->nama_pecahan ?></td>
                <td><?= $data->nama_indeks ?></td>
                <td><?= $data->nokp_indeks ?></td>
                <td><?= $saringan->tkh_ujian ?></td>
                <td><?= $saringan->hb ?></td>
                <td><?= $saringan->mch ?></td>
                <td><?= $saringan->mcv ?></td>
                <td><?= $saringan->mchc ?></td>
                <td><?= $saringan->rdw ?></td>
                <td><?= $saringan->rbc ?></td>
                <td><?= $rujukan->keterangan ?></td>
                <td><?= $pengesahan->tkh_hbhantar ?></td>
                <td><?= $pengesahan->tkh_hbkeputusan ?></td>
                <td><?= $hb->kod_ujian ?></td>
                <td><?= $hb->kat_keputusan ?></td>
                <td><?= $hb->perlu_diag === 'Y' ? 'YA' : 'TIDAK' ?></td>
                <td><?= $pengesahan->tkh_dnahantar ?></td>
                <td><?= $pengesahan->tkh_dnakeputusan ?></td>
                <td><?= $dna->kod_ujian ?></td>
                <td><?= $diag_akhir ?></td>
                <td><?= $kaunseling->telah_kaunseling === 'Y' ? 'YA' : 'TIDAK' ?></td>
                <td><?= $kaunseling->tkh_kaunseling ?></td>
                <td><?= $kaunseling->telah_kaunseling === 'Y' ? 'SELESAI' : 'TIDAK SELESAI' ?></td>
                <td><?= $kaunseling->catatan ?></td>
                <td><?= Rujukan::getKeterangan('sebab_cicir', $kaunseling->sebab_cicir) ?></td>
                <td><?= Rujukan::getKeterangan('diagnosa', $kaunseling->diagnosis_akhir) ?></td>
            </tr>
<?php } ?>
    </table>
</div>

<?php
echo LinkPager::widget([
    'pagination' => $pagination,
]);
?>
<style>
    #mylist {
        overflow: auto;
    }

    .row {
        margin-top: 5px;
    }
    
    .pagination li {
        border: 1px solid #ddd;
        padding: 10px;
    }
    
    .pagination li.active{
        background-color: #336699;
        color:white;
    }
    
    li.active a{
        color:white;
    }
    
</style>