<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php?r=home">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if(Yii::$app->user->identity->level == 'klinik') : ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?r=pendaftaran/form">Pendaftaran</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?r=pendaftaran/list">Carian</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?r=report/reten">Laporan</a>
            </li>
            <?php if(Yii::$app->user->identity->level == 'adm') : ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?r=user/list">Pengguna Sistem</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?r=account/index">Akaun</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
                <a class="nav-link" href="index.php?r=login/logout">Log Keluar (<?= Yii::$app->user->identity->name ?>)</a>
            </li>
        </ul>
    </div>
</nav>