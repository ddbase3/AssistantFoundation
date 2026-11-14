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
