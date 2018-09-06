<legend>Senarai Pendaftaran</legend>
<a href="index.php?r=pendaftaran/form" class="btn btn-success btn-sm">Tambah Rekod</a>
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
    <tr>
        <th>Bil</th>
        <th>Nama</th>
        <th>No KP</th>
        <th>Tindakan</th>
    </tr>
    </thead>
    <?php
    $bil = 1;
    foreach ($dat as $data) { 
    ?>
    <tr>
        <td><?= $bil++ ?></td>
        <td><?= $data->nama ?></td>
        <td><?= $data->nokp ?></td>
        <td>
            <a href="index.php?r=pendaftaran/edit&id=<?= $data->id ?>" class="btn btn-info">Edit</a>
            <a href="index.php?r=pendaftaran/delete&id=<?= $data->id ?>" class="btn btn-danger">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>


