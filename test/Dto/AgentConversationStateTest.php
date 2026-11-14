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

use Base3\AssistantFoundation\Dto\AgentConversation;
use Base3\AssistantFoundation\Dto\AgentConversationState;
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
