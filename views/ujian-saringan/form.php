<legend>Keputusan ujian Saringan</legend>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="index.php?r=pendaftaran/form">Pendaftaran</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="#">Ujian Saringan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Ujian Pengesahan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Diagnosis Akhir</a>
  </li>
</ul>

<?php
if (isset($salah)) {
    foreach ($salah as $e) {
        echo $e[0] . '<br>';
    }
}
?>

<form method="post" action="index.php?r=ujian-saringan/save">
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= $dat->id ?>"> <!-- PK -->
    HB : <input type="text" name="hb" value="<?= $dat->hb ?>">
    <br>
    MCH : <input type="text" name="mch" value="<?= $dat->mch ?>">
    <br>
    <input type="submit" value="Simpan">
</form>