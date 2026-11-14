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

use Base3\AssistantFoundation\Dto\AgentToolResult;
use PHPUnit\Framework\TestCase;

final class AgentToolResultTest extends TestCase {

	public function testSuccessPreservesToolOutputAndMetadata(): void {
		$result = AgentToolResult::success(
			'call-1',
			'lookup',
			['query' => 'BASE3'],
			['found' => true],
			['iteration' => 1]
		);

		$this->assertTrue($result->isSuccess());
		$this->assertSame(AgentToolResult::STATUS_SUCCESS, $result->getStatus());
		$this->assertSame('call-1', $result->getCallId());
		$this->assertSame('lookup', $result->getToolName());
		$this->assertSame(['query' => 'BASE3'], $result->getArguments());
		$this->assertSame(['found' => true], $result->getOutput());
		$this->assertSame(['iteration' => 1], $result->getMetadata());
	}

	public function testFailurePreservesStableErrorInformation(): void {
		$result = AgentToolResult::failure(
			'call-2',
			'missing',
			[],
			'tool_not_found',
			'Tool not found: missing',
			['label' => 'Missing']
		);

		$this->assertFalse($result->isSuccess());
		$this->assertSame(AgentToolResult::STATUS_FAILURE, $result->getStatus());
		$this->assertSame('tool_not_found', $result->getErrorCode());
		$this->assertSame('Tool not found: missing', $result->getErrorMessage());
		$this->assertSame('Missing', $result->toArray()['metadata']['label']);
	}
}
