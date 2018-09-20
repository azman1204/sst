<?php
use yii\helpers\Html;
use app\models\Rujukan;
?>

<legend>Keputusan ujian Saringan</legend>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="index.php?r=pendaftaran/form">Pendaftaran</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="#">Ujian Saringan</a>
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
    echo app\mylib\Util::alert($salah);
}
?>

<form method="post" action="index.php?r=ujian-saringan/save">
    <div class="row">
        <div class="col-sm-1">Menjalani Ujian</div>
        <div class="col-sm-4">
            <input type="radio" name="menjalani_ujian" value="Y" <?= $dat->menjalani_ujian === 'Y' ? 'checked' : '' ?>> YA
            <input type="radio" name="menjalani_ujian" value="T" <?= $dat->menjalani_ujian === 'T' ? 'checked' : '' ?>> TIDAK
        </div>
        <div class="col col-sm-1">Tarikh Ujian</div>
        <div class="col col-sm-4"><input type="date" name="tkh_ujian" value="<?= $dat->tkh_ujian ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">HB</div>
        <div class="col-sm-4"><input type="text" name="hb" value="<?= $dat->hb ?>" class="form-control"></div>
        <div class="col-sm-1">MCH</div>
        <div class="col-sm-4"><input type="text" name="mch" value="<?= $dat->mch ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">MCV</div>
        <div class="col-sm-4"><input type="text" name="mcv" value="<?= $dat->mcv ?>" class="form-control"></div>
        <div class="col-sm-1">MCHC</div>
        <div class="col-sm-4"><input type="text" name="mchc" value="<?= $dat->mchc ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">RDW</div>
        <div class="col-sm-4"><input type="text" name="rdw" value="<?= $dat->rdw ?>" class="form-control"></div>
        <div class="col-sm-1">RBC</div>
        <div class="col-sm-4"><input type="text" name="rbc" value="<?= $dat->rbc ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">Diagnosis Sementara</div>
        <div class="col-sm-4">
            <?= Html::dropDownList('id_diag_sementara', $dat->id_diag_sementara, Rujukan::dd('diag_temp'), ['class' => 'form-control']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-4"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>
    
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= $dat->id ?>"> <!-- PK -->
</form>

<style>
    .row {
        margin-top: 5px;
    }
</style>