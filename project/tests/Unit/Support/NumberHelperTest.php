<?php

namespace Tests\Unit\Support;

use App\Support\NumberHelper;
use Tests\Cases\TestCaseWithoutFramework;

class NumberHelperTest extends TestCaseWithoutFramework
{
    public function testFormat()
    {
        $this->assertSame('1,00', NumberHelper::format(1));
        $this->assertSame('1,01', NumberHelper::format(1.01));
        $this->assertSame('1,00', NumberHelper::format(1.001));
        $this->assertSame('1,001', NumberHelper::format(1.001, 3));
        $this->assertSame('1.001', NumberHelper::format(1.001, 3, '.'));
        $this->assertSame('1,000.001', NumberHelper::format(1000.001, 3, '.', ','));
    }

    public function testToFloat()
    {
        $this->assertSame(1.0, NumberHelper::toFloat('1,00'));
        $this->assertSame(2.03, NumberHelper::toFloat('2,03'));
        $this->assertSame(2.003, NumberHelper::toFloat('2,003'));
        $this->assertSame(1232.003, NumberHelper::toFloat('1.232,003'));
        $this->assertSame(1232.003, NumberHelper::toFloat('1,232.003', '.', ','));
    }

    public function testToFloatWithInvalidNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/is not a valid number/');
        NumberHelper::toFloat('invalid-number');
    }

    public function testToFloatWithRepeatedSeparators()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Decimal point separator and thousand separator cannot be equals');
        NumberHelper::toFloat('1', '.', '.');
    }
}
