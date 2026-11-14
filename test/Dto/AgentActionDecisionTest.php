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

final class AgentActionDecisionTest extends TestCase {

	public function testAllowDecisionIsReportedAsAllowed(): void {
		$decision = AgentActionDecision::allow('call-1', 'Allowed by test policy.');

		$this->assertTrue($decision->isAllowed());
		$this->assertSame(AgentActionDecision::DECISION_ALLOW, $decision->getDecision());
		$this->assertSame('call-1', $decision->getActionId());
	}

	public function testInvalidDecisionIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentActionDecision('call-1', 'unknown');
	}
}
