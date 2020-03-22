<?php

namespace Tests\Unit\Support;

use App\Support\Flash;
use Tests\Cases\TestCaseUnit;

class FlashTest extends TestCaseUnit
{
    /** @var mixed */
    private $session;

    public function setUp(): void
    {
        parent::setUp();
        $this->session = app('session');
    }

    public function testSuccessMethod()
    {
        (new Flash())->success('success message');

        $this->assertEquals($this->session->has('success'), true);
        $this->assertEquals($this->session->get('success')[0], 'success message');
    }

    public function testInfoMethod()
    {
        (new Flash())->info('info message');

        $this->assertEquals($this->session->has('info'), true);
        $this->assertEquals($this->session->get('info')[0], 'info message');
    }

    public function testWarningMethod()
    {
        (new Flash())->warning('warning message');

        $this->assertEquals($this->session->has('warning'), true);
        $this->assertEquals($this->session->get('warning')[0], 'warning message');
    }

    public function testErrorMethod()
    {
        (new Flash())->error('error message');

        $this->assertEquals($this->session->has('error'), true);
        $this->assertEquals($this->session->get('error')[0], 'error message');
    }

    public function testMixedMessagesSimultaneously()
    {
        $flash = new Flash();
        $flash->error('error message');
        $flash->info('info message');
        $flash->warning('warning message');
        $flash->success('success message');
        $flash->success('success message 2');

        $this->assertEquals($this->session->get('error')[0], 'error message');
        $this->assertEquals($this->session->get('info')[0], 'info message');
        $this->assertEquals($this->session->get('warning')[0], 'warning message');
        $this->assertEquals($this->session->get('success')[0], 'success message');
        $this->assertEquals($this->session->get('success')[1], 'success message 2');
    }

    public function testArrayOfMessages()
    {
        $flash = new Flash();
        $flash->success(['success message', 'success message 2']);

        $this->assertEquals($this->session->get('success')[0], 'success message');
        $this->assertEquals($this->session->get('success')[1], 'success message 2');
    }

    public function testShouldNotRepeatMessages()
    {
        $flash = new Flash();
        $flash->success(['success message', 'success message']);

        $this->assertEquals(1, count($this->session->get('success')));
        $this->assertEquals('success message', $this->session->get('success')[0]);
    }

    public function testChainedDeclaration()
    {
        (new Flash())
            ->error('error message')
            ->info('info message');

        $this->assertEquals($this->session->get('error')[0], 'error message');
        $this->assertEquals($this->session->get('info')[0], 'info message');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->session);
    }
}
