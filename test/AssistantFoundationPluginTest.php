<?php declare(strict_types=1);

namespace AssistantFoundation\Test;

use PHPUnit\Framework\TestCase;
use AssistantFoundation\AssistantFoundationPlugin;
use Base3\Api\IContainer;

class AssistantFoundationPluginTest extends TestCase {

	public function testGetNameReturnsExpectedValue(): void {
		$this->assertSame('assistantfoundationplugin', AssistantFoundationPlugin::getName());
	}

	public function testInitRegistersPluginInContainerAsShared(): void {
		$container = new FakeContainer();
		$plugin = new AssistantFoundationPlugin($container);

		$plugin->init();

		$this->assertTrue($container->has(AssistantFoundationPlugin::getName()));
		$this->assertSame(IContainer::SHARED | IContainer::NOOVERWRITE, $container->getFlags(AssistantFoundationPlugin::getName()));
		$this->assertSame($plugin, $container->get(AssistantFoundationPlugin::getName()));
	}

}

require_once __DIR__ . '/FakeContainer.php';
