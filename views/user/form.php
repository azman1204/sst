<legend>Maklumat Pengguna</legend>
<?php
if (isset($err)) {
    echo app\mylib\Util::alert($err);
}
?>
<form method="post" action="index.php?r=user/save">
    <input type="hidden" name="id" value="<?= $user->id ?>" class="form-control">
    <div class="row">
        <div class="col-sm-2">Nama</div>
        <div class="col-sm-4"><input type="text" name="name" value="<?= $user->name ?>" class="form-control"></div>
        <div class="col-sm-2">ID Pengguna</div>
        <div class="col-sm-4"><input type="text" name="user_id" value="<?= $user->user_id ?>" class="form-control"></div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-2">Katalaluan</div>
        <div class="col-sm-4"><input type="password" name="pwd" value="<?= $user->pwd ?>" class="form-control"></div>
        <div class="col-sm-2">Jawatan</div>
        <div class="col-sm-4"><input type="text" name="post" value="<?= $user->post ?>" class="form-control"></div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-2">Level Pengguna</div>
        <div class="col-sm-4">
            <select name="level" id="level" class="form-control">
                <option value="ADM" <?= $user->level == 'ADM' ? 'selected' : '' ?>>Sistem Admin</option>
                <option value="HQ" <?= $user->level == 'HQ' ? 'selected' : '' ?>>HQ</option>
                <option value="PKD" <?= $user->level == 'PKD' ? 'selected' : '' ?>>PKD</option>
                <option value="KLINIK" <?= $user->level == 'KLINIK' ? 'selected' : '' ?>>Klinik</option>
            </select>
        </div>
        <div class="col-sm-2 my-klinik">Klinik/PKD</div>
        <div class="col-sm-4 my-klinik" id="my-div"><input type="text" name="rbc" value="<?= '' ?>" class="form-control"></div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-2"></div>
        <div class="col-sm-4"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
</form>

<script>
    $(function () {
        getKlinik();
        
        $('#level').change(function () {
            getKlinik();
        });

        function getKlinik() {
            var level = $("#level").val();
            if (level === 'KLINIK' || level === 'PKD') {
                $('.my-klinik').show();
                if (level === 'KLINIK') {
                    $('#my-div').load('index.php?r=user/klinik&level='+level);
                } else {
                    $('#my-div').load('index.php?r=user/pkd&level='+level);
                }
            } else {
                $('.my-klinik').hide();
            }
        }
    });


</script>

<style>
    .my-klinik {
        display: none;
    }
</style>