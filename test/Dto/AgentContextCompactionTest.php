<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentContextCompaction;
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
