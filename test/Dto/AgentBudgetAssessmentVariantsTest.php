<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentBudget;
use AssistantFoundation\Dto\AgentBudgetAssessment;
use AssistantFoundation\Dto\AiUsage;
use PHPUnit\Framework\TestCase;

final class AgentBudgetAssessmentVariantsTest extends TestCase {

	public function testExceededLimitAlwaysBlocksContinuationRegardlessOfStrictness(): void {
		$budget = AgentBudget::unlimited();
		$usage = new AiUsage(50, 10, 60);
		$assessment = new AgentBudgetAssessment(2, $budget, $usage, 3, 2, 100.0, ['total_tokens' => ['limit' => 50]], [], ['stage' => 'tool']);
		$this->assertTrue($assessment->hasExceededLimits());
		$this->assertFalse($assessment->hasUnknownLimits());
		$this->assertFalse($assessment->canContinue());
		$this->assertSame(2, $assessment->getIteration());
		$this->assertSame($budget, $assessment->getBudget());
		$this->assertSame($usage, $assessment->getUsage());
		$this->assertSame(3, $assessment->getAiOperationCount());
		$this->assertSame(2, $assessment->getToolCallCount());
		$this->assertSame(100.0, $assessment->getElapsedMs());
		$this->assertSame(['total_tokens' => ['limit' => 50]], $assessment->getExceededLimits());
		$this->assertSame(['stage' => 'tool'], $assessment->getMetadata());
		$this->assertSame(false, $assessment->toArray()['can_continue']);
	}

	public function testUnreportedUsageBlocksOnlyWhenExplicitlyRequired(): void {
		$usage = AiUsage::none();
		$unknown = ['tokens' => ['reason' => 'not_reported']];
		$permissive = new AgentBudgetAssessment(1, AgentBudget::unlimited(), $usage, 0, 0, 1.0, unknownLimits: $unknown);
		$this->assertTrue($permissive->hasUnknownLimits());
		$this->assertTrue($permissive->canContinue());
		$strict = new AgentBudgetAssessment(1, new AgentBudget(requireUsageReporting: true), $usage, 0, 0, 1.0, unknownLimits: $unknown);
		$this->assertFalse($strict->canContinue());
		$this->assertSame($unknown, $strict->getUnknownLimits());
		$this->assertTrue((new AgentBudgetAssessment(1, AgentBudget::unlimited(), $usage, 0, 0, 1.0))->canContinue());
	}
}
