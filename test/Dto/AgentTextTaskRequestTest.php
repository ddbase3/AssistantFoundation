<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentTextTaskRequest;
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
