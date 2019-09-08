<?php

namespace App\Tests\Util;

use App\Util\Calculator;
use PHPUnit\Framework\TestCase;


class CalculatorTest extends TestCase
{
    //calls before every test
    public function setUp()
    {
        $this->calculator = new Calculator();
    }

    public function tearDown(){
        unset($this->calculator);
    }

    /**
     * @dataProvider  providerArgs
     *
     */
    public function testAdd($one, $two)
    {
        $expected_result = $one + $two;

        $calculator = new Calculator();
        $result = $this->calculator->add($one, $two);

        $this->assertEquals($expected_result, $result);

        return $result;
    }

    /**
     * @dataProvider  providerArgs
     *
     */
    public function testAdd_another($one, $two)
    {
        $expected_result = $one + $two;

        $calculator = new Calculator();
        $result = $this->calculator->add($one, $two);

        $this->assertEquals($expected_result, $result);

        return $result;
    }

    /**
     * @depends testAdd
     * @depends testAdd_another
     */
    public function testDivide($one, $two)
    {
        try{

            if($two == 0){
                throw new \Exception('Divide by zero');
            }

            $expected_result = $one / $two;

            $calculator = new Calculator();
            $result = $this->calculator->divide($one, $two);

            $this->assertEquals($expected_result, $result);

        }catch (\Exception $exception){

            $this->assertEquals('Divide by zero', $exception->getMessage());

        }
    }

    public function providerArgs()
    {
        return [
            [ 1, 2 ],
            [ 5, 6],
            [ 3, -3],
            [ 0, 0]
        ];
    }

    public function invokePrivateMethod(&$object, $methodName, array $parameters = []){
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}