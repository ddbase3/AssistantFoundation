<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation defines reusable contracts for AI assistants and agents.
 * It provides DTOs, models, and interfaces for retrieval, speech and tools.
 * Implementations reside in independent BASE3 runtime plugins.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace Base3\AssistantFoundation\Test;

use PHPUnit\Framework\TestCase;
use Base3\AssistantFoundation\AssistantFoundationPlugin;
use Base3\CoreFoundation\Api\IContainer;

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
