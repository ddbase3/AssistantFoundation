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
use PHPUnit\Framework\TestCase;

final class AgentBudgetEdgeCasesTest extends TestCase {

	public function testEachExplicitLimitAndAliasesArePreservedAcrossSerialization(): void {
		$budget = AgentBudget::fromArray([
			'maxInputTokens' => '12', 'maxOutputTokens' => '24', 'maxTotalTokens' => 36,
			'maxAiOperations' => 4, 'maxToolCalls' => 3,
			'maxElapsedMs' => '2.5', 'metricLimits' => ['seconds' => '15', 'price' => '1.75'],
			'requireUsageReporting' => 'YeS'
		]);
		$this->assertSame(12, $budget->getMaxInputTokens());
		$this->assertSame(24, $budget->getMaxOutputTokens());
		$this->assertSame(36, $budget->getMaxTotalTokens());
		$this->assertSame(4, $budget->getMaxAiOperations());
		$this->assertSame(3, $budget->getMaxToolCalls());
		$this->assertSame(2.5, $budget->getMaxElapsedMs());
		$this->assertSame(['seconds' => 15, 'price' => 1.75], $budget->getMetricLimits());
		$this->assertTrue($budget->requiresUsageReporting());
		$this->assertFalse($budget->isUnlimited());
		$this->assertSame($budget->toArray(), AgentBudget::fromArray($budget->toArray())->toArray());
	}

	public function testZeroLimitsAreUnlimitedAndNumericZeroMetricsAreDropped(): void {
		$budget = AgentBudget::fromArray(['maxInputTokens' => '0', 'maxElapsedMs' => 0, 'metricLimits' => ['calls' => 0, 'price' => '0']]);
		$this->assertTrue($budget->isUnlimited());
		$this->assertSame([], $budget->getMetricLimits());
		$this->assertFalse($budget->requiresUsageReporting());
		$this->assertTrue(AgentBudget::unlimited()->isUnlimited());
	}

	public function testInvalidLimitsMetricsAndBooleanInputsAreRejected(): void {
		foreach ([
			['maxInputTokens' => -1], ['maxInputTokens' => 1.5], ['maxOutputTokens' => true],
			['maxTotalTokens' => 'abc'], ['maxAiOperations' => '3.3'],
			['maxToolCalls' => -1], ['maxElapsedMs' => -1], ['maxElapsedMs' => 'bad'],
			['metricLimits' => 'bad'], ['metricLimits' => ['amount' => -1]],
			['metricLimits' => [' ' => 2]], ['metricLimits' => [2 => 2]],
			['metricLimits' => ['bad' => []]], ['metricLimits' => ['bad' => 'abc']],
			['requireUsageReporting' => 'sometimes']
		] as $bad) {
			try {
				AgentBudget::fromArray($bad);
				$this->fail('Invalid run budget accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}

	public function testConstructorRejectsZeroLimitsWithoutNormalization(): void {
		foreach ([
			['maxInputTokens' => 0], ['maxOutputTokens' => 0], ['maxTotalTokens' => 0],
			['maxAiOperations' => 0], ['maxToolCalls' => 0],
			['maxElapsedMs' => 0.0], ['metricLimits' => ['cost' => 0]]
		] as $bad) {
			try {
				new AgentBudget(...$bad);
				$this->fail('Direct constructor accepted invalid budget.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
