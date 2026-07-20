<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentCapability;
use AssistantFoundation\Dto\AgentCapabilityCatalog;
use AssistantFoundation\Dto\AgentCapabilitySelectionConfig;
use PHPUnit\Framework\TestCase;

final class AgentCapabilityCatalogTest extends TestCase {

	public function testDuplicateOperationalNamesAreRejected(): void {
		$capability = $this->capability('lookup');

		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Duplicate agent capability name: lookup');

		new AgentCapabilityCatalog([$capability, $capability]);
	}

	public function testSelectionConfigAcceptsAgentFacingArrayKeys(): void {
		$config = AgentCapabilitySelectionConfig::fromArray([
			'maxTools' => 8,
			'selectAllThreshold' => 4,
			'includeTags' => ['crm'],
			'alwaysAvailable' => ['general_info'],
			'sticky' => false,
			'strategy' => 'semantic',
			'semanticCandidateTools' => 32,
			'semanticMaxPromptCharacters' => 24000
		]);

		$this->assertSame(8, $config->getMaxTools());
		$this->assertSame(4, $config->getSelectAllThreshold());
		$this->assertSame(['crm'], $config->getIncludeTags());
		$this->assertSame(['general_info'], $config->getAlwaysAvailable());
		$this->assertFalse($config->isSticky());
		$this->assertSame(AgentCapabilitySelectionConfig::STRATEGY_SEMANTIC, $config->getStrategy());
		$this->assertSame(32, $config->getSemanticCandidateTools());
		$this->assertSame(24000, $config->getSemanticMaxPromptCharacters());
	}

	private function capability(string $name): AgentCapability {
		return new AgentCapability(
			name: $name,
			title: ucfirst($name),
			description: 'Test capability.',
			category: 'test',
			tags: ['test'],
			priority: 0,
			definition: [
				'type' => 'function',
				'function' => [
					'name' => $name,
					'parameters' => ['type' => 'object', 'properties' => []]
				]
			]
		);
	}
}
