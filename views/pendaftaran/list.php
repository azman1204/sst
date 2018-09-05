<legend>Senarai Pendaftaran</legend>

<table class="table table-bordered table-striped">
    <tr>
        <td>Bil</td>
        <td>Nama</td>
        <td>No KP</td>
    </tr>
    <?php
    $bil = 1;
    foreach ($dat as $data) {
    ?>
    <tr>
        <td><?= $bil++ ?></td>
        <td><?= $data->nama ?></td>
        <td><?= $data->nokp ?></td>
    </tr>
    <?php } ?>
</table>


