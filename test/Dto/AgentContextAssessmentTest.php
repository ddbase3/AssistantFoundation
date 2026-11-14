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

use Base3\AssistantFoundation\Dto\AgentContextAssessment;
use Base3\AssistantFoundation\Dto\AiUsage;
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
