# chippyash/math-type-calculator

## Quality Assurance



## What?

Provides arithmetic calculation support for chippyash/strong-type numeric types.

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

The library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

## Why?

Complements the strong-type library and a precursor to the forthcoming chippyash/math-matrix
library which builds on the chippyash/matrix library.

## When

The current library covers arithmetic operations using PHP native math support.
Future versions will add support for the popular math extensions (gmp, bcmath etc).

Support for complex number arithmetic is currently limited to using complex
operands only.  Support for other types allows mixing of operand types.

If you want more, either suggest it, or better still, fork it and provide a pull request.

## How

### Coding Basics

Using the calculator is simplicity itself:

<pre>
    use chippyash/Math/Type/Calculator;

    $calc = new Calculator()
</pre>

Then you simply fire calculation requests at it:

<pre>
    use chippyash/Type/TypeFactory;

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

For a demonstration of all the available operations between types and their
resultant types run the examples/example-calc.php file

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
available at [Packagist.org](https://packagist.org/packages/chippyash/chippyash/math-type-calculator)

### Installation

Install [Composer](https://getcomposer.org/)

#### For production

add

<pre>
    "chippyash/math-type-calculator": "~1.0.0"
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
