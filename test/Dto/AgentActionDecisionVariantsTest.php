<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentActionDecision;
use PHPUnit\Framework\TestCase;

final class AgentActionDecisionVariantsTest extends TestCase {

	public function testAllPolicyOutcomeFactoriesPreserveReasonAndDoNotAllowMutationImplicitly(): void {
		$decisions = [
			AgentActionDecision::allow('a', 'permitted'),
			AgentActionDecision::deny('a', 'forbidden'),
			AgentActionDecision::requireApproval('a', 'approval'),
			AgentActionDecision::requireDryRun('a', 'dry-run'),
			AgentActionDecision::requireClarification('a', 'missing input')
		];
		$this->assertCount(count(AgentActionDecision::getAllowedDecisions()), $decisions);
		foreach ($decisions as $decision) {
			$this->assertSame('a', $decision->getActionId());
			$this->assertSame($decision->getDecision() === AgentActionDecision::DECISION_ALLOW, $decision->isAllowed());
			$this->assertNotSame('', $decision->getReason());
			$this->assertSame($decision->toArray(), AgentActionDecision::fromArray($decision->toArray())->toArray());
		}
	}

	public function testMalformedMetadataDoesNotBecomeActionPolicyData(): void {
		$decision = AgentActionDecision::fromArray(['action_id' => ' a ', 'decision' => 'deny', 'reason' => ' no ', 'metadata' => 'bad']);
		$this->assertSame('a', $decision->getActionId());
		$this->assertSame('no', $decision->getReason());
		$this->assertSame([], $decision->getMetadata());
		$this->assertFalse($decision->isAllowed());
	}
}
