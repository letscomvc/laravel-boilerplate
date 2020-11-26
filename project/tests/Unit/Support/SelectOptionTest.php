<?php

namespace Tests\Unit\Support;

use App\Support\SelectOption;
use Tests\Cases\TestCaseWithoutFramework;

class SelectOptionTest extends TestCaseWithoutFramework
{
    public function testOptionGetters()
    {
        $selectOption = new SelectOption('testValue', 'Text');

        $this->assertEquals('testValue', $selectOption->getValue());
        $this->assertEquals('Text', $selectOption->getText());
    }

    public function testJsonSerialization()
    {
        $selectOption = new SelectOption('testValue', 'Text');
        $this->assertEquals(json_encode($selectOption), '{"value":"testValue","text":"Text"}');
    }
}
