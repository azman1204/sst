<legend>Senarai Pengguna Sistem</legend>

<a href="index.php?r=user/new" class="btn btn-primary btn-sm">Tambah</a>
<table class="table table-bordered table-striped">
    <tr class="success">
        <td>Bil</td>
        <td>Nama</td>
        <td>Level</td>
        <td>Klinik</td>
        <td>PKD</td>
        <td>Jawatan</td>
        <td>Tindakan</td>
    </tr>
    <?php
    $bil = 1;
    foreach ($users as $user) {
        $klinik = \app\models\Klinik::find()->where(['id'=>$user->id_klinik])->one();
    ?>
    <tr>
        <td><?= $bil++ ?>.</td>
        <td><?= $user->name ?></td>
        <td><?= $user->level ?></td>
        <td><?= $klinik ? $klinik->nama : '' ?></td>
        <td><?= $user->id_pkd ?></td>
        <td><?= $user->post ?></td>
        <td>
            <a href="index.php?r=user/edit&id=<?= $user->id ?>"><span class="fa fa-pencil"></span></a>
            <a href="index.php?r=user/del&id=<?= $user->id ?>"><span class="fa fa-trash"></span></a>
        </td>
    </tr>
    <?php } ?>
</table>