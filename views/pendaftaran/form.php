<?php
use yii\helpers\Html;
use app\models\Rujukan;

echo "<legend>Pendaftaran Saringan</legend>";

if (isset($new)) {
    echo $this->render('/pendaftaran/menu2');
} else {
    echo $this->render('/pendaftaran/menu', ['current' => 1]);
}

if (isset($salah)) {
    echo app\mylib\Util::alert($salah);
}
?>
<form method="post" action="index.php?r=pendaftaran/save">
    <div class="row">
        <div class="col col-sm-2">Nama</div>
        <div class="col col-sm"><input type="text" name="nama" value="<?= $dat->nama ?>" class="form-control"></div>
        <div class="col col-sm-2">No KP</div>
        <div class="col col-sm"><input type="text" maxlength="12" name="nokp" id="nokp" value="<?= $dat->nokp ?>" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Kebenaran Bertulis</div>
        <div class="col col-sm">
            <input type="radio" name="kebenaran" value="Y" <?= $dat->kebenaran === 'Y' ? 'checked' : '' ?>> YA
            <input type="radio" name="kebenaran" value="T" <?= $dat->kebenaran === 'T' ? 'checked' : '' ?>> TIDAK
        </div>
        <div class="col col-sm-2">Alamat</div>
        <div class="col col-sm"><textarea class="form-control" name="alamat"><?= $dat->alamat ?></textarea></div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Tel</div>
        <div class="col col-sm"><input type="text" name="tel" value="<?= $dat->tel ?>" class="form-control"></div>
        <div class="col col-sm-2">Jantina</div>
        <div class="col col-sm">
            <input type="radio" name="jantina" value="L" <?= $dat->jantina === 'L' ? 'checked' : '' ?>> LELAKI
            <input type="radio" name="jantina" value="P" <?= $dat->jantina === 'P' ? 'checked' : '' ?>> PEREMPUAN
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Tarikh Lahir</div>
        <div class="col col-sm"><input type="date" name="tkh_lahir" id="tkh_lahir" value="<?= $dat->tkh_lahir ?>" class="form-control"></div>
        <div class="col col-sm-2">Umur</div>
        <div class="col col-sm">
            <input type="text" id="umur" value="<?= $dat->umur ?>" class="form-control" disabled>
            <input type="hidden" name="umur" id="umur2" value="<?= $dat->umur ?>">
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Klinik Kesihatan</div>
        <div class="col col-sm"><input type="text" value="<?= $klinik->nama ?>" class="form-control" disabled=""></div>
        <div class="col col-sm-2">Nama Sekolah</div>
        <div class="col col-sm">
        <?= Html::dropDownList('id_sekolah', $dat->id_sekolah, $sek, ['class' => 'form-control']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">Etnik</div>
        <div class="col col-sm">
        <?= Html::dropDownList('kump_etnik', $dat->kump_etnik, $kump_etnik, ['class' => 'form-control']) ?>
        </div>
        <div class="col col-sm-2">Pecahan Etnik</div>
        <div class="col col-sm" id="my-etnik"></div>
    </div>
    <div class="row">
        <div class="col col-sm-2"></div>
        <div class="col col-sm-10">
            <input type="checkbox" name="kes_indeks" <?= $dat->kes_indeks === 'Y' ? 'checked' : '' ?>>
            KES INDEKS (<span style="color:red">Hanya Untuk Keluarga murid yang disahkan pembawa</span>)
        </div>
    </div>
    <div class="row" id="kes_indeks">
        <div class="col col-sm-2">Nama</div>
        <div class="col col-sm-4"><input type="text" name="nama_indeks" value="<?= $dat->nama_indeks ?>" class="form-control"></div>
        <div class="col col-sm-2">No KP</div>
        <div class="col col-sm-4"><input type="text" name="nokp_indeks" value="<?= $dat->nokp_indeks ?>" class="form-control"></div>
    </div>
    <!--
    <div class="row" id="kes_indeks">
        <div class="col col-sm-2">Tahun Reten</div>
        <div class="col col-sm-4"><?= Html::dropDownList('tahun_reten', $dat->tahun_reten, Rujukan::dd('tahun'), ['class' => 'form-control']) ?></div>
    </div>
    -->
    <div class="row">
        <div class="col col-sm-2"></div>
        <div class="col col-sm"><input type="submit" value="Simpan" class="btn btn-primary"></div>
    </div>

    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= $dat->id ?>"> <!-- PK -->
</form>

<script>
    $(function () {
        kesIndeks();
        $('[name=kes_indeks').click(kesIndeks);
        function kesIndeks() {
            if($('[name=kes_indeks').is(':checked')) {
                $('#kes_indeks').show();
            } else {
                $('#kes_indeks').hide();
            }
        }

        $('#nokp').blur(function() {
            var nokp = $(this).val();
            var year = parseInt(nokp.substring(0,2)) + 2000;
            var month = nokp.substring(2,4);
            var day = nokp.substring(4,6);
            console.log("year = " + year + " month = " + month + " day = " + day);
            $('#tkh_lahir').val(year + '-' + month + '-' + day);
        });
        
        $('[name=kump_etnik]').change(function () {
            var val = $(this).val();
            $('#my-etnik').load('index.php?r=pendaftaran/pecahan&id=' + val + '&id_pecahan=<?= $dat->pecahan_etnik ?>');
        });

        $('[name=kump_etnik]').trigger('change'); // trigger change event auto
        $('[name=tkh_lahir]').blur(kiraUmur); // blur = event out focus

        function kiraUmur() {
            var tkh = $('[name=tkh_lahir]').val();
            var bod = new Date(tkh);
            var ageDifMs = Date.now() - bod.getTime();
            var ageDate = new Date(ageDifMs); // miliseconds from epoch
            var age =  Math.abs(ageDate.getUTCFullYear() - 1970);
            $('#umur').val(age);
            $('#umur2').val(age);
        }
    });
</script>

<style>
    .row {
        margin-top: 5px;
    }
</style>