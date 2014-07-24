<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

include "../vendor/autoload.php";

use chippyash\Math\Type\Calculator;
use chippyash\Type\TypeFactory as F;
use chippyash\Type\Exceptions\InvalidTypeException;

$calc = new Calculator();

function display($op, $p1, $p2 = null)
{
    global $calc;

    $search = ['chippyash\Type\Number\Rational\\','chippyash\Type\Number\Complex\\','chippyash\Type\Number\\'];
    $replace = ['','',''];
    if (is_int($p1)) {
        $tA = 'PHP-Int';
    } elseif (is_float($p1)) {
        $tA = 'PHP-Float';
    } else {
        $tA = str_replace($search, $replace, get_class($p1));
    }
    if (!is_null($p2)) {
        if (is_int($p2)) {
            $tB = 'PHP-Int';
        } elseif (is_float($p2)) {
            $tB = 'PHP-Float';
        } else {
            $tB =  str_replace($search, $replace, get_class($p2));
        }
    }

    try {
        $res = $calc->$op($p1, $p2);
        $tR = str_replace($search, $replace, get_class($res));
        if (!is_null($p2)) {
            echo "{$tA}({$p1}) {$op} {$tB}({$p2}) = {$tR}({$res})" . PHP_EOL;
        } else {
            echo "{$op}({$tA}({$p1})) = {$tR}({$res})" . PHP_EOL;
        }
    } catch (InvalidTypeException $e) {
        $msg = $e->getMessage();
        echo "{$tA}({$p1}) {$op} {$tB}({$p2}) is invalid: {$msg}" . PHP_EOL;
    }
}

$iphp = 19;
$fphp = 13.27;
$i = F::create('int', 6);
$w = F::create('whole', 21);
$n = F::create('natural', 13);
$f = F::create('float', 2.26);
$r = F::Create('rational','2/3');
$items = [$iphp, $i, $w, $n, $fphp, $f, $r];

echo "Library supported arithmetic operations and return types\n";
echo "Non complex numbers\n";
echo "Addition\n\n";
foreach ($items as $a) {
    foreach ($items as $b) {
        display('add', $a, $b);
    }
}
echo "\nSubtraction\n\n";
foreach ($items as $a) {
    foreach ($items as $b) {
        display('sub', $a, $b);
    }
}
echo "\nMultiplication\n\n";
foreach ($items as $a) {
    foreach ($items as $b) {
        display('mul', $a, $b);
    }
}
echo "\nDivision\n\n";
foreach ($items as $a) {
    foreach ($items as $b) {
        display('div', $a, $b);
    }
}

echo "\nReciprocal\n\n";
foreach ($items as $a) {
    display('reciprocal', $a);
}


echo "\nComplex Numbers\n\n";
$c1 = F::create('complex','2+3i');
$c2 = F::create('complex','5-2i');
display('add', $c1, $c2);
display('sub', $c1, $c2);
display('mul', $c1, $c2);
display('div', $c1, $c2);
display('reciprocal', $c1);