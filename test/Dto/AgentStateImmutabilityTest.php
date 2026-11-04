<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentState;
use AssistantFoundation\Dto\AgentTaskState;
use AssistantFoundation\Dto\AgentPlanState;
use AssistantFoundation\Dto\AgentKnowledgeState;
use AssistantFoundation\Dto\AgentExecutionState;
use AssistantFoundation\Dto\AgentMemoryState;
use AssistantFoundation\Dto\AgentContextWindowState;
use AssistantFoundation\Dto\AgentBudgetState;
use AssistantFoundation\Dto\AgentSuspensionState;
use AssistantFoundation\Dto\AgentResultState;
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
