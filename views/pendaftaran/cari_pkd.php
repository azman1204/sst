<?php
use yii\helpers\Html;
use app\models\Klinik;
$user = \Yii::$app->user->identity;
$rows = Klinik::find()->where(['id_pkd' => $user->id_pkd])->all();
$arr = ['0' => '--Sila Pilih--'] + \yii\helpers\ArrayHelper::map($rows, 'id', 'nama');
?>
<div class="row">
    <div class="col col-md-1">Klinik</div>
    <div class="col col-md-4"><?= Html::dropDownList('klinik', $klinik, $arr, ['class' =>'form-control']) ?></div>
    <div class="col col-md-1">Sekolah</div>
    <div class="col col-md-4" id="my-sekolah"></div>
</div>

<script>
    $(function () {
        getSekolah();
        $('[name=klinik]').change(getSekolah);
        
        function getSekolah() {
            var val = $('[name=klinik]').val();
            $('#my-sekolah').load('index.php?r=pendaftaran/sekolah&klinik=' + val + '&s=<?= $sek ?>');
        }
    });
</script>