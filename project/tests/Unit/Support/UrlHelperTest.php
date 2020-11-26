<?php

namespace Tests\Unit\Support;

use App\Support\UrlHelper;
use Tests\Cases\TestCaseWithoutFramework;

class UrlHelperTest extends TestCaseWithoutFramework
{
    public function testIsValidUrl()
    {
        $this->assertEquals(true, UrlHelper::isValidUrl('http://google.com'));
        $this->assertEquals(true, UrlHelper::isValidUrl('http://127.0.0.1'));
        $this->assertEquals(true, UrlHelper::isValidUrl('https://www.uol.com'));
        $this->assertEquals(false, UrlHelper::isValidUrl('Teste'));
    }

    public function testMergeQueriesHttp()
    {
        $initialUrlHttp = 'http://localhost';

        $this->assertEquals(
            'http://localhost?test=abc',
            UrlHelper::mergeQueries($initialUrlHttp, ['test' => 'abc'])
        );

        $this->assertEquals(
            'http://localhost?test=abc&other=123',
            UrlHelper::mergeQueries($initialUrlHttp, ['test' => 'abc', 'other' => 123]));

        $this->assertEquals(
            'http://localhost?test=abc&other=123',
            UrlHelper::mergeQueries($initialUrlHttp.'?test=AAA', ['test' => 'abc', 'other' => 123])
        );
    }

    public function testMergeQueriesHttps()
    {
        $initialUrlHttps = 'https://localhost';

        $this->assertEquals(
            'https://localhost?test=abc',
            UrlHelper::mergeQueries($initialUrlHttps, ['test' => 'abc'])
        );

        $this->assertEquals(
            'https://localhost?test=abc&other=123',
            UrlHelper::mergeQueries($initialUrlHttps, ['test' => 'abc', 'other' => 123]));

        $this->assertEquals(
            'https://localhost?test=abc&other=123',
            UrlHelper::mergeQueries($initialUrlHttps.'?test=AAA', ['test' => 'abc', 'other' => 123])
        );

        $this->assertEquals(
            'https://localhost',
            UrlHelper::mergeQueries($initialUrlHttps, [])
        );
    }
}
