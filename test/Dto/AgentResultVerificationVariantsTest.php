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
