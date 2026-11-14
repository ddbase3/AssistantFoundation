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

use Base3\AssistantFoundation\Api\IAgentStage;
use Base3\AssistantFoundation\Dto\AgentStageMount;
use Base3\AssistantFoundation\Dto\AgentStageSlot;
use PHPUnit\Framework\TestCase;

final class AgentStageMountTest extends TestCase {

	public function testMountPreservesInjectedStageOrderingAndCanonicalSlot(): void {
		$stage = $this->createStub(IAgentStage::class);
		$mount = new AgentStageMount(' ' . AgentStageSlot::AFTER_TOOL_CALL . ' ', $stage, 18);
		$this->assertSame(AgentStageSlot::AFTER_TOOL_CALL, $mount->getSlot());
		$this->assertSame($stage, $mount->getStage());
		$this->assertSame(18, $mount->getOrder());
	}

	public function testMountRejectsUnregisteredSlot(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentStageMount('wrong', $this->createStub(IAgentStage::class));
	}
}
