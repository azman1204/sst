<?php

use yii\helpers\Html;
use app\models\Rujukan;

echo "<legend>Keputusan Ujian Saringan</legend>";
echo $this->render('/pendaftaran/menu', ['current' => 4]);
?>
<br>
<?php
if (isset($msg)) {
    echo $msg;
}
?>
<form method="post" action="index.php?r=diagnosa-akhir/save">
    <div class="row">
        <div class="col-sm-2">Diagnosa Akhir</div>
        <div class="col-sm-4"><input type="text" id="diag_akhir" value="<?= $diagnosa ?>" class="form-control" disabled=""></div>
    </div>
    <div class="row">
        <div class="col-sm-2">Catatan</div>
        <div class="col-sm-4"><textarea class="form-control" id='catatan' name="catatan"><?= $catatan ?></textarea></div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4"><input type="submit" id='submit' value="Simpan" class="btn btn-primary"></div>
    </div>
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
</form>
<style>
    .row {
        margin-top: 5px;
    }
</style>