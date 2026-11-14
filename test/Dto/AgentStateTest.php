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
use Base3\AssistantFoundation\Dto\AgentMemoryState;
use Base3\AssistantFoundation\Dto\AgentResult;
use Base3\AssistantFoundation\Dto\AgentResultState;
use Base3\AssistantFoundation\Dto\AgentState;
use Base3\AssistantFoundation\Dto\AgentTaskState;
use PHPUnit\Framework\TestCase;

final class AgentStateTest extends TestCase {

	public function testStableStateAndResultAreSerializable(): void {
		$state = AgentState::empty()
			->withTask(new AgentTaskState(
				id: 'turn-1',
				description: 'Inspect the current record.',
				input: ['mode' => 'chat'],
				metadata: ['node_id' => 'assistant']
			))
			->withMemory(new AgentMemoryState(
				conversationMemoryCount: 2,
				contextContributorCount: 1,
				contextContributions: [[
					'id' => 'prefs',
					'content_length' => 42
				]]
			))
			->withExecution(new AgentExecutionState(
				status: AgentExecutionStatus::COMPLETED,
				phase: 'complete',
				iteration: 2,
				maxIterations: 6,
				modelResults: [['provider' => 'test']]
			))
			->withResult(new AgentResultState(
				completed: true,
				finalOutputContent: 'Done.',
				finalResponseMode: 'complete'
			));

		$result = new AgentResult(
			status: AgentExecutionStatus::COMPLETED,
			state: $state,
			output: ['content' => 'Done.']
		);

		$this->assertTrue($result->isCompleted());
		$this->assertFalse($result->hasFailure());
		$this->assertSame('turn-1', $result->getState()->getTask()?->getId());
		$this->assertSame(2, $result->getState()->getExecution()?->getIteration());
		$this->assertSame(1, $result->getState()->getMemory()?->getContextContributorCount());
		$this->assertSame('Done.', $result->toArray()['output']['content']);
	}

	public function testResultStateCanAddVisibleOutputWithoutLosingFailureData(): void {
		$state = new AgentResultState(
			completed: false,
			finalResponseMode: 'partial',
			failureCode: 'loop_limit',
			failureMessage: 'The loop limit was reached.'
		);

		$updated = $state->withFinalOutput(
			content: 'Partial answer.',
			finalAssistantMessage: ['role' => 'assistant', 'content' => 'Partial answer.'],
			completed: false,
			finalResponseMode: 'partial'
		);

		$this->assertTrue($updated->hasFailure());
		$this->assertSame('partial', $updated->getFinalResponseMode());
		$this->assertSame('loop_limit', $updated->getFailureCode());
		$this->assertSame('Partial answer.', $updated->getFinalOutputContent());
	}

	public function testNegativeExecutionCountersAreRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentExecutionState(iteration: -1);
	}
}
