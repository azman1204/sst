<legend>Pendaftaran Saringan</legend>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#">Pendaftaran</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?r=ujian-saringan/form">Ujian Saringan</a>
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
<form method="post" action="index.php?r=pendaftaran/save">
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    <input type="hidden" name="id" value="<?= $dat->id ?>"> <!-- PK -->
    Nama : <input type="text" name="nama" value="<?= $dat->nama ?>">
    <br>
    No KP : <input type="text" maxlength="12" name="nokp" value="<?= $dat->nokp ?>">
    <br>
    <input type="submit" value="Simpan">
</form>