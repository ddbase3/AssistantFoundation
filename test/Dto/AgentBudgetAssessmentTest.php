<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentBudget;
use AssistantFoundation\Dto\AgentBudgetAssessment;
use AssistantFoundation\Dto\AiUsage;
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
