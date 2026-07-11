<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentMutationCommitDecision;
use PHPUnit\Framework\TestCase;

final class AgentMutationCommitDecisionTest extends TestCase {

	public function testAllowedDecisionHasStableRepresentation(): void {
		$decision = AgentMutationCommitDecision::allow(
			'Authorization and version are current.',
			['checked' => true]
		);

		$this->assertTrue($decision->isAllowed());
		$this->assertSame(AgentMutationCommitDecision::CODE_ALLOWED, $decision->getCode());
		$this->assertTrue($decision->toArray()['metadata']['checked']);
	}

	public function testDeniedDecisionRoundTrips(): void {
		$decision = AgentMutationCommitDecision::deny(
			AgentMutationCommitDecision::CODE_STALE,
			'Resource version changed.',
			['current' => 'v2']
		);
		$restored = AgentMutationCommitDecision::fromArray($decision->toArray());

		$this->assertFalse($restored->isAllowed());
		$this->assertSame(AgentMutationCommitDecision::CODE_STALE, $restored->getCode());
		$this->assertSame('v2', $restored->getMetadata()['current']);
	}
}
