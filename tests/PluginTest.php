<?php

namespace PaulEasyVote\Tests;

use PaulEasyVote\PaulEasyVote as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'PaulEasyVote' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['PaulEasyVote'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
