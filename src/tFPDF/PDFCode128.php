<?php
/**
 * PDFCode128.php
 *
 * @author David Wilcock <dwilcock@doc-net.com>
 * @copyright Venditan Limited 2016
 */

namespace tFPDF;


class PDFCode128 extends PDF
{

    /**
     * Code128 table
     *
     * @var array
     */
    protected $arr_code_table = [];

    /**
     * Set of characters eligible for Code128
     *
     * @var string
     */
    protected $str_abc_set = "";

    /**
     * @var string
     */
    protected $str_a_set = "";

    /**
     * @var string
     */
    protected $str_b_set = "";

    /**
     * @var string
     */
    protected $str_c_set = "";

    /**
     * @var array
     */
    protected $arr_set_from = [];

    /**
     * @var array
     */
    protected $arr_set_to = [];

    /**
     * @var array
     */
    protected $arr_j_start = array("A" => 103, "B" => 104, "C" => 105);

    /**
     * @var array
     */
    protected $arr_j_swap = array("A" => 101, "B" => 100, "C" => 99);

    /**
     * PDFCode128 constructor.
     *
     * @param string $str_orientation
     * @param string $str_units
     * @param string $str_size
     */
    public function __construct($str_orientation = 'P', $str_units = 'mm', $str_size = 'A4')
    {
        parent::__construct($str_orientation, $str_units, $str_size);
        $this->Init();
    }

    /**
     * Initialisation
     */
    private function Init()
    {
        $this->arr_code_table[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]
        $this->arr_code_table[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
        $this->arr_code_table[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
        $this->arr_code_table[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
        $this->arr_code_table[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
        $this->arr_code_table[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
        $this->arr_code_table[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
        $this->arr_code_table[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
        $this->arr_code_table[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
        $this->arr_code_table[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
        $this->arr_code_table[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
        $this->arr_code_table[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
        $this->arr_code_table[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
        $this->arr_code_table[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
        $this->arr_code_table[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
        $this->arr_code_table[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
        $this->arr_code_table[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
        $this->arr_code_table[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
        $this->arr_code_table[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
        $this->arr_code_table[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
        $this->arr_code_table[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
        $this->arr_code_table[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
        $this->arr_code_table[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
        $this->arr_code_table[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
        $this->arr_code_table[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
        $this->arr_code_table[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
        $this->arr_code_table[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
        $this->arr_code_table[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
        $this->arr_code_table[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
        $this->arr_code_table[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
        $this->arr_code_table[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
        $this->arr_code_table[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
        $this->arr_code_table[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
        $this->arr_code_table[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
        $this->arr_code_table[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
        $this->arr_code_table[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
        $this->arr_code_table[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
        $this->arr_code_table[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
        $this->arr_code_table[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
        $this->arr_code_table[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
        $this->arr_code_table[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
        $this->arr_code_table[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
        $this->arr_code_table[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
        $this->arr_code_table[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
        $this->arr_code_table[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
        $this->arr_code_table[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
        $this->arr_code_table[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
        $this->arr_code_table[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
        $this->arr_code_table[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
        $this->arr_code_table[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
        $this->arr_code_table[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
        $this->arr_code_table[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
        $this->arr_code_table[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
        $this->arr_code_table[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
        $this->arr_code_table[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
        $this->arr_code_table[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
        $this->arr_code_table[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
        $this->arr_code_table[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
        $this->arr_code_table[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
        $this->arr_code_table[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
        $this->arr_code_table[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
        $this->arr_code_table[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
        $this->arr_code_table[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
        $this->arr_code_table[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
        $this->arr_code_table[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
        $this->arr_code_table[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
        $this->arr_code_table[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
        $this->arr_code_table[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
        $this->arr_code_table[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
        $this->arr_code_table[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
        $this->arr_code_table[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
        $this->arr_code_table[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
        $this->arr_code_table[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
        $this->arr_code_table[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
        $this->arr_code_table[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
        $this->arr_code_table[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
        $this->arr_code_table[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
        $this->arr_code_table[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
        $this->arr_code_table[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
        $this->arr_code_table[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
        $this->arr_code_table[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
        $this->arr_code_table[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
        $this->arr_code_table[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
        $this->arr_code_table[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
        $this->arr_code_table[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
        $this->arr_code_table[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
        $this->arr_code_table[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
        $this->arr_code_table[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
        $this->arr_code_table[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
        $this->arr_code_table[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
        $this->arr_code_table[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
        $this->arr_code_table[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
        $this->arr_code_table[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
        $this->arr_code_table[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
        $this->arr_code_table[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
        $this->arr_code_table[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
        $this->arr_code_table[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
        $this->arr_code_table[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
        $this->arr_code_table[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
        $this->arr_code_table[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
        $this->arr_code_table[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]
        $this->arr_code_table[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
        $this->arr_code_table[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
        $this->arr_code_table[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
        $this->arr_code_table[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
        $this->arr_code_table[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
        $this->arr_code_table[] = array(2, 3, 3, 1, 1, 1);           //106 : [STOP]
        $this->arr_code_table[] = array(2, 1);                       //107 : [END BAR]

        for ($i = 32; $i <= 95; $i++) {
            $this->str_abc_set .= chr($i);
        }
        $this->str_a_set = $this->str_abc_set;
        $this->str_b_set = $this->str_abc_set;

        for ($i = 0; $i <= 31; $i++) {
            $this->str_abc_set .= chr($i);
            $this->str_a_set .= chr($i);
        }
        for ($i = 96; $i <= 127; $i++) {
            $this->str_abc_set .= chr($i);
            $this->str_b_set .= chr($i);
        }
        for ($i = 200; $i <= 210; $i++) {
            $this->str_abc_set .= chr($i);
            $this->str_a_set .= chr($i);
            $this->str_b_set .= chr($i);
        }
        $this->str_c_set = "0123456789" . chr(206);

        $this->arr_set_from ["A"] = "";
        $this->arr_set_from ["B"] = "";
        $this->arr_set_to ["A"] = "";
        $this->arr_set_to ["B"] = "";

        for ($i = 0; $i < 96; $i++) {
            $this->arr_set_from["A"] .= chr($i);
            $this->arr_set_from["B"] .= chr($i + 32);
            $this->arr_set_to["A"] .= chr(($i < 32) ? $i + 64 : $i - 32);
            $this->arr_set_to["B"] .= chr($i);
        }
        for ($i = 96; $i < 107; $i++) {
            $this->arr_set_from["A"] .= chr($i + 104);
            $this->arr_set_from["B"] .= chr($i + 104);
            $this->arr_set_to["A"] .= chr($i);
            $this->arr_set_to["B"] .= chr($i);
        }
    }

    /**
     * @param $flt_pos_x
     * @param $flt_pos_y
     * @param $str_code
     * @param $flt_width
     * @param $flt_height
     */
    function Code128($flt_pos_x, $flt_pos_y, $str_code, $flt_width, $flt_height)
    {

        $Aguid = "";
        $Bguid = "";
        $Cguid = "";
        for ($i = 0; $i < strlen($str_code); $i++) {
            $needle = substr($str_code, $i, 1);
            $Aguid .= ((strpos($this->str_a_set, $needle) === false) ? "N" : "O");
            $Bguid .= ((strpos($this->str_b_set, $needle) === false) ? "N" : "O");
            $Cguid .= ((strpos($this->str_c_set, $needle) === false) ? "N" : "O");
        }

        $SminiC = "OOOO";
        $IminiC = 4;

        $crypt = "";
        while ($str_code > "") {

            $i = strpos($Cguid, $SminiC);
            if ($i !== false) {
                $Aguid [$i] = "N";
                $Bguid [$i] = "N";
            }

            if (substr($Cguid, 0, $IminiC) == $SminiC) {
                $crypt .= chr(($crypt > "") ? $this->arr_j_swap["C"] : $this->arr_j_start["C"]);
                $made = strpos($Cguid, "N");
                if ($made === false) {
                    $made = strlen($Cguid);
                }
                if (fmod($made, 2) == 1) {
                    $made--;
                }
                for ($i = 0; $i < $made; $i += 2) {
                    $crypt .= chr(strval(substr($str_code, $i, 2)));
                }
                //$jeu = "C";
            } else {
                $madeA = strpos($Aguid, "N");
                if ($madeA === false) {
                    $madeA = strlen($Aguid);
                }
                $madeB = strpos($Bguid, "N");
                if ($madeB === false) {
                    $madeB = strlen($Bguid);
                }
                $made = (($madeA < $madeB) ? $madeB : $madeA);
                $jeu = (($madeA < $madeB) ? "B" : "A");

                $crypt .= chr(($crypt > "") ? $this->arr_j_swap[$jeu] : $this->arr_j_start[$jeu]);

                $crypt .= strtr(substr($str_code, 0, $made), $this->arr_set_from[$jeu],
                    $this->arr_set_to[$jeu]);

            }
            $str_code = substr($str_code, $made);
            $Aguid = substr($Aguid, $made);
            $Bguid = substr($Bguid, $made);
            $Cguid = substr($Cguid, $made);
        }

        // Calculating the checksum
        $check = ord($crypt[0]);
        for ($i = 0; $i < strlen($crypt); $i++) {
            $check += (ord($crypt[$i]) * $i);
        }
        $check %= 103;

        // Completing the crypt chain
        $crypt .= chr($check) . chr(106) . chr(107);

        // Calculating the width of the module
        $i = (strlen($crypt) * 11) - 8;
        $modul = round($flt_width / $i, 2);

        // The output loop
        for ($i = 0; $i < strlen($crypt); $i++) {
            $c = $this->arr_code_table[ord($crypt[$i])];
            for ($j = 0; $j < count($c); $j++) {
                $this->Rect($flt_pos_x, $flt_pos_y, $c[$j] * $modul, $flt_height, "F");
                $flt_pos_x += ($c[$j++] + $c[$j]) * $modul;
            }
        }
    }

}