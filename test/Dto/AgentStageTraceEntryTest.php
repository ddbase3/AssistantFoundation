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

use Base3\AssistantFoundation\Dto\AgentStageTraceEntry;
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
