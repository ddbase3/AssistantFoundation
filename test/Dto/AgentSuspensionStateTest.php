<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentExecutionStatus;
use AssistantFoundation\Dto\AgentInteractionResponse;
use AssistantFoundation\Dto\AgentSuspensionResolution;
use AssistantFoundation\Dto\AgentSuspensionState;
use PHPUnit\Framework\TestCase;

final class AgentSuspensionStateTest extends TestCase {

	public function testActiveAwaitingStateExposesResumeInformation(): void {
		$state = new AgentSuspensionState(true, AgentExecutionStatus::AWAITING_APPROVAL, [['id' => 'r']], 'handle', 'created', 'expires', id: 'susp-1');
		$this->assertTrue($state->isActive());
		$this->assertTrue($state->isSuspended());
		$this->assertSame(AgentExecutionStatus::AWAITING_APPROVAL, $state->getStatus());
		$this->assertSame([['id' => 'r']], $state->getInteractionRequests());
		$this->assertSame('handle', $state->getResumeHandle());
		$this->assertSame('created', $state->getCreatedAt());
		$this->assertSame('expires', $state->getExpiresAt());
		$this->assertSame('susp-1', $state->getId());
		$this->assertSame(true, $state->toArray()['suspended']);
	}

	public function testResolvedStateRetainsTerminalResolutionWithoutPretendingSuspension(): void {
		$resolution = new AgentSuspensionResolution([new AgentInteractionResponse('r', 'approve')]);
		$state = new AgentSuspensionState(false, AgentExecutionStatus::COMPLETED, lifecycle: AgentSuspensionState::LIFECYCLE_RESOLVED, resolution: $resolution);
		$this->assertFalse($state->isSuspended());
		$this->assertFalse($state->isActive());
		$this->assertSame($resolution, $state->getResolution());
		$this->assertSame('approved', $state->toArray()['resolution']['outcome']);
		$this->assertContains(AgentSuspensionState::LIFECYCLE_EXPIRED, AgentSuspensionState::getAllowedLifecycles());
	}

	public function testImpossibleSuspensionCombinationsAreRejected(): void {
		foreach ([
			['bad-status', false, 'active'],
			['completed', true, 'active'],
			['awaiting_input', true, 'resolved'],
			['running', false, 'not-a-lifecycle']
		] as [$status, $suspended, $lifecycle]) {
			try {
				new AgentSuspensionState($suspended, $status, lifecycle: $lifecycle);
				$this->fail('Invalid suspension state accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
