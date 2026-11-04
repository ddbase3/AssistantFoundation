<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentToolCacheRecord;
use PHPUnit\Framework\TestCase;

final class AgentToolCacheRecordTest extends TestCase {

	public function testAllRecordedOutcomesPreserveIdentityAndReason(): void {
		foreach (AgentToolCacheRecord::getAllowedStatuses() as $status) {
			$record = new AgentToolCacheRecord(3, 'call-1', 'lookup', 'provider:lookup', $status, 'cache-key', 'turn', 90, 'reason', ['attempts' => 2]);
			$this->assertSame($status, $record->getStatus());
			$this->assertSame([
				'iteration' => 3, 'call_id' => 'call-1', 'tool' => 'lookup',
				'tool_identity' => 'provider:lookup', 'status' => $status,
				'cache_key' => 'cache-key', 'scope' => 'turn',
				'ttl_seconds' => 90, 'reason' => 'reason', 'metadata' => ['attempts' => 2]
			], $record->toArray());
		}
	}

	public function testUnknownOutcomeIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentToolCacheRecord(0, 'call', 'tool', 'id', 'not-supported');
	}
}
