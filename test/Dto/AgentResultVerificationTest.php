<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentResultVerification;
use PHPUnit\Framework\TestCase;

final class AgentResultVerificationTest extends TestCase {

	public function testVerifiedResultExposesStableRepresentation(): void {
		$result = new AgentResultVerification(
			iteration: 2,
			verifier: 'structural',
			verdict: AgentResultVerification::VERDICT_VERIFIED,
			summary: 'Result contract verified.',
			metadata: ['count' => 1]
		);

		$this->assertTrue($result->isVerified());
		$this->assertSame(2, $result->getIteration());
		$this->assertSame('structural', $result->getVerifier());
		$this->assertSame('verified', $result->toArray()['verdict']);
	}

	public function testInvalidVerdictIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentResultVerification(1, 'test', 'unknown', 'Invalid.');
	}
}
