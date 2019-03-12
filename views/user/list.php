<legend>Senarai Pengguna Sistem</legend>

<a href="index.php?r=user/new" class="btn btn-primary btn-sm">Tambah</a>
<table class="table table-bordered table-striped table-hover mt-1">
    <thead>
    <tr class="thead-dark">
        <th>Bil</th>
        <th>Nama</th>
        <th>Level</th>
        <th>Klinik</th>
        <th>PKD</th>
        <th>Jawatan</th>
        <th width="10%">Tindakan</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $bil = 1;
    foreach ($users as $user) {
        $klinik = \app\models\Klinik::find()->where(['id'=>$user->id_klinik])->one();
        $ruj = app\models\Rujukan::find()->where(['kod' => $user->id_pkd, 'kat' => 'pkd'])->one();
    ?>
    <tr>
        <td><?= $bil++ ?>.</td>
        <td><?= $user->name ?></td>
        <td><span class="badge badge-info"><?= $user->level ?></span></td>
        <td><?= $klinik ? $klinik->nama : '' ?></td>
        <td><?= $ruj ? $ruj->keterangan : '' ?></td>
        <td><?= $user->post ?></td>
        <td align='center'>
            <a href="index.php?r=user/edit&id=<?= $user->id ?>"><span class="fa fa-pencil"></span></a>
            <a href="index.php?r=user/del&id=<?= $user->id ?>" onclick="return confirm('Anda Pasti ?')"><span class="fa fa-trash-o" style="color: red"></span></a>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>