<?php

namespace App\Tests\Entity\Measurment;

use PHPUnit\Framework\TestCase;
use App\Entity\Measurment;

class CelsiusToFahrenheitTest extends TestCase
{
    public function dataProvider()
    {
        $data = [
            [20.0, 68.0],
            [5.0, 41.0],
            [10.0, 50.0],
        ];

        return $data;
    }

    /**
     * @param $celsius
     * @param $expectedResult
     * @return void
     * 
     * @dataProvider dataProvider
     */
    
    public function testMethod($celsius, $expectedResult): void
    {
        $measurement = new Measurment();
        $this->assertEquals($expectedResult, $measurement->celsiusToFahrenheit($celsius));
    }
}
