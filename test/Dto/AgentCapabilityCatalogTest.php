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
			'sticky' => false
		]);

		$this->assertSame(8, $config->getMaxTools());
		$this->assertSame(4, $config->getSelectAllThreshold());
		$this->assertSame(['crm'], $config->getIncludeTags());
		$this->assertSame(['general_info'], $config->getAlwaysAvailable());
		$this->assertFalse($config->isSticky());
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
