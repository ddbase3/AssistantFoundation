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

use Base3\AssistantFoundation\Dto\AgentActionDecision;
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
