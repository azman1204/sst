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
}