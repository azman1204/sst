<?php
// import models
use app\models\Klinik;
use app\models\KumpEtnik;
use app\models\PecahanEtnik;
use app\models\Sekolah;
use app\models\UjianSaringan;
use app\models\Rujukan;
use app\models\UjianPengesahan;
use app\models\KodUjian;
?>
<legend>Senarai Pendaftaran</legend>
<a href="index.php?r=pendaftaran/form" class="btn btn-success btn-sm">Tambah Rekod</a>
<div id="mylist">
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
    <tr>
        <th>Bil</th>
        <th>Tindakan</th>
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
    </tr>
    </thead>
    <?php
    $bil = 1;
    foreach ($dat as $data) {
        $klinik = Klinik::findOne($data->id_klinik);
        $ke = KumpEtnik::findOne($data->kump_etnik);
        $sekolah = Sekolah::findOne($data->id_sekolah);
        $pe = PecahanEtnik::findOne($data->pecahan_etnik);
        $saringan = UjianSaringan::find()->where(['id_pendaftaran' => $data->id])->one();
        if (! $saringan) {
            // maklumat ujian saringan belum disimpan
            $saringan = new UjianSaringan();
        }
        $rujukan = Rujukan::find()
                ->where(['kat' => 'diag_temp', 'kod' => $saringan->id_diag_sementara])
                ->one();
        if (! $rujukan) {
            $rujukan = new Rujukan();
        }
        
        $pengesahan = UjianPengesahan::find()->where(['id_pendaftaran' => $data->id])->one();
        if (! $pengesahan) {
            $pengesahan = new UjianPengesahan();
        }
        
        $hb = KodUjian::findOne($pengesahan->kod_hbkeputusan);
        if (! $hb) {
            $hb = new KodUjian();
        }
        
        $dna = KodUjian::findOne($pengesahan->kod_dnakeputusan);
        if (! $dna) {
            $dna = new KodUjian();
        }
        
        if ($hb->ada_diag === 'T') {
            $diag_akhir = ''; // tiada diagnoasa
        } else if ($hb->diag_akhir !== 'ref') {
            $diag_akhir = $hb->diag_akhir; // hb shj cukup
        } else if ($hb->diag_akhir === 'ref') {
            $diag_akhir = $dna->diag_akhir; // perlu dna
        }
    ?>
    <tr>
        <td><?= $bil++ ?></td>
        <td>
            <a href="index.php?r=pendaftaran/edit&id=<?= $data->id ?>" class="btn btn-info">Edit</a>
            <a href="index.php?r=pendaftaran/delete&id=<?= $data->id ?>" class="btn btn-danger">Hapus</a>
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
        <td><?= $saringan->tkh_ujian ?></td>
        <td><?= $saringan->hb ?></td>
        <td><?= $saringan->mch ?></td>
        <td><?= $saringan->mcv ?></td>
        <td><?= $saringan->mchc ?></td>
        <td><?= $saringan->rdw ?></td>
        <td><?= $saringan->rbc ?></td>
        <td><?= $rujukan->keterangan ?></td>
        <td><?= $pengesahan->tkh_hbhantar ?></td>
        <td><?= $pengesahan->tkh_hbkeputusan?></td>
        <td><?= $hb->kod_ujian ?></td>
        <td><?= $hb->kat_keputusan ?></td>
        <td><?= $hb->perlu_diag ?></td>
        <td><?= $pengesahan->tkh_dnahantar ?></td>
        <td><?= $pengesahan->tkh_dnakeputusan ?></td>
        <td><?= $dna->kod_ujian ?></td>
        <td><?= $diag_akhir ?></td>
    </tr>
    <?php } ?>
</table>
</div>

<style>
    #mylist {
        overflow: auto;
    }
</style>

