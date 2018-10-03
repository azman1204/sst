<?php
// import models
use app\models\Klinik;
use app\models\KumpEtnik;
use app\models\PecahanEtnik;
use app\models\Sekolah;
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
    </tr>
    </thead>
    <?php
    $bil = 1;
    foreach ($dat as $data) {
        $klinik = Klinik::findOne($data->id_klinik);
        $ke = KumpEtnik::findOne($data->kump_etnik);
        $sekolah = Sekolah::findOne($data->id_sekolah);
        $pe = PecahanEtnik::findOne($data->pecahan_etnik);
    ?>
    <tr>
        <td><?= $bil++ ?></td>
        <td>
            <a href="index.php?r=pendaftaran/edit&id=<?= $data->id ?>" class="btn btn-info">Edit</a>
            <a href="index.php?r=pendaftaran/delete&id=<?= $data->id ?>" class="btn btn-danger">Hapus</a>
        </td>
        <td><?= $data->nama ?></td>
        <td><?= $data->nokp ?></td>
        <td><?= $data->kebenaran ?></td>
        <td><?= $data->alamat ?></td>
        <td><?= $data->tel ?></td>
        <td><?= $data->jantina ?></td>
        <td><?= $data->tkh_lahir ?></td>
        <td><?= $data->umur ?></td>
        <td><?= $sekolah->nama ?></td>
        <td><?= $klinik->nama ?></td>
        <td><?= $ke->nama ?></td>
        <td><?= $pe->nama_pecahan ?></td>
    </tr>
    <?php } ?>
</table>
</div>

<style>
    #mylist {
        overflow: auto;
    }
</style>

