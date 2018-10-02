<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?= active(1, $current) ?>" href="index.php?r=pendaftaran/form">Pendaftaran</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= active(2, $current) ?>" href="index.php?r=ujian-saringan/form">Ujian Saringan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= active(3, $current) ?>" href="index.php?r=ujian-pengesahan/form">Ujian Pengesahan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= active(4, $current) ?>" href="index.php?r=kaunseling/form">Kaunseling</a>
  </li>
</ul>

<?php
function active($tab, $current) {
    if ($tab == $current) {
        return 'active';
    } else {
        return '';
    }
}