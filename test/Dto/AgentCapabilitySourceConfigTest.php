<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentCapabilitySourceConfig;
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
