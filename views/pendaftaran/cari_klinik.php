<?php
use yii\helpers\Html;
use app\models\Sekolah;
$user = \Yii::$app->user->identity;
$rows = Sekolah::find()->where(['id_klinik' =>$user->id_klinik])->all();
$sek = \yii\helpers\ArrayHelper::map($rows, 'id', 'nama');
?>
<div class="row">
    <div class="col col-md-1">Sekolah</div>
    <div class="col col-md-4">
        <?= Html::dropDownList('klinik', '', $sek, ['class'=>'form-control']) ?>
    </div>
</div>