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

use Base3\AssistantFoundation\Dto\AgentState;
use Base3\AssistantFoundation\Dto\AgentTaskState;
use Base3\AssistantFoundation\Dto\AgentPlanState;
use Base3\AssistantFoundation\Dto\AgentKnowledgeState;
use Base3\AssistantFoundation\Dto\AgentExecutionState;
use Base3\AssistantFoundation\Dto\AgentMemoryState;
use Base3\AssistantFoundation\Dto\AgentContextWindowState;
use Base3\AssistantFoundation\Dto\AgentBudgetState;
use Base3\AssistantFoundation\Dto\AgentSuspensionState;
use Base3\AssistantFoundation\Dto\AgentResultState;
use PHPUnit\Framework\TestCase;

final class AgentStateImmutabilityTest extends TestCase {

	public function testAllStateSectionsCanBeReplacedIndependentlyWithoutMutatingInitialState(): void {
		$empty = AgentState::empty();
		$task = new AgentTaskState(id: 'task');
		$plan = new AgentPlanState(steps: ['one']);
		$knowledge = new AgentKnowledgeState(knowledge: ['fact']);
		$execution = new AgentExecutionState(iteration: 2);
		$memory = new AgentMemoryState(conversationMemoryCount: 1);
		$contextWindow = new AgentContextWindowState(assessments: ['assessment']);
		$budget = new AgentBudgetState();
		$suspension = new AgentSuspensionState();
		$result = new AgentResultState(completed: true);
		$filled = $empty->withTask($task)->withPlan($plan)->withKnowledge($knowledge)
			->withExecution($execution)->withMemory($memory)->withContextWindow($contextWindow)
			->withBudget($budget)->withSuspension($suspension)->withResult($result);
		$this->assertNull($empty->getTask());
		$this->assertSame($task, $filled->getTask());
		$this->assertSame($plan, $filled->getPlan());
		$this->assertSame($knowledge, $filled->getKnowledge());
		$this->assertSame($execution, $filled->getExecution());
		$this->assertSame($memory, $filled->getMemory());
		$this->assertSame($contextWindow, $filled->getContextWindow());
		$this->assertSame($budget, $filled->getBudget());
		$this->assertSame($suspension, $filled->getSuspension());
		$this->assertSame($result, $filled->getResult());
		$this->assertSame($execution->toArray(), $filled->toArray()['execution']);
		$this->assertSame($budget->toArray(), $filled->toArray()['budget']);
		$this->assertSame($empty->toArray(), $filled->withTask(null)->withPlan(null)->withKnowledge(null)
			->withExecution(null)->withMemory(null)->withContextWindow(null)->withBudget(null)
			->withSuspension(null)->withResult(null)->toArray());
	}
}
