<?php
$id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
$diag = app\models\UjianSaringan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
if (! $diag) {
    $diag = new app\models\UjianSaringan();
}
if ($diag->id_diag_sementara == 2 || $diag->id_diag_sementara == 3) {
    $str = "";
} else {
    // selain dari TRO THALASEMIA dan TRO IDA
    $str = "disabled";
}

if ($diag) {
    $str2 = "";
} else {
    $str2 = "disabled";
}
?>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?= active(1, $current) ?>" href="index.php?r=pendaftaran/edit2">Pendaftaran</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= active(2, $current) ?>" href="index.php?r=ujian-saringan/form">Ujian Saringan</a>
  </li>
  <li class="nav-item">
    <a class="<?= $str ?> nav-link <?= active(3, $current) ?>" href="index.php?r=ujian-pengesahan/form">Ujian Pengesahan</a>
  </li>
    <li class="nav-item">
    <a class="<?= $str2 ?> nav-link <?= active(4, $current) ?>" href="index.php?r=diagnosa-akhir/form">Diagnosa Akhir</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= active(5, $current) ?>" href="index.php?r=kaunseling/form">Kaunseling</a>
  </li>
</ul>

<style>
a.disabled {
    color: gray;
    pointer-events: none;
}
</style>

<?php
function active($tab, $current) {
    if ($tab == $current) {
        return 'active';
    } else {
        return '';
    }
}