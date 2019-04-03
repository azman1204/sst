<table id='my-table' class="mt-1" border="1">
    <tr class='my-tr'>
        <td rowspan='4'>Klinik Kesihatan <br> / Daerah<br>  / Negeri <br></td>
        <td rowspan='4'>Kumpulan Etnik</td>
        <td rowspan='4'>Jantina</td>
        <td rowspan='2' colspan='2'>Enrolment</td>
        <td colspan='4'>Kebenaran Bertulis</td>
        <td colspan='14'>Bilangan Murid Dengan Kebenaran Bertulis</td>
    </tr>
    <tr class='my-tr'>
        <td colspan='2'>Ada</td>
        <td colspan='2'>Tiada</td>
        <td colspan='2'>Tidak Menjalani Saringan</td>
        <td colspan='12'>Menjalani Saringan</td>
    </tr>

    <tr class='my-tr'>
        <td rowspan='2'>Bilangan</td>
        <td rowspan='2'>%</td>
        <td rowspan='2'>Bilangan</td>
        <td rowspan='2'>%</td>
        <td rowspan='2'>Bilangan</td>
        <td rowspan='2'>%</td>
        <td rowspan='2'>Bilangan</td>
        <td rowspan='2'>%</td>
        <td colspan='2'>TRO IDA</td>
        <td colspan='2'>TRO Pembawa Thalassaemia</td>
        <td colspan='2'>Normal</td>
        <td colspan='2'>Lain-Lain</td>
        <td colspan='2'>Confirm IDA</td>
        <td colspan='2'></td>
    </tr>
    <tr class='my-tr'>
        <td>Bilangan</td>
        <td>%</td>
        <td>Bilangan</td>
        <td>%</td>
        <td>Bilangan</td>
        <td>%</td>
        <td>Bilangan</td>
        <td>%</td>
        <td>Bilangan</td>
        <td>%</td>
        <td>Jumlah Disaring</td>
        <td>% Murid Disaring</td>
    </tr>
    <?php
    function enrolment($rows, $etnik, $jantina) {
        foreach ($rows as $arr) {
            if ($arr['kump_etnik'] == $etnik && $arr['jantina'] == $jantina) {
                return $arr['cnt'];
            }
        }
        return 0;
    }

    function tot_enrolment($rows) {
        $tot = 0;
        foreach ($rows as $arr) {
            $tot += $arr['cnt'];
        }
        return $tot;
    }

    function kebenaran($rows, $etnik, $kebenaran, $jantina) {
        foreach ($rows as $arr) {
            if ($arr['kump_etnik'] == $etnik && $arr['kebenaran'] == $kebenaran && $arr['jantina'] == $jantina) {
                return $arr['cnt'];
            }
        }
        return 0;
    }

    function tot_kebenaran($rows, $kebenaran) {
        $tot = 0;
        foreach ($rows as $arr) {
            if ($arr['kebenaran'] == $kebenaran) {
               $tot += $arr['cnt'];
            }
        }
        return $tot;
    }

    function ujian($rows, $etnik, $jantina) {
        foreach ($rows as $arr) {
            if ($arr['kump_etnik'] == $etnik  && $arr['jantina'] == $jantina) {
                return $arr['cnt'];
            }
        }
        return 0;
    }

    function diag($rows, $etnik, $jantina, $diag) {
        foreach ($rows as $arr) {
            if ($arr['kump_etnik'] == $etnik  && $arr['jantina'] == $jantina && $arr['id_diag_sementara'] == $diag) {
                return $arr['cnt'];
            }
        }
        return 0;
    }

    $where = [];
    if ($user->level === 'PKD') {
        $id_pkd = $user->id_pkd;
        $where['k.id_pkd'] = $id_pkd;
    }

    if($sekolah !== '0') {
        $where['id_sekolah'] = $sekolah;
    }

    if($tahun !== '') {
        $where['tahun_reten'] = $tahun;
    }

    if($pks !== null && $pks !== '0') {
        $where['id_klinik'] = $pks;
    }
    
    if($pkd !== null && $pkd !== '0') {
        $where['k.id_pkd'] = $pkd;
    }
    
    $query = new \yii\db\Query();
    $rows_enrolment = $query
    ->select(['kump_etnik', 'jantina', 'id_klinik', 'COUNT(*) AS cnt'])
    ->from('pendaftaran p')
    ->join('LEFT JOIN', 'klinik k', 'p.id_klinik = k.id')
    ->where($where)
    ->groupBy(['kump_etnik', 'jantina', 'id_klinik'])
    ->all();
    $command = $query->createCommand();
    //echo $command->sql;

    $tot_enrolment = tot_enrolment($rows_enrolment);
    if ($tot_enrolment == 0) {
        // tiada pendaftaran
        echo "<tr><td colspan='23' align='center' class='tiada-rekod'>--Tiada Rekod--</td></tr></table>";
        return;
    }

    $rows_kebenaran = (new \yii\db\Query())
    ->select(['kump_etnik', 'jantina', 'kebenaran', 'id_klinik', 'COUNT(*) AS cnt'])
    ->from('pendaftaran p')
    ->join('LEFT JOIN', 'klinik k', 'p.id_klinik = k.id')
    ->where($where)
    ->groupBy(['kump_etnik', 'jantina', 'kebenaran', 'id_klinik'])
    ->all();

    $rows_ujian = (new \yii\db\Query())
    ->select(['p.kump_etnik', 'p.jantina', 'id_klinik', 'COUNT(*) AS cnt'])
    ->from(['pendaftaran p', 'klinik k', 'ujian_saringan u'])
    ->where("p.id_klinik = k.id AND p.id = u.id_pendaftaran AND u.menjalani_ujian = 'T'")
    ->andWhere($where)
    ->groupBy(['p.kump_etnik', 'p.jantina', 'id_klinik'])
    ->all();

    $rows_diag = (new \yii\db\Query())
    ->select(['p.kump_etnik', 'p.jantina', 'u.id_diag_sementara', 'COUNT(*) AS cnt'])
    ->from(['pendaftaran p', 'ujian_saringan u', 'klinik k'])
    ->where("p.id = u.id_pendaftaran AND p.id_klinik = k.id")
    ->andWhere($where)
    ->groupBy(['p.kump_etnik', 'p.jantina', 'u.id_diag_sementara'])
    ->all();
    //var_dump($rows_diag);

    $i = 0;
    $arr = ['Melayu' => 1,'Cina' => 2,'India' => 3,'Orang Asli' => 4,'Bumiputera Sabah' => 5];
    //$arr = [];
    $tot_enrolment = tot_enrolment($rows_enrolment);
    $tot_kebenaran_Y = tot_kebenaran($rows_kebenaran, 'Y');
    $tot_kebenaran_pct_Y = 0;
    $tot_kebenaran_T = tot_kebenaran($rows_kebenaran, 'T');
    $tot_kebenaran_pct_T = 0;
    $tot_ujian = 0;
    $tot_ujian_pct = 0;
    $tot_tro = 0;
    $tot_tro_pct = 0;
    $tot_tro_bawa = 0;
    $tot_tro_bawa_pct = 0;
    $tot_normal = 0;
    $tot_normal_pct = 0;
    $tot_lain = 0;
    $tot_lain_pct = 0;
    $tot_confirm = 0;
    $tot_confirm_pct = 0;
    $tot_saring = 0;
    $tot_saring_pct = 0;

    foreach ($arr as $nama_etnik => $kod_etnik) {
        //$bg = $i++ % 2 == 0 ? 'r1' : 'r2';
        // ENROLMENT
        $enrolment_L = enrolment($rows_enrolment, $kod_etnik, 'L');
        $enrolment_P = enrolment($rows_enrolment, $kod_etnik, 'P');
        $enrolment_pct_L = number_format(($enrolment_L / $tot_enrolment) * 100, 0);
        $enrolment_pct_P = number_format(($enrolment_P / $tot_enrolment) * 100, 0);
        $enrolment_pct = $enrolment_pct_L + $enrolment_pct_P;
        //$tot_enrolment += $enrolment_L + $enrolment_P;

        // KEBENARAN BERTULIS - ADA
        $kebenaran_YL = kebenaran($rows_kebenaran, $kod_etnik, 'Y', 'L');
        $kebenaran_YP = kebenaran($rows_kebenaran, $kod_etnik, 'Y', 'P');
        $kebenaran_pct_YL = number_format(($kebenaran_YL / $tot_enrolment) * 100, 0);
        $kebenaran_pct_YP = number_format(($kebenaran_YP / $tot_enrolment) * 100, 0);
        //$tot_kebenaran_Y  += $kebenaran_YL + $kebenaran_YP;
        $tot_kebenaran_pct_Y += $kebenaran_pct_YL + $kebenaran_pct_YP;

        // KEBENARAN BERTULIS - TIADA
        $kebenaran_TL = kebenaran($rows_kebenaran, $kod_etnik, 'T', 'L');
        $kebenaran_TP = kebenaran($rows_kebenaran, $kod_etnik, 'T', 'P');
        $kebenaran_pct_TL = number_format(($kebenaran_TL / $tot_enrolment) * 100, 0);
        $kebenaran_pct_TP = number_format(($kebenaran_TP / $tot_enrolment) * 100, 0);
        //$tot_kebenaran_T  += $kebenaran_TL + $kebenaran_TP;
        $tot_kebenaran_pct_T += $kebenaran_pct_TL + $kebenaran_pct_TP;

        // TIDAK MENJALANI SARINGAN
        $ujian_L = ujian($rows_ujian, $kod_etnik, 'L');
        $ujian_P = ujian($rows_ujian, $kod_etnik, 'P');
        $ujian_pct_L = number_format($ujian_L / $tot_kebenaran_Y * 100, 0);
        $ujian_pct_P = number_format($ujian_P / $tot_kebenaran_Y * 100, 0);
        $tot_ujian += $ujian_L + $ujian_P;
        $tot_ujian_pct += $ujian_pct_L + $ujian_pct_P;

        //TRO IDA
        $tro_L = diag($rows_diag, $kod_etnik, 'L', '2');
        $tro_P = diag($rows_diag, $kod_etnik, 'P', '2');
        $tro_pct_L = number_format($tro_L / $tot_kebenaran_Y * 100, 0);
        $tro_pct_P = number_format($tro_P / $tot_kebenaran_Y * 100, 0);
        $tot_tro += $tro_L + $tro_P;
        $tot_tro_pct += $tro_pct_L + $tro_pct_P;

        //TRO PEMBAWA TALASEMIA
        $tro_bawa_L = diag($rows_diag, $kod_etnik, 'L', '3');
        $tro_bawa_P = diag($rows_diag, $kod_etnik, 'P', '3');
        $tro_bawa_pct_L = number_format($tro_bawa_L / $tot_kebenaran_Y * 100, 0);
        $tro_bawa_pct_P = number_format($tro_bawa_P / $tot_kebenaran_Y * 100, 0);
        $tot_tro_bawa += $tro_bawa_L + $tro_bawa_P;
        $tot_tro_bawa_pct += $tro_bawa_pct_L + $tro_bawa_pct_P;

        //NORMAL
        $normal_L = diag($rows_diag, $kod_etnik, 'L', '1');
        $normal_P = diag($rows_diag, $kod_etnik, 'P', '1');
        $normal_pct_L = number_format($normal_L / $tot_kebenaran_Y * 100, 0);
        $normal_pct_P = number_format($normal_P / $tot_kebenaran_Y * 100, 0);
        $tot_normal += $normal_L + $normal_P;
        $tot_normal_pct += $normal_pct_L + $normal_pct_P;

        //LAIN-LAIN
        $lain_L = diag($rows_diag, $kod_etnik, 'L', '4');
        $lain_P = diag($rows_diag, $kod_etnik, 'P', '4');
        $lain_pct_L = number_format($lain_L / $tot_kebenaran_Y * 100, 0);
        $lain_pct_P = number_format($lain_P / $tot_kebenaran_Y * 100, 0);
        $tot_lain += $lain_L + $lain_P;
        $tot_lain_pct += $lain_pct_L + $lain_pct_P;

        //confirm IDA
        $confirm_L = diag($rows_diag, $kod_etnik, 'L', '5');
        $confirm_P = diag($rows_diag, $kod_etnik, 'P', '5');
        $confirm_pct_L = number_format($confirm_L / $tot_kebenaran_Y * 100, 0);
        $confirm_pct_P = number_format($confirm_P / $tot_kebenaran_Y * 100, 0);
        $tot_confirm += $confirm_L + $confirm_P;
        $tot_confirm_pct += $confirm_pct_L + $confirm_pct_P;

        // saring
        $tot_saring_L = $tro_L + $tro_bawa_L + $normal_L + $lain_L + $confirm_L;
        $tot_saring_P = $tro_P + $tro_bawa_P + $normal_P + $lain_P + $confirm_P;
        $tot_saring_pct_L = number_format($tot_saring_L / $tot_kebenaran_Y * 100, 0);
        $tot_saring_pct_P = number_format($tot_saring_P / $tot_kebenaran_Y * 100, 0);
        $tot_saring += $tot_saring_L + $tot_saring_P;
        $tot_saring_pct += $tot_saring_pct_L + $tot_saring_pct_P;
    ?>
    <!-- <tr>
        <td rowspan='15'>xx</td>
        <td colspan='22'>yy</td>
    </tr> -->
    <!-- LELAKI -->
    <tr>
        <td rowspan='3'></td>
        <td rowspan='3'><?= $nama_etnik ?></td>
        <td>Lelaki</td>
        <td align='center'><?= $enrolment_L ?></td>
        <td align='center'><?= $enrolment_pct_L ?></td>
        <td align='center'><?= $kebenaran_YL ?></td>
        <td align='center'><?= $kebenaran_pct_YL ?></td>
        <td align='center'><?= $kebenaran_TL ?></td>
        <td align='center'><?= $kebenaran_pct_TL ?></td>
        <td align='center'><?= $ujian_L ?></td>
        <td align='center'><?= $ujian_pct_L ?></td>
        <td align='center'><?= $tro_L ?></td>
        <td align='center'><?= $tro_pct_L ?></td>
        <td align='center'><?= $tro_bawa_L ?></td>
        <td align='center'><?= $tro_bawa_pct_L ?></td>
        <td align='center'><?= $normal_L ?></td>
        <td align='center'><?= $normal_pct_L ?></td>
        <td align='center'><?= $lain_L ?></td>
        <td align='center'><?= $lain_pct_L ?></td>
        <td align='center'><?= $confirm_L ?></td>
        <td align='center'><?= $confirm_pct_L ?></td>
        <td align='center'><?= $tot_saring_L ?></td>
        <td align='center'><?= $tot_saring_pct_L ?></td>
    </tr>
    <!-- PEREMPUAN -->
    <tr>
        <td>Perempuan</td>
        <td align='center'><?= $enrolment_P ?></td>
        <td align='center'><?= $enrolment_pct_P ?></td>
        <td align='center'><?= $kebenaran_YP ?></td>
        <td align='center'><?= $kebenaran_pct_YP ?></td>
        <td align='center'><?= $kebenaran_TP ?></td>
        <td align='center'><?= $kebenaran_pct_TP ?></td>
        <td align='center'><?= $ujian_P ?></td>
        <td align='center'><?= $ujian_pct_P ?></td>
        <td align='center'><?= $tro_P ?></td>
        <td align='center'><?= $tro_pct_P ?></td>
        <td align='center'><?= $tro_bawa_P ?></td>
        <td align='center'><?= $tro_bawa_pct_P ?></td>
        <td align='center'><?= $normal_P ?></td>
        <td align='center'><?= $normal_pct_P ?></td>
        <td align='center'><?= $lain_P ?></td>
        <td align='center'><?= $lain_pct_P ?></td>
        <td align='center'><?= $confirm_P ?></td>
        <td align='center'><?= $confirm_pct_P ?></td>
        <td align='center'><?= $tot_saring_P ?></td>
        <td align='center'><?= $tot_saring_pct_P ?></td>
    </tr>
    <!-- JUMLAH -->
    <tr class='r2'>
        <td>Jumlah</td>
        <td align='center'><b><?= $enrolment_L + $enrolment_P ?></b></td>
        <td align='center'><?= $enrolment_pct ?></td>
        <td align='center'><b><?= $kebenaran_YL + $kebenaran_YP ?></b></td>
        <td align='center'><?= $kebenaran_pct_YL + $kebenaran_pct_YP ?></td>
        <td align='center'><b><?= $kebenaran_TL + $kebenaran_TP ?></b></td>
        <td align='center'><b><?= $kebenaran_pct_TL + $kebenaran_pct_TP ?></b></td>
        <td align='center'><b><?= $ujian_L + $ujian_P ?></b></td>
        <td align='center'><?= $ujian_pct_L + $ujian_pct_P ?></td>
        <td align='center'><b><?= $tro_L + $tro_P ?></b></td>
        <td align='center'><b><?= $tro_pct_L + $tro_pct_P ?></b></td>
        <td align='center'><b><?= $tro_bawa_L + $tro_bawa_P ?></b></td>
        <td align='center'><b><?= $tro_bawa_pct_L + $tro_bawa_pct_P ?></b></td>
        <td align='center'><b><?= $normal_L + $normal_P ?></b></td>
        <td align='center'><?= $normal_pct_L + $normal_pct_P ?></td>
        <td align='center'><b><?= $lain_L + $lain_P ?></b></td>
        <td align='center'><b><?= $lain_pct_L + $lain_pct_P ?></td>
        <td align='center'><b><?= $confirm_L + $confirm_P ?></b></td>
        <td align='center'><b><?= $confirm_pct_L + $confirm_pct_P ?></td>
        <td align='center'><b><?= $tot_saring_L + $tot_saring_P ?></b></td>
        <td align='center'><?= $tot_saring_pct_L + $tot_saring_pct_P ?></td>
    </tr>
    <?php } // end if  ?>
    <!-- TOTAL -->
    <tr class='total'>
        <td colspan='3' align='right'>JUMLAH</td>
        <td align='center'><?= $tot_enrolment ?></td>
        <td align='center'>100%</td>
        <td align='center'><?= $tot_kebenaran_Y ?></td>
        <td align='center'><?= $tot_kebenaran_pct_Y ?>%</td>
        <td align='center'><?= $tot_kebenaran_T ?></td>
        <td align='center'><?= $tot_kebenaran_pct_T ?>%</td>
        <td align='center'><?= $tot_ujian ?></td>
        <td align='center'><?= $tot_ujian_pct ?>%</td>
        <td align='center'><?= $tot_tro ?></td>
        <td align='center'><?= $tot_tro_pct ?>%</td>
        <td align='center'><?= $tot_tro_bawa ?></td>
        <td align='center'><?= $tot_tro_bawa_pct ?>%</td>
        <td align='center'><?= $tot_normal ?></td>
        <td align='center'><?= $tot_normal_pct ?>%</td>
        <td align='center'><?= $tot_lain ?></td>
        <td align='center'><?= $tot_lain_pct ?>%</td>
        <td align='center'><?= $tot_confirm ?></td>
        <td align='center'><?= $tot_confirm_pct ?>%</td>
        <td align='center'><?= $tot_saring ?></td>
        <td align='center'><?= $tot_saring_pct ?>%</td>
    </tr>
</table>