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

use Base3\AssistantFoundation\Dto\AgentToolCacheRecord;
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
