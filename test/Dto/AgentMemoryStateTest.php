<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentMemoryState;
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
