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

use Base3\AssistantFoundation\Dto\AgentExecutionStatus;
use Base3\AssistantFoundation\Dto\AgentResult;
use Base3\AssistantFoundation\Dto\AgentResultState;
use Base3\AssistantFoundation\Dto\AgentState;
use PHPUnit\Framework\TestCase;

final class AgentResultTest extends TestCase {

	public function testAllStatusesAreDistinctFromFailureAndSuspension(): void {
		$state = AgentState::empty();
		foreach (AgentExecutionStatus::all() as $status) {
			$result = new AgentResult($status, $state, ['message' => 'done'], ['trace' => 1]);
			$this->assertSame($status === AgentExecutionStatus::COMPLETED, $result->isCompleted());
			$this->assertSame(AgentExecutionStatus::isSuspended($status), $result->isSuspended());
			$this->assertSame($status === AgentExecutionStatus::PARTIAL, $result->isPartial());
			$this->assertSame($status === AgentExecutionStatus::CANCELLED, $result->isCancelled());
			$this->assertSame(in_array($status, [AgentExecutionStatus::FAILED, AgentExecutionStatus::PARTIAL], true), $result->hasFailure());
			$this->assertSame(['message' => 'done'], $result->getOutput());
			$this->assertSame(['trace' => 1], $result->getMetadata());
			$this->assertSame($status, $result->toArray()['status']);
			$this->assertSame($state->toArray(), $result->toArray()['state']);
		}
	}

	public function testFailureInNestedStateCannotBecomeSuccessfulCompletion(): void {
		$state = AgentState::empty()->withResult(new AgentResultState(failureCode: 'not-authorized'));
		$result = new AgentResult(AgentExecutionStatus::COMPLETED, $state);
		$this->assertTrue($result->hasFailure());
		$this->assertSame($state, $result->getState());
	}

	public function testUnexpectedTerminalStatusIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentResult('unknown', AgentState::empty());
	}
}
