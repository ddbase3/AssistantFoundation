<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentCapabilitySelectionConfig;
use PHPUnit\Framework\TestCase;

final class AgentCapabilitySelectionConfigTest extends TestCase {

	public function testInputNormalizationSupportsBothKeyFormatsAndDeduplicatesStrings(): void {
		$config = AgentCapabilitySelectionConfig::fromArray([
			'enabled' => 'off', 'strategy' => ' SEMANTIC ', 'max_tools' => 3,
			'include_tools' => [' lookup ', 'lookup', [], '', false, 5],
			'excludeTags' => [' secret ', 'secret', ''],
			'sticky' => 'no', 'semantic_candidate_tools' => 10,
			'selection_unit' => ' SOURCE ', 'max_sources' => 4
		]);
		$this->assertFalse($config->isEnabled());
		$this->assertSame('semantic', $config->getStrategy());
		$this->assertSame(['lookup', 5], $config->getIncludeTools());
		$this->assertSame(['secret'], $config->getExcludeTags());
		$this->assertFalse($config->isSticky());
		$this->assertTrue($config->selectsSources());
		$this->assertSame(4, $config->getMaxSources());
		$this->assertSame(10, $config->getSemanticCandidateTools());
		$this->assertSame($config->toArray(), AgentCapabilitySelectionConfig::fromArray($config->toArray())->toArray());
	}

	public function testWithAlwaysAvailableReturnsNewImmutableUnion(): void {
		$config = AgentCapabilitySelectionConfig::fromArray(['always_available' => ['status'], 'include_tags' => ['crm']]);
		$next = $config->withAlwaysAvailable([' status ', 'lookup', '', 'lookup']);
		$this->assertSame(['status'], $config->getAlwaysAvailable());
		$this->assertSame(['status', 'lookup'], $next->getAlwaysAvailable());
		$this->assertSame(['crm'], $next->getIncludeTags());
		$this->assertSame([], $next->getExcludeTools());
		$this->assertSame([], $next->getIncludeCategories());
		$this->assertSame([], $next->getExcludeCategories());
		$this->assertSame(16, $next->getMaxTools());
		$this->assertSame(16, $next->getSelectAllThreshold());
		$this->assertSame(48000, $next->getSemanticMaxPromptCharacters());
	}

	public function testConstructorRejectsOutOfRangeSettingsAndIncompatibleSemanticPool(): void {
		foreach ([
			['strategy' => 'future'], ['selection_unit' => 'invalid'],
			['max_tools' => 0], ['max_tools' => 513],
			['max_sources' => 0], ['max_sources' => 129],
			['select_all_threshold' => -1], ['select_all_threshold' => 513],
			['semantic_candidate_tools' => 0], ['semantic_candidate_tools' => 513],
			['semantic_max_prompt_characters' => 7999], ['semantic_max_prompt_characters' => 200001],
			['strategy' => 'semantic', 'max_tools' => 10, 'semantic_candidate_tools' => 9]
		] as $invalid) {
			try {
				AgentCapabilitySelectionConfig::fromArray($invalid);
				$this->fail('Invalid capability selection configuration accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
