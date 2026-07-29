<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentConversation;
use AssistantFoundation\Dto\AgentConversationState;
use PHPUnit\Framework\TestCase;

final class AgentConversationStateTest extends TestCase {

	public function testToArrayPreservesConversationAndMessages(): void {
		$conversation = new AgentConversation(
			'conversation-1',
			'Example',
			AgentConversation::TITLE_SOURCE_TEMPORARY,
			'Welcome',
			'2026-07-29T10:00:00+00:00',
			'2026-07-29T10:00:00+00:00',
			'2026-07-29T10:00:00+00:00'
		);
		$state = new AgentConversationState(
			[$conversation],
			$conversation,
			[['id' => 'message-1', 'role' => 'user', 'content' => 'Hello']],
			'assistant'
		);

		$this->assertSame('conversation-1', $state->toArray()['active_conversation']['id'] ?? null);
		$this->assertSame('Hello', $state->toArray()['messages'][0]['content'] ?? null);
	}
}
