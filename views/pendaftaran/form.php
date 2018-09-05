<legend>Pendaftaran Saringan</legend>

<form method="post" action="index.php?r=pendaftaran/save">
    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
    Nama : <input type="text" name="nama">
    <br>
    No KP : <input type="text" name="nokp">
    <br>
    <input type="submit" value="Simpan">
</form>