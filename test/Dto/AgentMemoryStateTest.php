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

use Base3\AssistantFoundation\Dto\AgentMemoryState;
use PHPUnit\Framework\TestCase;

final class AgentMemoryStateTest extends TestCase {

	public function testMemoryStatisticsPreserveContributorEvidence(): void {
		$state = new AgentMemoryState(10, 2, [['source' => 'conversation']], ['retained' => true]);
		$this->assertSame(10, $state->getConversationMemoryCount());
		$this->assertSame(2, $state->getContextContributorCount());
		$this->assertSame([['source' => 'conversation']], $state->getContextContributions());
		$this->assertSame(['retained' => true], $state->getMetadata());
		$this->assertSame(10, $state->toArray()['conversation_memory_count']);
	}

	public function testNegativeMemoryAndContributorCountersAreRejected(): void {
		foreach ([[-1, 0], [0, -1]] as [$memoryCount, $contributorCount]) {
			try {
				new AgentMemoryState($memoryCount, $contributorCount);
				$this->fail('Negative memory count accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
