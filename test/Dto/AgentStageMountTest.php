<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Api\IAgentStage;
use AssistantFoundation\Dto\AgentStageMount;
use AssistantFoundation\Dto\AgentStageSlot;
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
