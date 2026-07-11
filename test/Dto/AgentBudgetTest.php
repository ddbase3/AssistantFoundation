<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentBudget;
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
