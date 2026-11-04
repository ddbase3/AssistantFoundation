<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentContextProfileResult;
use AssistantFoundation\Dto\AgentInstructionBlock;
use PHPUnit\Framework\TestCase;

final class AgentContextProfileResultTest extends TestCase {

	public function testEmptyProfileCarriesNormalizedIdWithoutContext(): void {
		$result = AgentContextProfileResult::empty(' profile-id ');
		$this->assertSame('profile-id', $result->getProfileId());
		$this->assertSame([], $result->getBlocks());
		$this->assertSame([], $result->getWarnings());
		$this->assertSame([], $result->getDiagnostics());
	}

	public function testBlocksProvideDiagnosticDescriptorsWithoutLosingWarnings(): void {
		$block = new AgentInstructionBlock('safety', 'Do not modify without approval');
		$result = new AgentContextProfileResult('course', [$block], ['not available']);
		$this->assertSame([$block], $result->getBlocks());
		$this->assertSame(['not available'], $result->getWarnings());
		$this->assertSame([$block->toDiagnosticArray()], $result->getDiagnostics());
	}
}
