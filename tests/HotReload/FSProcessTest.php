<?php

namespace SwooleTW\Http\Tests\HotReload;

use Swoole\Process;
use SwooleTW\Http\HotReload\FSProcess;
use SwooleTW\Http\Tests\TestCase;

/**
 * Class FSProcessTest
 */
class FSProcessTest extends TestCase
{
    public function testItCanCreateHotReloadProcess()
    {
        $process = new FSProcess('.php', true, base_path());

        $this->assertInstanceOf(FSProcess::class, $process);
        $this->assertInstanceOf(Process::class, $process->make());
    }

    public function testItCanCreateHotReloadProcessWithNeededConfiguration()
    {
        $process = new FSProcess('.php', true, base_path());
        $ref = new \ReflectionClass($process);
        $configure = $ref->getMethod('configure');
        $configure->setAccessible(true);
        $configuration = $configure->invoke($process);
        $sampleConfiguration = [
            'fswatch',
            '-rtx',
            '-e',
            '.*',
            '-i',
            "\\.php$",
            base_path(),
        ];

        $this->assertInstanceOf(FSProcess::class, $process);
        $this->assertInstanceOf(Process::class, $process->make());
        $this->assertTrue(
            array_diff($sampleConfiguration, $configuration) === []
        );
    }
}