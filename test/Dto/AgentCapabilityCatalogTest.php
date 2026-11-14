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

use Base3\AssistantFoundation\Dto\AgentCapability;
use Base3\AssistantFoundation\Dto\AgentCapabilityCatalog;
use Base3\AssistantFoundation\Dto\AgentCapabilitySelectionConfig;
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
			'semanticMaxPromptCharacters' => 24000,
			'selectionUnit' => 'source',
			'maxSources' => 5
		]);

		$this->assertSame(8, $config->getMaxTools());
		$this->assertSame(4, $config->getSelectAllThreshold());
		$this->assertSame(['crm'], $config->getIncludeTags());
		$this->assertSame(['general_info'], $config->getAlwaysAvailable());
		$this->assertFalse($config->isSticky());
		$this->assertSame(AgentCapabilitySelectionConfig::STRATEGY_SEMANTIC, $config->getStrategy());
		$this->assertSame(32, $config->getSemanticCandidateTools());
		$this->assertSame(24000, $config->getSemanticMaxPromptCharacters());
		$this->assertSame(AgentCapabilitySelectionConfig::SELECTION_UNIT_SOURCE, $config->getSelectionUnit());
		$this->assertTrue($config->selectsSources());
		$this->assertSame(5, $config->getMaxSources());
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
