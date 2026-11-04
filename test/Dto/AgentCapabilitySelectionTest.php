<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentCapability;
use AssistantFoundation\Dto\AgentCapabilitySelection;
use AssistantFoundation\Dto\AiResultMetadata;
use PHPUnit\Framework\TestCase;

final class AgentCapabilitySelectionTest extends TestCase {

	public function testSelectedCapabilitiesExposeModelFacingToolSubsetAndEvidence(): void {
		$definition = ['type' => 'function', 'function' => ['name' => 'lookup']];
		$capability = new AgentCapability('lookup', 'Lookup', 'Find', 'read', ['crm'], 5, $definition);
		$metadata = new AiResultMetadata('chat', 'provider', 'model');
		$selection = new AgentCapabilitySelection(2, 'semantic', 12, 8, [$capability], ['lookup' => 0.94], ['lookup' => ['similarity']], $metadata);
		$this->assertSame(2, $selection->getIteration());
		$this->assertSame('semantic', $selection->getStrategy());
		$this->assertSame(12, $selection->getCatalogSize());
		$this->assertSame(8, $selection->getEligibleSize());
		$this->assertSame([$capability], $selection->getCapabilities());
		$this->assertSame(['lookup'], $selection->getToolNames());
		$this->assertTrue($selection->has('lookup'));
		$this->assertFalse($selection->has('missing'));
		$this->assertSame([$definition], $selection->getToolDefinitions());
		$this->assertSame(['lookup' => 0.94], $selection->getScores());
		$this->assertSame(['lookup' => ['similarity']], $selection->getReasons());
		$this->assertSame($metadata, $selection->getModelMetadata());
		$this->assertSame($metadata->toArray(), $selection->toArray()['model_metadata']);
		$this->assertSame(1, $selection->toArray()['selected_count']);
	}

	public function testEmptySelectionOmitsModelMetadata(): void {
		$selection = new AgentCapabilitySelection(0, 'all', 0, 0, []);
		$this->assertFalse($selection->has('lookup'));
		$this->assertSame([], $selection->getToolDefinitions());
		$this->assertArrayNotHasKey('model_metadata', $selection->toArray());
	}

	public function testForeignAndDuplicateCapabilitiesAreRejected(): void {
		$capability = new AgentCapability('status', 'Status', '', '', [], 0, ['function' => ['name' => 'status']]);
		foreach ([[$capability, $capability], ['not-a-capability']] as $list) {
			try {
				new AgentCapabilitySelection(0, 'all', 1, 1, $list);
				$this->fail('Invalid selection accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
