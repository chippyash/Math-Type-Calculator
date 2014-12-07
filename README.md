# chippyash/math-type-calculator

## Quality Assurance

[![Build Status](https://travis-ci.org/chippyash/Math-Type-Calculator.svg?branch=master)](https://travis-ci.org/chippyash/Math-Type-Calculator)
[![Coverage Status](https://coveralls.io/repos/chippyash/Math-Type-Calculator/badge.png)](https://coveralls.io/r/chippyash/Math-Type-Calculator)

Build coverage only <100% due to inability of coverage engine to understand that
closing brackets on a method are part of the method, even if they are never
reached !

## What?

Provides arithmetic calculation support for chippyash/strong-type numeric types.

### Types supported

*  IntType
*  GMPIntType
*  NaturalIntType
*  WholeIntType
*  RationalType
*  GMPRationalType
*  FloatType
*  ComplexType
*  GMPComplexType
*  Conversion of PHP int and float to IntType and FloatType respectively

### Arithmetic support provided

*  addition
*  subtraction
*  multiplication
*  division
*  reciprocal
*  pow
*  sqrt
*  natLog
*  inc
*  dec

### Comparison support provided

*  eq  a == b
*  neq a != b
*  lt  a < b
*  lte a <= b
*  gt  a > b
*  gte a >= b
*  compare a == b = 0, a < b = -1, a > b = 1

The library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

## Why?

Complements the strong-type library and a precursor to the developing chippyash/math-matrix
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
    echo $calc->natLog($r) . PHP_EOL;
    $calc->inc($w);
    echo $w . PHP_EOL;
    $calc->dec(c1, $n);
    echo $c1 . PHP_EOL;
</pre>

The Calculator supports the following methods (all operands are NumericTypeInterface, 
or PHP int or PHP float, except where explicitly stated):

*  add($a, $b) : NumericTypeInterface
*  sub($a, $b) : NumericTypeInterface
*  mul($a, $b  : NumericTypeInterface
*  div($a, $b) : NumericTypeInterface
*  reciprocal($a) : NumericTypeInterface
*  pow($base, $exp) : NumericTypeInterface
*  sqrt($a) : NumericTypeInterface
*  natLog($a) : AbstractRationalType
*  inc(NumericTypeInterface &$a) : NumericTypeInterface
*  inc(NumericTypeInterface &$a, $inc) : NumericTypeInterface
*  dec(NumericTypeInterface &$a) : NumericTypeInterface
*  dec(NumericTypeInterface &$a, $dec) : NumericTypeInterface

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

### Support for GMP extension - V2 onwards only

The library automatically recognises the availability of the gmp extension and
will use it for int, rational and complex types.  There is no gmp support for 
FloatType - They will be automatically caste to GmpRationalType. Similarly, 
there is no support for WholeIntType and NaturalIntType types. If found, they 
will be automatically caste to GmpIntType. You can force the library to use 
PHP native types by calling

<pre>
    Calculator::setNumberType(Calculator::TYPE_NATIVE);
</pre>

at the start of you code. This will in turn call the setNumberType methods on the
type factories, so you don't need to do that.  The Comparator will use the type
specified for the Calculator.

If you want to get the gmp typed value of a number you can call its gmp() method.

See the documentation for [chippyash/Strong-Type](https://github.com/chippyashl/Strong-Type)
for further information.


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
    "chippyash/math-type-calculator": "~1.1.9"
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


