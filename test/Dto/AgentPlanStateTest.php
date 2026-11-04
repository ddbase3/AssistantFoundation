<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentPlanState;
use PHPUnit\Framework\TestCase;

final class AgentPlanStateTest extends TestCase {

	public function testPlanPreservesCurrentStepAndStateDetails(): void {
		$state = new AgentPlanState([['task' => 'analyze'], ['task' => 'answer']], 1, 'active', ['source' => 'agent']);
		$this->assertSame([['task' => 'analyze'], ['task' => 'answer']], $state->getSteps());
		$this->assertSame(1, $state->getCurrentStepIndex());
		$this->assertSame('active', $state->getStatus());
		$this->assertSame(['source' => 'agent'], $state->getMetadata());
		$this->assertSame(1, $state->toArray()['current_step_index']);
		$this->assertNull((new AgentPlanState())->getCurrentStepIndex());
	}

	public function testNegativePlanStepIndexIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentPlanState([], -1);
	}
}
