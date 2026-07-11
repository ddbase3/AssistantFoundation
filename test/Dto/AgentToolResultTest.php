<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentToolResult;
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
