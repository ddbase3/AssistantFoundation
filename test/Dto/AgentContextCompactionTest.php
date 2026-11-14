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

use Base3\AssistantFoundation\Dto\AgentContextCompaction;
use PHPUnit\Framework\TestCase;

final class AgentContextCompactionTest extends TestCase {

	public function testCompactionRecordIsSerializable(): void {
		$compaction = new AgentContextCompaction(
			iteration: 1,
			callId: 'call-1',
			toolName: 'lookup',
			applied: true,
			originalBytes: 20000,
			compactedBytes: 1200,
			inputTruncated: false,
			modelMetadata: ['model' => 'test']
		);

		$this->assertTrue($compaction->wasApplied());
		$this->assertSame(20000, $compaction->getOriginalBytes());
		$this->assertSame('lookup', $compaction->toArray()['tool']);
	}
}
