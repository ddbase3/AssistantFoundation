<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentAction;
use PHPUnit\Framework\TestCase;

final class AgentActionTest extends TestCase {

	public function testActionArrayRoundTripPreservesToolArgumentsAndProvenance(): void {
		$action = new AgentAction('call-8', AgentAction::TYPE_TOOL_CALL, 'remove_entry', ['entry_id' => 3], ['origin' => 'ui']);
		$this->assertSame('call-8', $action->getId());
		$this->assertSame(AgentAction::TYPE_TOOL_CALL, $action->getType());
		$this->assertSame('remove_entry', $action->getName());
		$this->assertSame(['entry_id' => 3], $action->getInput());
		$this->assertSame(['origin' => 'ui'], $action->getMetadata());
		$this->assertSame($action->toArray(), AgentAction::fromArray($action->toArray())->toArray());
	}

	public function testMissingOptionalPropertiesUseEmptyContainers(): void {
		$action = AgentAction::fromArray(['id' => 'call', 'type' => 'custom', 'name' => 'look', 'input' => 'invalid', 'metadata' => 'invalid']);
		$this->assertSame([], $action->getInput());
		$this->assertSame([], $action->getMetadata());
	}
}
