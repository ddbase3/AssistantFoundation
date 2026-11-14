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

use Base3\AssistantFoundation\Dto\AgentAction;
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
