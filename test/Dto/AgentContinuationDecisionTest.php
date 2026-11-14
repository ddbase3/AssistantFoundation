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

use Base3\AssistantFoundation\Dto\AgentContinuationDecision;
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
