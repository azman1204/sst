<?php
namespace app\mylib;

class Util {
    static function alert($err, $type='danger', $col=4) {
        if (count($err) == 0) {
            return '';
        }
        
        $str = "<div class='alert alert-$type col-sm-$col'>";
        foreach ($err as $e) {
            $str .= "<li>" . $e[0] . '</li>';
        }
        $str .= "</div>";
        return $str;
    }

    static function month_list($name) {
        $str = "<select name='$name' class='form-control'>";
        $str .= "<option value='0'>--Sila Pilih--</option>";
        $arr = [
            'Jan' => '01', 
            'Feb' => '02', 
            'Mar' => '03', 
            'Apr' => '04', 
            'May' => '05', 
            'Jun' => '06', 
            'Jul' => '07', 
            'Aug' => '08', 
            'Sep' => '09', 
            'Oct' => '10', 
            'Nov' => '11', 
            'Dec' => '12'];
        foreach ($arr as $key => $val) {
            $str .= "<option value='$val'>$key</option>";
        }
        $str .= "</select>";
        return $str;
    }

    static function sekolah_list($name, $id_sekolah) {
        $str = "<select name='$name' class='form-control'>";
        $str .= "<option value='0'>--Sila Pilih--</option>";
        $arr = \app\models\Sekolah::find()->all();
        foreach ($arr as $sekolah) {
            $s = $sekolah->id == $id_sekolah ? 'selected' : '';
            $str .= "<option value='{$sekolah->id}' $s>{$sekolah->nama}</option>";
        }
        $str .= "</select>";
        return $str;
    }

    // list all sekolah dibawah sesuatu PKD
    static function sekolah_klinik($name, $klinik='', $id_sekolah='') {
        $where = [];
        if ($klinik !== '') {
            $where['s.id_klinik'] = $klinik;
        }

        $rows = (new \yii\db\Query())
        ->select('s.id, s.nama')
        ->from('sekolah s')
        ->where($where)
        ->all();

        $str = "<select name='$name' class='form-control'>";
        $str .= "<option value='0'>--Sila Pilih--</option>";
        foreach ($rows as $sekolah) {
            $s = $sekolah['id'] == $id_sekolah ? 'selected' : '';
            $str .= "<option value='{$sekolah['id']}' $s>{$sekolah['nama']}</option>";
        }
        $str .= "</select>";
        return $str;
    }

    // list all sekolah dibawah sesuatu PKD
    static function sekolah_pkd($name, $pkd='', $id_sekolah='') {
        $where = [];
        if ($pkd !== '') {
            $where['k.id_pkd'] = $pkd;
        }
        $rows = (new \yii\db\Query())
        ->select('s.id, s.nama')
        ->from('sekolah s, klinik k')
        ->where('s.id_klinik = k.id')
        ->andWhere($where)
        ->all();
        //var_dump($rows);exit;

        $str = "<select name='$name' class='form-control'>";
        $str .= "<option value='0'>--Sila Pilih--</option>";
        foreach ($rows as $sekolah) {
            $s = $sekolah['id'] == $id_sekolah ? 'selected' : '';
            $str .= "<option value='{$sekolah['id']}' $s>{$sekolah['nama']}</option>";
        }
        $str .= "</select>";
        return $str;
    }

    static function pkd_list($name, $pkd) {
        $str = "<select name='$name' class='form-control' id='$name'>";
        $str .= "<option value='0'>--Sila Pilih--</option>";
        $arr = \app\models\Rujukan::find()->where(['kat' => 'pkd'])->all();
        foreach ($arr as $ruj) {
            $s = $ruj['kod'] == $pkd ? 'selected' : '';
            $str .= "<option value='{$ruj->kod}' $s>{$ruj->keterangan}</option>";
        }
        $str .= "</select>";
        return $str;
    }

    static function year_list($name, $year) {
        $str = "<select name='$name' class='form-control' id='$name'>";
        $arr = ['2018'=>2018, '2019'=>2019];
        foreach ($arr as $key => $val) {
            $s = $val == $year ? 'selected' : '';
            $str .= "<option value='$val' $s>$key</option>";
        }
        $str .= "</select>";
        return $str;
    }

    static function pks_list($name='', $pkd='', $pks='') {
        echo $pks;
        $str = "<select name='$name' class='form-control' id='$name'>";
        $str .= "<option value='0'>--Sila Pilih--</option>";
        $arr = \app\models\Klinik::find()->where(['id_pkd' => $pkd])->all();
        foreach ($arr as $klinik) {
            $s = $klinik->id == $pks ? 'selected' : '';
            $str .= "<option value='{$klinik->id}' $s>{$klinik->nama}</option>";
        }
        $str .= "</select>";
        return $str;
    }
}