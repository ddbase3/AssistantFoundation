<?php declare(strict_types=1);

namespace Test\AssistantFoundation\Dto;

use AssistantFoundation\Dto\AgentExecutionRequest;
use PHPUnit\Framework\TestCase;

final class AgentExecutionRequestTest extends TestCase {

	public function testKeepsRuntimeConfigurationInputsAndContextSeparate(): void {
		$request = new AgentExecutionRequest(
			['runtime' => 'test'],
			['prompt' => 'Hello'],
			['conversation_id' => 'chat-1']
		);

		$this->assertSame(['runtime' => 'test'], $request->getAgentConfiguration());
		$this->assertSame(['prompt' => 'Hello'], $request->getInputs());
		$this->assertSame(['conversation_id' => 'chat-1'], $request->getContext());
	}
}
