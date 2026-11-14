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

use Base3\AssistantFoundation\Dto\AgentBudget;
use Base3\AssistantFoundation\Dto\AgentBudgetAssessment;
use Base3\AssistantFoundation\Dto\AiUsage;
use PHPUnit\Framework\TestCase;

final class AgentBudgetAssessmentTest extends TestCase {

	public function testStrictUnknownUsageBlocksContinuation(): void {
		$assessment = new AgentBudgetAssessment(
			iteration: 2,
			budget: new AgentBudget(maxTotalTokens: 100, requireUsageReporting: true),
			usage: AiUsage::none(),
			aiOperationCount: 1,
			toolCallCount: 0,
			elapsedMs: 15.0,
			unknownLimits: [
				'total_tokens' => ['limit' => 100, 'reason' => 'not_reported']
			]
		);

		$this->assertTrue($assessment->hasUnknownLimits());
		$this->assertFalse($assessment->canContinue());
		$this->assertFalse($assessment->toArray()['can_continue']);
	}
}
