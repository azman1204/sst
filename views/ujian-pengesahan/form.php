<?php
use yii\helpers\Html;
use app\models\Rujukan;
$this->render('/pendaftaran/menu');

if (isset($salah)) {
    echo app\mylib\Util::alert($salah);
}
?>

<legend>Keputusan Ujian Pengesahan</legend>
<form method="post" action="index.php?r=ujian-saringan/save">
    <b>Hb ANALYSIS</b>
    <div class="row">
        <div class="col-sm-1">Tarikh hantar</div>
        <div class="col-sm-4"><input type="date" name="tkh_hbhantar" value="<?= $dat->tkh_hbhantar ?>" class="form-control"></div>
        <div class="col col-sm-1">Tarikh Keputusan</div>
        <div class="col col-sm-4"><input type="date" name="tkh_hbkeputusann" value="<?= $dat->tkh_hbkeputusan ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">Kod Keputusan</div>
        <div class="col-sm-4"><input type="text" name="kod_hbkeputusan" value="<?= $dat->kod_hbkeputusan ?>" class="form-control"></div>
        <div class="col-sm-1">Kategori Keputusan</div>
        <div class="col-sm-4"><input type="text" value="" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">Perlu Diagnosa Molekular</div>
        <div class="col-sm-4"><input type="text" name="diag_molekular" value="<?= $dat->diag_molekular ?>" class="form-control"></div>
    </div>
    
    <b>DNA ANALYSIS</b>
    <div class="row">
        <div class="col-sm-1">Tarikh hantar</div>
        <div class="col-sm-4"><input type="date" name="tkh_dnahantar" value="<?= $dat->tkh_dnahantar ?>" class="form-control"></div>
        <div class="col col-sm-1">Tarikh Keputusan</div>
        <div class="col col-sm-4"><input type="date" name="tkh_dnakeputusan" value="<?= $dat->tkh_dnakeputusan ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">Kod Keputusan</div>
        <div class="col-sm-4"><input type="text" name="kod_dnakeputusan" value="<?= $dat->kod_dnakeputusan ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-4"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>
    
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= $dat->id ?>"> <!-- PK -->
</form>

<script>
$(function() {
    
});
</script>

<style>
    .row {
        margin-top: 5px;
    }
</style>