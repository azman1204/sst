<?php
use yii\helpers\Html;
?>

<legend>Pendaftaran Saringan</legend>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="#">Pendaftaran</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?r=ujian-saringan/form">Ujian Saringan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Ujian Pengesahan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Diagnosis Akhir</a>
    </li>
</ul>

<?php
if (isset($salah)) {
    foreach ($salah as $e) {
        echo $e[0] . '<br>';
    }
}
?>
<form method="post" action="index.php?r=pendaftaran/save">
    <div class="row">
        <div class="col col-sm-2">Nama</div>
        <div class="col col-sm"><input type="text" name="nama" value="<?= $dat->nama ?>" class="form-control"></div>
        <div class="col col-sm-2">No KP</div>
        <div class="col col-sm"><input type="text" maxlength="12" name="nokp" value="<?= $dat->nokp ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Kebenaran Bertulis</div>
        <div class="col col-sm">
            <input type="radio" name="kebenaran" value="Y" checked> YA
            <input type="radio" name="kebenaran" value="T"> TIDAK
        </div>
        <div class="col col-sm-2">Alamat</div>
        <div class="col col-sm"><textarea class="form-control" name="alamat"></textarea></div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Tel</div>
        <div class="col col-sm"><input type="text" name="nama" value="<?= $dat->nama ?>" class="form-control"></div>
        <div class="col col-sm-2">Jantina</div>
        <div class="col col-sm">
            <input type="radio" name="jantina" value="L"> LELAKI
            <input type="radio" name="jantina" value="P"> PEREMPUAN
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Tarikh Lahir</div>
        <div class="col col-sm"><input type="date" name="nama" value="<?= $dat->nama ?>" class="form-control"></div>
        <div class="col col-sm-2">Umur</div>
        <div class="col col-sm"><input type="text" maxlength="12" name="nokp" value="<?= $dat->nokp ?>" class="form-control" disabled></div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Klinik Kesihatan</div>
        <div class="col col-sm"><input type="text" name="nama" value="<?= $dat->nama ?>" class="form-control"></div>
        <div class="col col-sm-2">Nama Sekolah</div>
        <div class="col col-sm">
            <?= Html::dropDownList('id_sekolah', '', $sek) ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Etnik</div>
        <div class="col col-sm"><input type="text" name="nama" value="<?= $dat->nama ?>" class="form-control"></div>
        <div class="col col-sm-2">Pecahan Etnik</div>
        <div class="col col-sm"><input type="text" maxlength="12" name="nokp" value="<?= $dat->nokp ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col col-sm-2"></div>
        <div class="col col-sm"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>

    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= $dat->id ?>"> <!-- PK -->
</form>

<style>
    .row {
        margin-top: 5px;
    }
</style>