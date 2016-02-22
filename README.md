# chippyash/math-type-calculator

## Quality Assurance

[![Build Status](https://travis-ci.org/chippyash/Math-Type-Calculator.svg?branch=master)](https://travis-ci.org/chippyash/Math-Type-Calculator)
[![Coverage Status](https://coveralls.io/repos/chippyash/Math-Type-Calculator/badge.png)](https://coveralls.io/r/chippyash/Math-Type-Calculator)

See the [test contract](https://github.com/chippyash/Math-Type-Calculator/blob/master/docs/Test-Contract.md).

Build coverage only <100% due to inability of coverage engine to understand that
closing brackets on a method are part of the method, even if they are never
reached !

## What?

Provides arithmetic calculation support for chippyash/strong-type numeric types, (PHP
native types only at this point.)

### Types supported

*  FloatType
*  ComplexType
*  IntType
*  NaturalIntType
*  WholeIntType
*  RationalType
*  Conversion of PHP int and float to IntType and FloatType respectively

### Arithmetic support provided

*  addition
*  subtraction
*  multiplication
*  division
*  reciprocal
*  equality comparison

The library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

## Why?

Complements the strong-type library and a precursor to the forthcoming chippyash/math-matrix
library which builds on the chippyash/matrix library.

## When

The current library covers arithmetic operations using PHP native math support.
Future versions will add support for the popular math extensions (gmp, bcmath etc).

If you want more, either suggest it, or better still, fork it and provide a pull request.

Check out [chippyash/Strong-Type](https://github.com/chippyashl/Strong-Type) for strong type including numeric,
rational and complex type support, that this library operates on

Check out [chippyash/Matrix](https://github.com/chippyash/Matrix) for Matrix data type support.

Check out [chippyash/Logical-Matrix](https://github.com/chippyash/Logical-matrix) for logical matrix operations

Check out [chippyash/Math-Matrix](https://github.com/chippyash/Math-Matrix) for mathematical matrix operations


## How

### Coding Basics

Using the supplied calculator or comparator will set the underlying Strong Type
numeric base to PHP Native.  This library does not yet support GMP number types.

#### Calculations

Using the calculator is simplicity itself:

<pre>
    use chippyash\Math\Type\Calculator;

    $calc = new Calculator()
</pre>

Then you simply fire calculation requests at it:

<pre>
    use chippyash\Type\TypeFactory;

    $r = TypeFactory::create('rational', 2, 3);
    $i = TypeFactory::create('int', 23);
    $w = TypeFactory::create('whole', 3);
    $n = TypeFactory::create('natural', 56);
    $f = TypeFactory::create('float', 19.6);
    $c1 = TypeFactory::create('complex', '2+3i');
    $c2 = TypeFactory::create('complex', '-6+4i');

    echo $calc->add($r, $w) . PHP_EOL;
    echo $calc->add($c1, $c2) . PHP_EOL;
    echo $calc->add($i, $f) . PHP_EOL;
    echo $calc->sub($c1, $c2) . PHP_EOL;
    echo $calc->sub($n, $w) . PHP_EOL;
    echo $calc->add($r, $w) . PHP_EOL;
    echo $calc->add($r, $w) . PHP_EOL;
    echo $calc->add($r, $w) . PHP_EOL;
</pre>

The Calculator supports the following methods (all operands are NumericTypeInterface, or PHP int or PHP float):

*  add($a, $b) : NumericTypeInterface
*  sub($a, $b) : NumericTypeInterface
*  mul($a, $b  : NumericTypeInterface
*  div($a, $b) : NumericTypeInterface
*  reciprocal($a) : NumericTypeInterface
*  pow($base, $exp) : NumericTypeInterface
*  sqrt($a) : NumericTypeInterface

The Calculator will arbitrate between types and return the lowest possible type based on the operand types.
The order of precedence is

*  ComplexType
*  RationalType
*  FloatType
*  IntType (including WholeIntType and NaturalIntType)

Be careful with complex types, they can only be converted down if they are real, i.e. the imaginary part == 0

The sqrt() method is provided as a convenience, you can use pow(n, 1/e) e.g. pow(4, 1/2) == sqrt(4)

For a demonstration of all the available operations between types and their
resultant types run the examples/example-calc.php file

#### Comparisons

To compare two numeric types:

<pre>
    use chippyash\Math\Type\Comparator;
    use chippyash\Type\TypeFactory;

    $r = TypeFactory::create('rational', 2, 3);
    $i = TypeFactory::create('int', 23);
    $w = TypeFactory::create('whole', 3);
    $n = TypeFactory::create('natural', 56);
    $f = TypeFactory::create('float', 19.6);
    $c1 = TypeFactory::create('complex', '2+3i');
    $c2 = TypeFactory::create('complex', '-6+4i');

    $comp = new Comparator();

    if ($comp->compare($r, $i) == 0) {...}
    if ($comp->compare($c1, $c2) == -1) {...}
    if ($comp->compare($w, $n) == 1) {...}
</pre>

The Comparator::compare($a, $b) method takes two NumericTypeInterface types and returns

    a == b: 0
    a < b : -1
    a > b : 1

It has convenience methods (all operands are NumericTypeInterface):

*  eq($a, $b) : boolean: $a == $b
*  neq($a, $b) : boolean: $a != $b
*  lt($a, $b) : boolean: $a < $b
*  lte($a, $b) : boolean: $a <= $b
*  gt($a, $b) : boolean: $a > $b
*  gte($a, $b) : boolean: $a >= $b

<pre>
    if ($comp->gt($w, $f) { ... }
</pre>

### Changing the library

1.  fork it
2.  write the test
3.  amend it
4.  do a pull request

Found a bug you can't figure out?

1.  fork it
2.  write the test
3.  do a pull request

NB. Make sure you rebase to HEAD before your pull request

## Where?

The library is hosted at [Github](https://github.com/chippyash/Math-Type-Calculator). It is
available at [Packagist.org](https://packagist.org/packages/chippyash/math-type-calculator)

### Installation

Install [Composer](https://getcomposer.org/)

#### For production

add

<pre>
    "chippyash/math-type-calculator": "~1.1"
</pre>

to your composer.json "requires" section

#### For development

Clone this repo, and then run Composer in local repo root to pull in dependencies

<pre>
    git clone git@github.com:chippyash/chippyash/Math-Type-Calculator.git TypeCalc
    cd TypeCalc
    composer update
</pre>

To run the tests:

<pre>
    cd TypeCalc
    vendor/bin/phpunit -c test/phpunit.xml test/
</pre>

## History

V0...  pre releases

V1.0.0 Original release

V1.0.1 Add ability to mix complex and non complex types as operands

V1.0.2 Utilise chippyash/strong-type >= 1.0.10

V1.1.0 Add comparator class for equality comparison

V1.1.1 Fix bad comparator construction

V1.1.2 Fix native int/float comparison by casting to rational

V1.1.4 Refactor for dependent library

V1.1.5 Update dependent version number

V1.1.6 Add pow and square root functionality

V1.1.7 Add complex pow using complex exponent

V1.1.8 Update dependent version number

V1.1.9 Update dependent version number
V1.1.9a Bump to fix failing build

V1.1.10 Fix calculator to use Native PHP numeric types until GMP calculator support is available


