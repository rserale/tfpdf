<?php
/**
 * generate_unicode_font_specs.php
 *
 * @author David Wilcock <dwilcock@doc-net.com>
 * @copyright Venditan Limited 2016
 */

require_once __DIR__ . '/../vendor/autoload.php';

$str_search = __DIR__ . "/../src/font/unifont/*.ttf";

$arr_fonts = glob($str_search);

$obj_pdf = new \tFPDF\PDF();
$int_generated = 0;
foreach ($arr_fonts as $str_font_filename) {
    $str_font_filename = basename($str_font_filename);
    preg_match("/^(.*)\.ttf$/", $str_font_filename, $arr_matches);
    if (count($arr_matches) > 1) {
        //$str_font_family = str_replace("-", "", $arr_matches[1]);
        $str_font_family = reset(explode("-", $arr_matches[1]));
        $str_style = "";
        if (strpos($arr_matches[1], "Bold") !== FALSE) {
            $str_style .= "B";
        }
        if (strpos($arr_matches[1], "Italic") !== FALSE || strpos($arr_matches[1], "Oblique") !== FALSE) {
            $str_style .= "I";
        }
        $str_font_ttf = $arr_matches[0];
        $obj_pdf->AddFont($str_font_family, $str_style, $str_font_filename, true);
        echo "Generated files for " . $str_font_family;
        if ($str_style != '') {
            echo "/" . $str_style;
        }
        echo "\n";
        $int_generated++;
    }
}
echo "Generated " . $int_generated . " font spec files\n";