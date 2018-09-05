<table>
    <tr>
        <td>Bil</td>
        <td>Nama</td>
        <td>Tindakan</td>
    </tr>
    <?php
    foreach ($dat as $u) {
        // $u = mewakili satu rekod dlm table user
        // name nama col dlm table tersebut
    ?>
    <tr>
        <td></td>
        <td><?= $u->name ?></td>
        <td></td>
    </tr>
    <?php } ?>
</table>


