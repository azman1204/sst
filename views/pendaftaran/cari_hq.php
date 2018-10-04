<?php
use yii\helpers\Html;
use app\models\Rujukan;
?>
<div class="row">
    <div class="col col-md-1">Pejabat Kesihatan Daerah</div>
    <div class="col col-md-4"><?= Html::dropDownList('pkd', '', Rujukan::dd('pkd', 'Y'), ['class' => 'form-control']) ?></div>
    <div class="col col-md-1">Klinik</div>
    <div class="col col-md-4" id="my-klinik"></div>
</div>
<div class="row">
    <div class="col col-md-1">Sekolah</div>
    <div class="col col-md-4" id="my-sekolah"></div>
</div>

<script>
    $(function () {
        getKlinik();
        $('[name=pkd]').change(getKlinik);
        function getKlinik() {
            var val = $('[name=pkd]').val();
            $('#my-klinik').load('index.php?r=pendaftaran/klinik&pkd=' + val, function () {
                $('[name=klinik').change(getSekolah);
            });
        }
        
        function getSekolah() {
            var val = $('[name=klinik]').val();
            $('#my-sekolah').load('index.php?r=pendaftaran/sekolah&klinik=' + val);
        }
    });
</script>