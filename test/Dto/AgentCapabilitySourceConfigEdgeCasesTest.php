<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentCapabilitySourceConfig;
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
