<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentExecutionStatus;
use PHPUnit\Framework\TestCase;

final class AgentExecutionStatusTest extends TestCase {

	public function testSuspensionIsLimitedToExplicitAwaitingStatuses(): void {
		$this->assertSame(7, count(AgentExecutionStatus::all()));
		foreach (AgentExecutionStatus::all() as $status) {
			$this->assertSame(in_array($status, [AgentExecutionStatus::AWAITING_APPROVAL, AgentExecutionStatus::AWAITING_INPUT], true), AgentExecutionStatus::isSuspended($status));
		}
		$this->assertFalse(AgentExecutionStatus::isSuspended('unknown'));
	}
}
