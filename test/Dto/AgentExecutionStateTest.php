<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentExecutionState;
use AssistantFoundation\Dto\AgentExecutionStatus;
use AssistantFoundation\Dto\AiUsage;
use PHPUnit\Framework\TestCase;

final class AgentExecutionStateTest extends TestCase {

	public function testStateIncludesToolEvidenceAndNormalizesStructuredResults(): void {
		$usage = new AiUsage(inputTokens: 15);
		$state = new AgentExecutionState(
			status: AgentExecutionStatus::RUNNING, phase: 'execution', iteration: 3, maxIterations: 10, callIndex: 2,
			actions: ['raw'], actionDecisions: [['allow' => true]], executedToolCalls: ['tool'],
			modelResults: [$usage], stageTrace: [['stage' => 'x']], capabilitySelections: [],
			toolContractValidations: [], toolCacheRecords: [$usage], progressAssessments: [$usage]
		);
		$this->assertSame(3, $state->getIteration());
		$this->assertSame('execution', $state->getPhase());
		$this->assertSame(10, $state->getMaxIterations());
		$this->assertSame(2, $state->getCallIndex());
		$this->assertSame(['raw'], $state->getActions());
		$this->assertSame([['allow' => true]], $state->getActionDecisions());
		$this->assertSame(['tool'], $state->getExecutedToolCalls());
		$this->assertSame([['stage' => 'x']], $state->getStageTrace());
		$this->assertSame([], $state->getCapabilitySelections());
		$this->assertSame([], $state->getToolContractValidations());
		$this->assertSame($usage->toArray(), $state->toArray()['model_results'][0]);
		$this->assertSame($usage->toArray(), $state->toArray()['tool_cache_records'][0]);
		$this->assertSame($usage->toArray(), $state->toArray()['progress_assessments'][0]);
		$this->assertSame([$usage], $state->getModelResults());
	}

	public function testWithModelResultsPreservesAllOtherExecutionState(): void {
		$original = new AgentExecutionState(AgentExecutionStatus::COMPLETED, 'final', 2, 5, 1, actions: [['id' => 'a']]);
		$next = $original->withModelResults([['request' => 'r']]);
		$this->assertSame([], $original->getModelResults());
		$this->assertSame([['request' => 'r']], $next->getModelResults());
		$this->assertSame('completed', $next->getStatus());
		$this->assertSame($original->getActions(), $next->getActions());
		$this->assertSame($original->toArray()['call_index'], $next->toArray()['call_index']);
	}

	public function testInvalidStatusOrNegativeCountersAreRejected(): void {
		foreach ([
			['status' => 'nonexistent'], ['iteration' => -1],
			['maxIterations' => -1], ['callIndex' => -1]
		] as $invalid) {
			try {
				new AgentExecutionState(...$invalid);
				$this->fail('Invalid execution state accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
