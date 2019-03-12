<legend>Tukar Katalaluan</legend>
<?php
if (isset($err)) {
    echo app\mylib\Util::alert($err);
} else if(isset($msg)) {
    echo app\mylib\Util::alert($msg, 'success');
}
?>
<form method="post" action="index.php?r=user/password">
    <input type="hidden" name="id" value="<?= '' ?>" class="form-control">
    <div class="row">
        <div class="col-sm-2">Katalaluan Lama</div>
        <div class="col-sm-4"><input type="password" name="pwd_old" value="<?= '' ?>" class="form-control"></div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-2">Katalaluan Baru</div>
        <div class="col-sm-4"><input type="password" name="pwd_new" value="<?= '' ?>" class="form-control"></div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-2">Pengesahan Katalaluan</div>
        <div class="col-sm-4"><input type="password" name="pwd_confirm" value="<?= '' ?>" class="form-control"></div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-2"></div>
        <div class="col-sm-4"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
</form>