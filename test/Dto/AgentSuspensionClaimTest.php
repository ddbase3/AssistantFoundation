<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentSuspension;
use AssistantFoundation\Dto\AgentSuspensionClaim;
use AssistantFoundation\Dto\AgentExecutionStatus;
use AssistantFoundation\Dto\AgentAction;
use AssistantFoundation\Dto\AgentInteractionRequest;
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
