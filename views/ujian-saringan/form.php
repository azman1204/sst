<?php
use yii\helpers\Html;
use app\models\Rujukan;
echo "<legend>Keputusan Ujian Saringan</legend>";
echo $this->render('/pendaftaran/menu', ['current' => 2]);
if (isset($salah)) {
    echo app\mylib\Util::alert($salah);
} else if(isset($msg)) {
    echo $msg;
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
        <div class="col-sm-4"><input type="text" name="hb" maxlength='5' value="<?= $dat->hb ?>" class="form-control"></div>
        <div class="col-sm-1">MCH</div>
        <div class="col-sm-4"><input type="text" name="mch" maxlength='5' value="<?= $dat->mch ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">MCV</div>
        <div class="col-sm-4"><input type="text" name="mcv" maxlength='5' value="<?= $dat->mcv ?>" class="form-control"></div>
        <div class="col-sm-1">MCHC</div>
        <div class="col-sm-4"><input type="text" name="mchc" maxlength='5' value="<?= $dat->mchc ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">RDW</div>
        <div class="col-sm-4"><input type="text" name="rdw" maxlength='5' value="<?= $dat->rdw ?>" class="form-control"></div>
        <div class="col-sm-1">RBC</div>
        <div class="col-sm-4"><input type="text" name="rbc" maxlength='5' value="<?= $dat->rbc ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">Diagnosis Sementara</div>
        <div class="col-sm-4">
            <?= Html::dropDownList('id_diag_sementara', $dat->id_diag_sementara, Rujukan::dd('diag_temp'), ['class' => 'form-control']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-1">Catatan</div>
        <div class="col-sm-9">
            <textarea class="form-control" name="catatan"><?= $dat->catatan ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-4"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= $dat->id ?>"> <!-- PK -->
</form>

<script>
// on load (semua element HTML dah load), execute following
$(function() {
    $('[name=menjalani_ujian]').click(enable); // create event
    $('[name=menjalani_ujian]:checked').trigger('click');
    
    function enable() {
        var pilihan = $('[name=menjalani_ujian]:checked').val();
        if (pilihan === 'T') {
            $('[type=text],select,[type=date]').attr('disabled', 'true');
        } else {
            $('[type=text],select,[type=date]').removeAttr('disabled');
        }
    }
});
</script>

<style>
    .row {
        margin-top: 5px;
    }
</style>