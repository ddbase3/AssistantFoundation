<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentContinuationDecision;
use PHPUnit\Framework\TestCase;

final class AgentContinuationDecisionTest extends TestCase {

	public function testAnswerDecisionExposesStableRepresentation(): void {
		$decision = new AgentContinuationDecision(
			iteration: 3,
			decision: AgentContinuationDecision::DECISION_ANSWER,
			reason: 'Evidence is sufficient.',
			source: 'semantic-verifier',
			confidence: 0.91,
			metadata: ['verdict' => 'verified']
		);

		$this->assertTrue($decision->shouldAnswer());
		$this->assertTrue($decision->isTerminal());
		$this->assertFalse($decision->shouldContinue());
		$this->assertSame(3, $decision->getIteration());
		$this->assertSame('answer', $decision->toArray()['decision']);
		$this->assertSame(0.91, $decision->getConfidence());
	}

	public function testInvalidDecisionIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentContinuationDecision(1, 'stop', 'Invalid.', 'test');
	}

	public function testInvalidConfidenceIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentContinuationDecision(
			1,
			AgentContinuationDecision::DECISION_CONTINUE,
			'Continue.',
			'test',
			1.1
		);
	}
}
