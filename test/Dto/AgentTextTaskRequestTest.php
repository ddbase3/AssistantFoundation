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

use Base3\AssistantFoundation\Dto\AgentTextTaskRequest;
use PHPUnit\Framework\TestCase;

final class AgentTextTaskRequestTest extends TestCase {

	public function testFlagsRemainExplicit(): void {
		$request = new AgentTextTaskRequest(
			['agent_runtime' => 'missionbay'],
			'opening-message',
			'Write a greeting.',
			'Create the greeting.',
			['reference' => '/category/1'],
			true,
			true
		);

		$this->assertTrue($request->shouldIncludeContextProfile());
		$this->assertTrue($request->shouldIncludeToolProfile());
		$this->assertSame('opening-message', $request->getTaskName());
	}
}
