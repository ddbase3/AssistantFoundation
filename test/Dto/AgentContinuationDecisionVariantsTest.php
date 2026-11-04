<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentContinuationDecision;
use PHPUnit\Framework\TestCase;

final class AgentContinuationDecisionVariantsTest extends TestCase {

	public function testEachDecisionHasUniqueContinuationAndTerminalMeaning(): void {
		foreach (AgentContinuationDecision::getAllowedDecisions() as $status) {
			$decision = new AgentContinuationDecision(1, $status, 'reason', 'source', 0.0, ['model' => 'test']);
			$this->assertSame($status === AgentContinuationDecision::DECISION_CONTINUE, $decision->shouldContinue());
			$this->assertSame($status === AgentContinuationDecision::DECISION_ANSWER, $decision->shouldAnswer());
			$this->assertSame($status === AgentContinuationDecision::DECISION_CLARIFY, $decision->shouldClarify());
			$this->assertSame($status !== AgentContinuationDecision::DECISION_CONTINUE, $decision->isTerminal());
			$this->assertSame('reason', $decision->getReason());
			$this->assertSame('source', $decision->getSource());
			$this->assertSame(['model' => 'test'], $decision->getMetadata());
			$this->assertSame($status, $decision->getDecision());
		}
	}
}
