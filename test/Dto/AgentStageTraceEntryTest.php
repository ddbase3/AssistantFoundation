<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentStageTraceEntry;
use PHPUnit\Framework\TestCase;

final class AgentStageTraceEntryTest extends TestCase {

	public function testTraceEntryKeepsStageMetadata(): void {
		$entry = new AgentStageTraceEntry(
			stageId: 'context-assessment',
			stageName: 'context-assessment',
			implementationName: 'agentcontextassessmentstage',
			description: 'Measures context.',
			aiUsage: 'none',
			iteration: 2,
			phaseBefore: 'after-tools',
			phaseAfter: 'after-tools',
			status: AgentStageTraceEntry::STATUS_COMPLETED,
			durationMs: 1.25
		);

		$this->assertSame('context-assessment', $entry->getStageId());
		$this->assertSame('none', $entry->getAiUsage());
		$this->assertSame(AgentStageTraceEntry::STATUS_COMPLETED, $entry->getStatus());
		$this->assertSame(1.25, $entry->getDurationMs());
	}
}
