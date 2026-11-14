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

namespace Base3\AssistantFoundation\Test\Dto;

use Base3\AssistantFoundation\Dto\AgentCapabilitySourceConfig;
use PHPUnit\Framework\TestCase;

final class AgentCapabilitySourceConfigEdgeCasesTest extends TestCase {

	public function testDelimitedAliasesNormalizeEverySourceFamily(): void {
		$config = AgentCapabilitySourceConfig::fromArray([
			'tool_ids' => " reader, reader\n writer ",
			'capability_providers' => 'primary, secondary',
			'module_ids' => ['guide', 'guide', ''],
			'resource_provider_ids' => 'course-files',
			'prompt_provider_ids' => ['search-prompt'],
			'strict' => 'OFF'
		]);
		$this->assertSame(['reader', 'writer'], $config->getToolIds());
		$this->assertSame(['primary', 'secondary'], $config->getProviderIds());
		$this->assertSame(['guide'], $config->getModuleIds());
		$this->assertSame(['course-files'], $config->getResourceProviderIds());
		$this->assertSame(['search-prompt'], $config->getPromptProviderIds());
		$this->assertFalse($config->isStrict());
		$this->assertFalse($config->isEmpty());
		$this->assertSame($config->toArray(), AgentCapabilitySourceConfig::fromArray($config->toArray())->toArray());
	}

	public function testMissingOrUnsupportedIdentifierContainersBecomeEmpty(): void {
		$config = AgentCapabilitySourceConfig::fromArray(['providers' => 42, 'tools' => new \stdClass(), 'strict' => 0]);
		$this->assertTrue($config->isEmpty());
		$this->assertFalse($config->isStrict());
		$this->assertTrue((new AgentCapabilitySourceConfig())->isStrict());
	}
}
