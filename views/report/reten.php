<style>
#my-table {
    border: 1px solid #999;
    width:100%;
    font-size:11px;
}

#my-table td {
    border: 1px solid #ddd;
}

.my-tr {
    text-align:center;
    background-color: #eee;
    font-weight: 700;
    color: #000;
}

.r1 {
    background-color: white;
}

.r2 {
    background-color: #ffffcc;
}

.total {
    background-color: yellow;
    font-weight: bold;
}

.tiada-rekod {
    font-size: 14px;
    color:red;
}
</style>

<script>
$(function() {
    pks2();
    $('#pkd').change(function() {
        //alert('ok');
        pks();
    });

    function pks() {
        var pkd = $('#pkd').val();
        $('#pks-td').load('index.php?r=report/pks&pkd='+pkd, function() {
            pks2();
        });
    }

    function pks2() {
        $('#pks').change(function() {
            sekolah();
        });
    }

    function sekolah() {
        var pks = $('#pks').val();
        $('#sekolah-td').load('index.php?r=report/sekolah&pks='+pks);
    }
});
</script>

<legend>Laporan Reten</legend>

<form action='' method='post' style='background-color:#eee; padding:4px;border:1px solid #ddd;'>
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <div class="form-row">
        <div class="col col-md-1">
            Tahun
            <? //= \app\mylib\Util::year_list('tahun', $tahun) ?>
            <?= yii\helpers\Html::dropDownList('tahun',$tahun, app\models\Rujukan::dd('tahun'), ['class'=>'form-control']) ?>
        </div>
        <?php if ($usr_level == 'hq') : ?>
            <div class="col">
                Pejabat Kesihatan Daerah
                <?= \app\mylib\Util::pkd_list('pkd', $pkd) ?>
            </div>
        <?php endif; ?>
        <?php if ($usr_level == 'PKD' || $usr_level == 'HQ') : ?>
            <div class="col">
                Klinik
                <span id='pks-td'><?= $pks_list ?></span>
            </div>
        <?php endif; ?>
        <div class="col">
            Sekolah
            <span id='sekolah-td'><?= $sekolah_list ?></span>
        </div>
        <div class="col">
            <div>&nbsp</div>
            <input type="submit" name='cari' class="btn btn-primary" value="Jana Laporan" style='sisplay:block'>
        </div>
    </div>
</form>
<?php
if (! isset($_POST['cari'])) {
    return;
}
?>
<br>
<a href="index.php?r=report/cetak" target="_window" class="btn btn-primary btn-sm">Cetak</a>
<a href="index.php?r=report/excel" class="btn btn-primary btn-sm">Tukar ke Excel</a>
<a href="index.php?r=report/pdf" target="_window" class="btn btn-primary btn-sm">Tukar ke PDF</a>
<?php
echo $result;