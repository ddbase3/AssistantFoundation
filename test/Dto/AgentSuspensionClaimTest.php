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

use Base3\AssistantFoundation\Dto\AgentSuspension;
use Base3\AssistantFoundation\Dto\AgentSuspensionClaim;
use Base3\AssistantFoundation\Dto\AgentExecutionStatus;
use Base3\AssistantFoundation\Dto\AgentAction;
use Base3\AssistantFoundation\Dto\AgentInteractionRequest;
use PHPUnit\Framework\TestCase;

final class AgentSuspensionClaimTest extends TestCase {

	public function testClaimRetainsServerOwnedSuspensionAndLeaseTokens(): void {
		$suspension = new AgentSuspension('susp-1', AgentExecutionStatus::AWAITING_INPUT, [new AgentInteractionRequest('req', 'clarification', new AgentAction('call', 'tool_call', 'lookup'), 'fp', 'Question', 'Which entry?')], [], '2026-10-03T00:00:00Z');
		$claim = new AgentSuspensionClaim('opaque', 'lease-secret', $suspension);
		$this->assertSame('opaque', $claim->getResumeHandle());
		$this->assertSame('lease-secret', $claim->getClaimToken());
		$this->assertSame($suspension, $claim->getSuspension());
	}

	public function testEmptyHandleAndClaimTokensAreRejected(): void {
		$suspension = new AgentSuspension('susp-1', AgentExecutionStatus::AWAITING_INPUT, [new AgentInteractionRequest('req', 'clarification', new AgentAction('call', 'tool_call', 'lookup'), 'fp', 'Question', 'Which entry?')], [], '2026-10-03T00:00:00Z');
		foreach ([['', 'token'], ['handle', ' ']] as [$handle, $token]) {
			try {
				new AgentSuspensionClaim($handle, $token, $suspension);
				$this->fail('Claim without lease token accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
