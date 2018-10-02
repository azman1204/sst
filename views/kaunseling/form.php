<?php
use yii\helpers\Html;
use app\models\Rujukan;
echo "<legend>Kaunseling</legend>";
echo $this->render('/pendaftaran/menu', ['current' => 4]);
?>

<form method="post" action="index.php?r=kaunseling/save">
    <div class="row">
        <div class="col-sm-2">Telah Kaunseling</div>
        <div class="col-sm-4">
            Ya <input type="radio" name="telah_kaunseling">
            Tidak <input type="radio" name="telah_kaunseling">
        </div>
        <div class="col col-sm-2">Tarikh Kaunseling</div>
        <div class="col col-sm-4"><input type="date" name="tkh_kaunseling" value="" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-2">Status Ujian Saringan</div>
        <div class="col-sm-4"></div>
        <div class="col-sm-1">Diagnosis Akhir</div>
        <div class="col-sm-4"></div>
    </div>
    <div class="row">
        <div class="col-sm-2">Sebab Cicir</div>
        <div class="col-sm-4">
        <?= Html::dropDownList('sebab_cicir', '', Rujukan::dd('sebab_cicir'), ['class'=>'form-control']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">Catatan</div>
        <div class="col-sm-4"><textarea class="form-control" name="catatan"></textarea></div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>
    
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= '' ?>"> <!-- PK -->
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