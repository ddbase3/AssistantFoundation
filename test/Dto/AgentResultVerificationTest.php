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

use Base3\AssistantFoundation\Dto\AgentResultVerification;
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
