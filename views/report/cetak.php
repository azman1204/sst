<!doctype html>
<html>
    <head>
        <title>Sistem Saringan Talasemia (SST)</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global.css" rel="stylesheet" type="text/css"/>
        <link href="font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <script src="jquery-3.2.1.min.js"></script>
    </head>
    <body>
    <div id='report-wrapper'>
    <center><b>RETEN SARINGAN THALASSAEMIA SEKOLAH</b></center>
    <br>
    <div class="row">
        <div class="col-md-8"><b>Pejabat Kesihatan / Klinik Kesihatan / Sekolah :</b> <?=$pkd->keterangan?> / <?=$klinik->nama?> /  <?=$sekolah->nama?></div>
        <div class="col-md-4"><b>Tahun :</b> <?=$tahun?></div>
    </div>
    <?=$result?>
    </div>
</body>
<style>
#report-wrapper {
    background-color:white;
    margin:20px;
    border: 2px solid #000;
}
    #my-table {

        width:100%;
        font-size:11px;

    }

    #my-table td {
        border: 1px solid #ddd;
    }

    .my-tr {
        text-align:center;
        background-color: #eee;
        font-weight: 700;
        color: #000;
    }

    .r1 {
        background-color: white;
    }

    .r2 {
        background-color: #ffffcc;
    }

    .total {
        background-color: yellow;
        font-weight: bold;
    }

    .tiada-rekod {
        font-size: 14px;
        color:red;
    }
</style>
</html>