# chippyash/math-type-calculator

## Quality Assurance

![PHP 5.4](https://img.shields.io/badge/PHP-5.4-blue.svg)
![PHP 5.5](https://img.shields.io/badge/PHP-5.5-blue.svg)
![PHP 5.6](https://img.shields.io/badge/PHP-5.6-blue.svg)
![PHP 7](https://img.shields.io/badge/PHP-7-blue.svg)
[![Build Status](https://travis-ci.org/chippyash/Math-Type-Calculator.svg?branch=master)](https://travis-ci.org/chippyash/Math-Type-Calculator)
[![Test Coverage](https://codeclimate.com/github/chippyash/Math-Type-Calculator/badges/coverage.svg)](https://codeclimate.com/github/chippyash/Math-Type-Calculator/coverage)
[![Code Climate](https://codeclimate.com/github/chippyash/Math-Type-Calculator/badges/gpa.svg)](https://codeclimate.com/github/chippyash/Math-Type-Calculator)

See the [test contract](https://github.com/chippyash/Math-Type-Calculator/blob/master/docs/Test-Contract.md).

The above badges represent the current master branch.  As a rule, I don't push
 to GitHub unless tests, coverage and usability are acceptable.  This may not be
 true for short periods of time; on holiday, need code for some other downstream
 project etc.  If you need stable code, use a tagged version. Read 'Further Documentation'
 and 'Installation'.
 
Current development branch is feature/gmp_support. Want to help? - that's where it is.

Please note that developer support for PHP5.4 & 5.5 was withdrawn at version 3.0.0 of this library.
If you need support for PHP 5.4 or 5.5, please use a version `>=2,<3`
 
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

Check out [ZF4 Packages](http://zf4.biz/packages?utm_source=github&utm_medium=web&utm_campaign=blinks&utm_content=typecalculator) for more packages

## How

### Coding Basics

Using the supplied calculator or comparator will set the underlying Strong Type
numeric base to PHP Native.  This library does not yet support GMP number types.

#### Calculations

Using the calculator is simplicity itself:

<pre>
    use Chippyash\Math\Type\Calculator;

    $calc = new Calculator()
</pre>

Then you simply fire calculation requests at it:

<pre>
    use Chippyash\Type\TypeFactory;

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
    use Chippyash\Math\Type\Comparator;
    use Chippyash\Type\TypeFactory;

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
    "chippyash/math-type-calculator": ">=3,<4"
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

## License

This software library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

This software library is Copyright (c) 2015-2016, Ashley Kitson, UK

A commercial license is available for this software library, please contact the author. 
It is normally free to deserving causes, but gets you around the limitation of the GPL
license, which does not allow unrestricted inclusion of this code in commercial works.

### Eek - GPL!

Broadly speaking:

In the following 'this', means this software library

- You are using this for a private project - crack on\!
- You are using this in an internal system or website - crack on\!
- You are using this as part of a purely personal web - crack on\!
- You are using this for your web site, and it doesn't form part of the equity - crack on\!
 
- You are using this in any form of closed system that you intend to sell - you need to
	conform to GPL V3 or buy a commercial license
- You are using this in any form of public web site and you want to sell it or your business comprising 
	the website - you need conform to GPL V3 or buy a commercial license

- You are a charity using this for any purpose, notwithstanding the above - crack on\!

If in any doubt, please engage the services of your nearest high paid patent and rights 
lawyer. They'll be happy to take your money.  Instead of which you could 
be nice and give the money to your local agency in need.

Latest figures:
- me : about even
- corporations : down
- charities : up

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

V2.0.0 BC Break: change namespace from chippyash\Math to Chippyash\Math\Type
  
V2.0.1 Add link to packages

V2.0.2 Ensure compatibility with PHP7

V2.0.3 Dependency update

V3.0.0 BC Break. Withdraw support for old PHP versions

