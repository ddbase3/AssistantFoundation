<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentResultVerification;
use PHPUnit\Framework\TestCase;

final class AgentResultVerificationVariantsTest extends TestCase {

	public function testFailedAndInconclusiveResultsDoNotClaimVerification(): void {
		foreach (AgentResultVerification::getAllowedVerdicts() as $status) {
			$result = new AgentResultVerification(3, 'schema', $status, 'Checked', [['code' => 'missing']], ['provider' => 'test']);
			$this->assertSame($status === AgentResultVerification::VERDICT_VERIFIED, $result->isVerified());
			$this->assertSame('Checked', $result->getSummary());
			$this->assertSame('schema', $result->getVerifier());
			$this->assertSame($status, $result->getVerdict());
			$this->assertSame([['code' => 'missing']], $result->getIssues());
			$this->assertSame(['provider' => 'test'], $result->getMetadata());
			$this->assertSame(3, $result->getIteration());
			$this->assertSame($status, $result->toArray()['verdict']);
		}
	}
}
