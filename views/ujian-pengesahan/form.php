<?php
use yii\helpers\Html;
use app\models\KodUjian;
echo "<legend>Keputusan Ujian Pengesahan</legend>";
echo $this->render('/pendaftaran/menu');

if (isset($salah)) {
    echo app\mylib\Util::alert($salah);
}
?>

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
        <div class="col-sm-4">
        <?= Html::dropDownList('kod_hbkeputusan', $dat->kod_hbkeputusan, KodUjian::dd('HB'), ['class' => 'form-control']) ?>
        </div>
        <div class="col-sm-1">Kategori Keputusan</div>
        <div class="col-sm-4"><input id="kat_keputusan" type="text" value="" class="form-control" disabled=""></div>
    </div>
    <div class="row">
        <div class="col-sm-1">Perlu Diagnosa Molekular</div>
        <div class="col-sm-4"><input type="text" id="diag_molekular" value="<?= $dat->diag_molekular ?>" class="form-control" disabled=""></div>
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
        <div class="col-sm-4">
        <?= Html::dropDownList('kod_hbkeputusan', $dat->kod_hbkeputusan, KodUjian::dd('DNA'), ['class' => 'form-control']) ?>
        </div>
        <div class="col-sm-1">Diagnosa Akhir</div>
        <div class="col-sm-4"><input type="text" name="diag_molekular" value="" class="form-control" disabled=""></div>
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
    $('[name=kod_hbkeputusan]').change(doit);
    
    function doit() {
        var id2 = $('[name=kod_hbkeputusan]').val();
        $.getJSON('index.php?r=ujian-pengesahan/kodujian', {id:id2}, function(data) {
            //console.log(data);
            $('#kat_keputusan').val(data.kat_keputusan);
            $('#diag_molekular').val(data.perlu_diag);
        });
    }
});
</script>

<style>
    .row {
        margin-top: 5px;
    }
</style>