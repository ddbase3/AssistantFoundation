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

use Base3\AssistantFoundation\Dto\AgentStageResult;
use PHPUnit\Framework\TestCase;

final class AgentStageResultTest extends TestCase {

	public function testNoneCreatesEmptyResult(): void {
		$result = AgentStageResult::none();

		$this->assertTrue($result->isEmpty());
		$this->assertSame([], $result->getPatch());
		$this->assertSame([], $result->getMetadata());
	}

	public function testPatchPreservesContextValues(): void {
		$patch = [
			'agent.messages' => [['role' => 'tool', 'content' => 'result']],
			'agent.iteration' => 2,
		];

		$metadata = ['budget' => ['can_continue' => true]];
		$result = AgentStageResult::patch($patch, $metadata);

		$this->assertFalse($result->isEmpty());
		$this->assertSame($patch, $result->getPatch());
		$this->assertSame($metadata, $result->getMetadata());
	}
}
