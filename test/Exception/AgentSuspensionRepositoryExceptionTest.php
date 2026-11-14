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

namespace Base3\AssistantFoundation\Test\Exception;

use Base3\AssistantFoundation\Exception\AgentSuspensionRepositoryException;
use PHPUnit\Framework\TestCase;

final class AgentSuspensionRepositoryExceptionTest extends TestCase {

	public function testRepositoryErrorsKeepDistinctReasonAndPreviousException(): void {
		$previous = new \RuntimeException('storage unavailable');
		foreach ([
			AgentSuspensionRepositoryException::REASON_INVALID_HANDLE,
			AgentSuspensionRepositoryException::REASON_NOT_FOUND,
			AgentSuspensionRepositoryException::REASON_ALREADY_CLAIMED,
			AgentSuspensionRepositoryException::REASON_ALREADY_CONSUMED,
			AgentSuspensionRepositoryException::REASON_INVALID_STATE,
			AgentSuspensionRepositoryException::REASON_UNAVAILABLE
		] as $reason) {
			$exception = new AgentSuspensionRepositoryException($reason, 'Unable to resume', $previous);
			$this->assertSame($reason, $exception->getReason());
			$this->assertSame('Unable to resume', $exception->getMessage());
			$this->assertSame($previous, $exception->getPrevious());
		}
	}
}
