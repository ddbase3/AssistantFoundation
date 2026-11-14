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
