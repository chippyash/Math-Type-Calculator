<?php
/**
 * Type-Calculator
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @license GPL V3+ See LICENSE.md
 */


function natLog($x)
{
    $m = 8;
    $s = $x * pow(2, $m);
    $M = agm(1, 4/$s);

    $ln = (M_PI/2*$M) - ($m * log(2));

    return $ln;
}

function agm($a, $g)
{
    $lim = 10;
    do {
        $aa = ($a + $g)/2;
        $gg = sqrt($a * $g);
        echo sprintf("a: %01.20f, g: %01.20f\n", $aa, $gg);
        $a = $aa; $g = $gg;
        $lim--;
    } while (abs($a - $g) > .000000000000000000001 && $lim > 0);

    return ($a + $g)/2;
}

//echo sprintf("agm(24,6) = %f\n", agm(24,6));

//echo sprintf("log(e,e) = %d\n", Log(M_E));
//echo sprintf("ln(e) = %s\n", natLog(M_E));

/**
 * 2^x < n < 3^x
 * x > 0
 * @param $n
 * @return int
 */
function findLimit($n)
{
    //find x just higher than n
    $x = 0;
    do {
        $r = pow(3, $x);
        $x++;
    } while ($r < $n);

    return $x-1;
}

function nl($n, $lim)
{
    $exp = null;
    $found = false;
    $uLim = $lim + 1; //stops at n=6
    $lLim = $lim -1;
    while (!$found) {
        $exp = ($lLim + $uLim) / 2;
        $curr = pow(M_E, $exp);
        if ($curr == $n) {
            $found = true;
            continue;
        }

        if ($curr > $n) {
            $uLim = $exp;
        } else {
            $lLim = $exp;
        }
    }

    return $exp;
}

foreach (range(6,200) as $n) {
    $l = findLimit($n);
    echo sprintf("n = %d, lim %d\n", $n, $l);
    $exp = nl($n, $l);
    echo sprintf("ln(%d)=%f\n", $n, $exp);
}
