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

use Base3\AssistantFoundation\Dto\AgentPlanState;
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
