<?php

namespace Tests\Unit\Support;

use Tests\Cases\TestCaseUnit;

class HelpersTest extends TestCaseUnit
{
    public function testSepareByCommaFunction()
    {
        $this->assertEquals('um, dois, três', implode_with_comma(['um', 'dois', 'três']));
        $this->assertEquals('um, dois e três', implode_with_comma(['um', 'dois', 'três'], ' e '));
    }

    public function testMaskFunction()
    {
        $maskedValue1 = mask('12345678901234', '##.###.###/####-##');
        $maskedValue2 = mask('12345678901234', 'uu.uuu.uuu/uuuu-uu', 'u');

        $this->assertEquals($maskedValue1, '12.345.678/9012-34');
        $this->assertEquals($maskedValue2, '12.345.678/9012-34');
    }

    public function testApplyParamsFunction()
    {
        $this->assertEquals(apply_params('test/:param', ['one']), 'test/one');
        $this->assertEquals(apply_params('test/{first_param}', ['one'], '{', '}'), 'test/one');

        $this->assertEquals(apply_params('test/:first_param/:second_param', ['one', 'two']), 'test/one/two');
        $this->assertEquals(apply_params('test/{first_param}/{second_param}', ['one', 'two'], '{', '}'),
            'test/one/two');
    }
}
