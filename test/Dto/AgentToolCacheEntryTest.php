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

use Base3\AssistantFoundation\Dto\AgentToolCacheEntry;
use PHPUnit\Framework\TestCase;

final class AgentToolCacheEntryTest extends TestCase {

	public function testSerializedCacheEntryPreservesProvenanceAndArbitraryOutputs(): void {
		$payload = [
			'tool_identity' => 'provider:lookup', 'tool' => 'lookup',
			'arguments_hash' => 'sha256:abc', 'scope' => 'chatbot:one',
			'output' => ['ok' => false, 'items' => [1, 2]],
			'created_at' => '2026-10-01T12:00:00Z', 'expires_at' => '2026-10-01T12:01:00Z',
			'metadata' => ['source' => 'cache']
		];
		$entry = AgentToolCacheEntry::fromArray($payload);
		$this->assertSame($payload, $entry->toArray());
		$this->assertSame('provider:lookup', $entry->getToolIdentity());
		$this->assertSame('lookup', $entry->getToolName());
		$this->assertSame('sha256:abc', $entry->getArgumentsHash());
		$this->assertSame('chatbot:one', $entry->getScope());
		$this->assertSame($payload['output'], $entry->getOutput());
		$this->assertSame($payload['created_at'], $entry->getCreatedAt());
		$this->assertSame($payload['expires_at'], $entry->getExpiresAt());
		$this->assertSame(['source' => 'cache'], $entry->getMetadata());
	}

	public function testMissingMetadataBecomesEmptyAndNullOutputIsPreserved(): void {
		$entry = AgentToolCacheEntry::fromArray(['tool_identity' => 'identity', 'tool' => 'status', 'metadata' => 'invalid']);
		$this->assertNull($entry->getOutput());
		$this->assertSame([], $entry->getMetadata());
	}

	public function testMissingToolIdentityOrNameIsRejected(): void {
		foreach ([[], ['tool_identity' => 'identity'], ['tool' => 'status']] as $entry) {
			try {
				AgentToolCacheEntry::fromArray($entry);
				$this->fail('Cache entry without identity accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
