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

final class AgentBudgetTest extends TestCase {

	public function testBudgetParsesRunConfigurationAndGenericMetricLimits(): void {
		$budget = AgentBudget::fromArray([
			'max_total_tokens' => 5000,
			'max_ai_operations' => '8',
			'max_tool_calls' => 12,
			'max_elapsed_ms' => 30000,
			'metric_limits' => [
				'output_images' => 4,
				'cost_usd' => 1.5
			],
			'require_usage_reporting' => true
		]);

		$this->assertSame(5000, $budget->getMaxTotalTokens());
		$this->assertSame(8, $budget->getMaxAiOperations());
		$this->assertSame(12, $budget->getMaxToolCalls());
		$this->assertSame(30000.0, $budget->getMaxElapsedMs());
		$this->assertSame(4, $budget->getMetricLimits()['output_images']);
		$this->assertSame(1.5, $budget->getMetricLimits()['cost_usd']);
		$this->assertTrue($budget->requiresUsageReporting());
		$this->assertFalse($budget->isUnlimited());
	}

	public function testZeroValuesMeanUnlimited(): void {
		$budget = AgentBudget::fromArray([
			'max_total_tokens' => 0,
			'max_tool_calls' => '0'
		]);

		$this->assertTrue($budget->isUnlimited());
	}
}
