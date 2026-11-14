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

use Base3\AssistantFoundation\Dto\AgentContextProfileResult;
use Base3\AssistantFoundation\Dto\AgentInstructionBlock;
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
