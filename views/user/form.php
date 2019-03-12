<legend>Maklumat Pengguna</legend>

<form method="post" action="index.php?r=user/save">
    <input type="hidden" name="id" value="<?= $user->id ?>" class="form-control">
    <div class="row">
        <div class="col-sm-1">Nama</div>
        <div class="col-sm-4"><input type="text" name="name" value="<?= $user->name ?>" class="form-control"></div>
        <div class="col-sm-1">ID Pengguna</div>
        <div class="col-sm-4"><input type="text" name="user_id" value="<?= $user->user_id ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">Katalaluan</div>
        <div class="col-sm-4"><input type="password" name="pwd" value="<?= $user->pwd ?>" class="form-control"></div>
        <div class="col-sm-1">Jawatan</div>
        <div class="col-sm-4"><input type="text" name="post" value="<?= $user->post ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1">Level Pengguna</div>
        <div class="col-sm-4">
            <select name="level" id="level" class="form-control">
                <option value="ADM" <?= $user->level == 'ADM' ? 'selected' : '' ?>>Sistem Admin</option>
                <option value="HQ" <?= $user->level == 'HQ' ? 'selected' : '' ?>>HQ</option>
                <option value="PKD" <?= $user->level == 'PKD' ? 'selected' : '' ?>>PKD</option>
                <option value="klinik" <?= $user->level == 'klinik' ? 'selected' : '' ?>>Klinik</option>
            </select>
        </div>
        <div class="col-sm-1 my-klinik">Klinik/PKD</div>
        <div class="col-sm-4 my-klinik" id="my-div"><input type="text" name="rbc" value="<?= '' ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-sm-1"></div>
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
            if (level === 'klinik' || level === 'PKD') {
                $('.my-klinik').show();
                if (level === 'klinik') {
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