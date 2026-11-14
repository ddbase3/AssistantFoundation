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
