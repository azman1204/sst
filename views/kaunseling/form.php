<?php
use yii\helpers\Html;
use app\models\Rujukan;
echo "<legend>Kaunseling</legend>";
echo $this->render('/pendaftaran/menu', ['current' => 4]);
if (isset($salah)) {
    echo app\mylib\Util::alert($salah);
}
?>

<form method="post" action="index.php?r=kaunseling/save">
    <div class="row">
        <div class="col-sm-2">Telah Kaunseling</div>
        <div class="col-sm-4">
            Ya <input type="radio" name="telah_kaunseling" <?= $dat->telah_kaunseling === 'Y' ? 'checked' : '' ?> value="Y">
            Tidak <input type="radio" name="telah_kaunseling" <?= $dat->telah_kaunseling === 'T' ? 'checked' : '' ?> value="T">
        </div>
        <div class="col col-sm-2">Tarikh Kaunseling</div>
        <div class="col col-sm-4"><input type="date" name="tkh_kaunseling" value="<?= $dat->tkh_kaunseling ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-2">Status Ujian Saringan</div>
        <div class="col-sm-4" id="status"></div>
        <div class="col-sm-1">Diagnosis Akhir</div>
        <div class="col-sm-4"></div>
    </div>
    <div class="row">
        <div class="col-sm-2">Sebab Cicir</div>
        <div class="col-sm-4">
        <?= Html::dropDownList('sebab_cicir', $dat->sebab_cicir, Rujukan::dd('sebab_cicir', 'Y'), ['class'=>'form-control']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">Catatan</div>
        <div class="col-sm-4"><textarea class="form-control" name="catatan"><?= $dat->catatan ?></textarea></div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>
    
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= $dat->id ?>"> <!-- PK -->
</form>

<script>
$(function() {
    kaunseling();
    $('[name=telah_kaunseling]').click(kaunseling);
    
    function kaunseling() {
        var val = $('[name=telah_kaunseling]:checked').val();
        var str = val === 'Y' ? 'SELESAI' : 'TIDAK SELESAI';
        $('#status').text(str);
        
        if (val === 'T') {
            $('[name=tkh_kaunseling]').attr('disabled', 'T');
        } else {
            $('[name=tkh_kaunseling]').removeAttr('disabled');
        }
    }
});
</script>

<style>
    .row {
        margin-top: 5px;
    }
</style>