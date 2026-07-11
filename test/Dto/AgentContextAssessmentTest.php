<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentContextAssessment;
use AssistantFoundation\Dto\AiUsage;
use PHPUnit\Framework\TestCase;

final class AgentContextAssessmentTest extends TestCase {

	public function testAssessmentPreservesExactMetricsAndReportedUsage(): void {
		$assessment = new AgentContextAssessment(
			iteration: 2,
			messageCount: 3,
			messageBytes: 120,
			toolResultCount: 2,
			successfulToolResultCount: 1,
			failedToolResultCount: 1,
			toolResultBytes: 80,
			usage: new AiUsage(inputTokens: 10, outputTokens: 4, totalTokens: 14),
			metadata: ['phase' => 'after-tools']
		);

		$this->assertSame(2, $assessment->getIteration());
		$this->assertSame(3, $assessment->getMessageCount());
		$this->assertSame(120, $assessment->getMessageBytes());
		$this->assertSame(2, $assessment->getToolResultCount());
		$this->assertSame(1, $assessment->getSuccessfulToolResultCount());
		$this->assertSame(1, $assessment->getFailedToolResultCount());
		$this->assertSame(80, $assessment->getToolResultBytes());
		$this->assertSame(200, $assessment->getTotalMeasuredBytes());
		$this->assertSame(14, $assessment->getUsage()->getTotalTokens());
		$this->assertSame('after-tools', $assessment->getMetadata()['phase']);
		$this->assertSame(200, $assessment->toArray()['total_measured_bytes']);
	}
}
