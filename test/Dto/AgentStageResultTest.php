<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentStageResult;
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
