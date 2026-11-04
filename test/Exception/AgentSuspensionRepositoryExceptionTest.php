<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Exception;

use AssistantFoundation\Exception\AgentSuspensionRepositoryException;
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
