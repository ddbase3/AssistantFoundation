<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentStageResult;
use PHPUnit\Framework\TestCase;

final class AgentStageResultTest extends TestCase {

	public function testNoneCreatesEmptyResult(): void {
		$result = AgentStageResult::none();

		$this->assertTrue($result->isEmpty());
		$this->assertSame([], $result->getPatch());
	}

	public function testPatchPreservesContextValues(): void {
		$patch = [
			'agent.messages' => [['role' => 'tool', 'content' => 'result']],
			'agent.iteration' => 2,
		];

		$result = AgentStageResult::patch($patch);

		$this->assertFalse($result->isEmpty());
		$this->assertSame($patch, $result->getPatch());
	}
}
