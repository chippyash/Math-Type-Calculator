# Chippyash Strong Type Calculator

## 
      chippyash\Test\Math\Type\Calculator\Native
    

*  Int add with non int types computes result
*  Int pow returns rational or int or complex types

## 
      chippyash\Test\Math\Type\CalculatorAdd
    

*  Add two ints returns int type
*  Add int and float returns float type
*  Add two floats returns float type
*  Add two int types returns int type
*  Add int type and float returns float type
*  Add int type and float type returns float type
*  Add two float types returns float type
*  Add float type and int returns float type
*  Add two whole int types returns whole int type
*  Add whole int type and int returns whole int type
*  Add whole int type and int type returns whole int type
*  Add whole int type and float type returns float type
*  Add whole int type and float returns float type
*  Add two natural int types returns natural int type
*  Add natural int type and int returns natural int type
*  Add natural int type and int type returns natural int type
*  Add natural int type and float type returns float type
*  Add natural int type and float returns float type
*  Add whole int type and natural int returns whole int type
*  Add rational type and int returns rational type
*  Add rational type and int type returns rational type
*  Add rational type and whole int type returns rational type
*  Add rational type and natural int type returns rational type
*  Add rational type and float returns rational type
*  Add rational type and float type returns rational type
*  Add two complex numbers returns complex number
*  Add complex numbers with non complex number returns complex number
*  Add non complex numbers with complex number throws exception
*  Addition is commutative
*  Addition is associative
*  Addition gives correct results

## 
      chippyash\Test\Math\Type\CalculatorDiv
    

*  Div two ints returns rational type
*  Div two int types returns rational type
*  Div int and float returns float type
*  Div int type and float returns float type
*  Div two floats returns float type
*  Div two float types returns float type
*  Div float type and float returns float type
*  Div float type and float type returns float type
*  Div float type and int returns float type
*  Div float type and int type returns float type
*  Div two whole float types returns rational type
*  Div whole int type and float type returns float type
*  Div whole int type and float returns float type
*  Div two natural int types returns rational type
*  Div natural int type and float returns rational type
*  Div natural int type and float type returns float type
*  Div natural int type and whole int returns rational type
*  Div whole int type and natural int type returns rational type
*  Div rational type and int returns rational type
*  Div rational type and float type returns rational type
*  Div rational type and whole int type returns rational type
*  Div rational type and natural int type returns rational type
*  Div rational type and float returns rational type
*  Div two complex numbers returns complex number
*  Div complex numbers with non complex number returns complex number
*  Div non complex numbers with complex number throws exception
*  Div complex by zero complex throws exception
*  Division is not commutative
*  Division is not associative

## 
      chippyash\Test\Math\Type\CalculatorMul
    

*  Mul two ints returns int type
*  Mul int and float returns float type
*  Mul two floats returns float type
*  Mul two int types returns int type
*  Mul int type and float returns float type
*  Mul int type and float type returns float type
*  Mul two float types returns float type
*  Mul float type and int returns float type
*  Mul two whole int types returns whole int type
*  Mul whole int type and int returns whole int type
*  Mul whole int type and int type returns whole int type
*  Mul whole int type and float type returns float type
*  Mul whole int type and float returns float type
*  Mul two natural int types returns natural int type
*  Mul natural int type and int returns natural int type
*  Mul natural int type and int type returns natural int type
*  Mul natural int type and float type returns float type
*  Mul natural int type and float returns float type
*  Mul whole int type and natural int returns whole int type
*  Mul rational type and int returns rational type
*  Mul rational type and int type returns rational type
*  Mul rational type and whole int type returns rational type
*  Mul rational type and natural int type returns rational type
*  Mul rational type and float returns rational type
*  Mul rational type and float type returns rational type
*  Mul two complex numbers returns complex number
*  Mul complex numbers with non complex number returns complex number
*  Mul non complex numbers with complex number throws exception
*  Multiplication is commutative
*  Multiplication is associative
*  Multiplication is distributive over addition
*  Multiplication is distributive over subtraction

## 
      chippyash\Test\Math\Type\CalculatorPow
    

*  Pow with integer base and integer exponent returns int type
*  Pow with integer base and float exponent returns rational type
*  Pow with int type base and zero complex exponent returns int type one
*  Pow with float base and integer exponent returns float type
*  Pow with float base and float exponent returns float type
*  Pow with float base and rational exponent returns float type
*  Pow with float type base and zero complex exponent returns int type one
*  Pow with float base and complex exponent returns complex type
*  Pow with rational base returns rational type
*  Pow with complex base returns complex type
*  Pow with zero complex base and complex exponent returns zero complex
*  Can compute roots using pow

## 
      chippyash\Test\Math\Type\CalculatorReciprocal
    

*  Reciprocal of number types returns float type
*  Reciprocal of rational type returns rational type
*  Reciprocal of complex type returns complex type
*  Reciprocal of zero complex throws exception
*  Reciprocal of unknow type throws exception

## 
      chippyash\Test\Math\Type\CalculatorSqrt
    

*  Sqrt int type returns int type for perfect squares
*  Sqrt int type returns rational type for imperfect squares
*  Sqrt rational type returns rational type
*  Sqrt float type returns float type
*  Sqrt complex type returns complex type

## 
      chippyash\Test\Math\Type\CalculatorSub
    

*  Sub two ints returns int type
*  Sub int and float returns float type
*  Sub two floats returns float type
*  Sub two int types returns int type
*  Sub int type and float returns float type
*  Sub int type and float type returns float type
*  Sub two float types returns float type
*  Sub float type and int returns float type
*  Sub two whole int types returns whole int type
*  Sub whole int type and int returns whole int type
*  Sub whole int type and int type returns whole int type
*  Sub whole int type and float type returns float type
*  Sub whole int type and float returns float type
*  Sub two natural int types returns natural int type
*  Sub natural int type and int returns natural int type
*  Sub natural int type and int type returns natural int type
*  Sub natural int type and float type returns float type
*  Sub natural int type and float returns float type
*  Sub whole int type and natural int returns whole int type
*  Sub rational type and int returns rational type
*  Sub rational type and int type returns rational type
*  Sub rational type and whole int type returns rational type
*  Sub rational type and natural int type returns rational type
*  Sub rational type and float returns rational type
*  Sub rational type and float type returns rational type
*  Sub two complex numbers returns complex number
*  Sub complex numbers with non complex number returns complex number
*  Sub non complex numbers with complex number throws exception
*  Subtraction is not commutative
*  Subtraction is not associative

## 
      chippyash\Test\Math\Type\Calculator
    

*  Construct with no parameter returns calculator
*  Construct with valid engine type returns calculator
*  Construct with calculator engine interface type returns calculator
*  Construct with invalid calculator engine throws exception

## 
      chippyash\Test\Math\Type\Comparator\AbstractComparatorEngine
    

*  Eq returns boolean
*  Neq returns boolean
*  Lt returns boolean
*  Lte returns boolean
*  Gt returns boolean
*  Gte returns boolean

## 
      chippyash\Test\Math\Type\Comparator\Native
    

*  Compare ints returns correct result
*  Compare floats returns correct result
*  Compare rationals returns correct result
*  Compare real complex returns correct result based on real part
*  Compare unreal complex returns correct result based on real part
*  Can mix complex and non complex types for comparison
*  Can mix types for comparison

## 
      chippyash\Test\Math\Type\Comparator
    

*  Construct with no parameter returns comparator
*  Construct with valid engine type returns comparator
*  Construct with comparator engine interface type returns comparator
*  Construct with invalid comparator engine throws exception
*  Compare returns result
*  Magic call returns result for known method
*  Magic call throws exception for unknown method


Generated by [chippyash/testdox-converter](https://github.com/chippyash/Testdox-Converter)