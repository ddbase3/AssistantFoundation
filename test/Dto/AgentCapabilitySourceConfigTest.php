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

final class AgentCapabilitySourceConfigTest extends TestCase {

	public function testAliasesAndStringListsAreNormalized(): void {
		$config = AgentCapabilitySourceConfig::fromArray([
			'tool_ids' => "crm-reader, crm-writer\ncrm-reader",
			'capability_providers' => ['internal-mcp', ''],
			'modules' => 'coding-style, customer-research',
			'resource_providers' => ['project-files'],
			'prompt_providers' => ['support-prompts'],
			'strict' => '0'
		]);

		$this->assertSame(['crm-reader', 'crm-writer'], $config->getToolIds());
		$this->assertSame(['internal-mcp'], $config->getProviderIds());
		$this->assertSame(['coding-style', 'customer-research'], $config->getModuleIds());
		$this->assertSame(['project-files'], $config->getResourceProviderIds());
		$this->assertSame(['support-prompts'], $config->getPromptProviderIds());
		$this->assertFalse($config->isStrict());
	}

	public function testEmptyDefaultIsStrictAndContainsNoSources(): void {
		$config = new AgentCapabilitySourceConfig();

		$this->assertTrue($config->isEmpty());
		$this->assertTrue($config->isStrict());
		$this->assertSame([
			'tools' => [],
			'providers' => [],
			'modules' => [],
			'resourceProviders' => [],
			'promptProviders' => [],
			'strict' => true
		], $config->toArray());
	}
}
