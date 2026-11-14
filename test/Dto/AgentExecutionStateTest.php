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

use Base3\AssistantFoundation\Dto\AgentExecutionState;
use Base3\AssistantFoundation\Dto\AgentExecutionStatus;
use Base3\AssistantFoundation\Dto\AiUsage;
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
