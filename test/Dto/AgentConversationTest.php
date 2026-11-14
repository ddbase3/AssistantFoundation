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
use Base3\AssistantFoundation\Dto\AgentConversationScope;
use PHPUnit\Framework\TestCase;

final class AgentConversationTest extends TestCase {

	public function testScopeKeepsOwnerChannelAndConversationTogether(): void {
		$scope = new AgentConversationScope('user', '42', 'chatbot-main');
		$selected = $scope->withConversationId('conversation-one');

		$this->assertFalse($scope->hasConversationId());
		$this->assertTrue($selected->hasConversationId());
		$this->assertSame('chatbot-main', $selected->getChannelId());
		$this->assertSame('conversation-one', $selected->getConversationId());
	}

	public function testScopeKeepsNativeUsersAndOpaqueSessions(): void {
		$this->assertSame('42', (new AgentConversationScope('user', '42', 'chatbot-main'))->getOwnerId());
		$this->assertSame('0', (new AgentConversationScope('user', '0', 'chatbot-main'))->getOwnerId());
		$this->assertSame('name-with-suffix ', (new AgentConversationScope('user', 'name-with-suffix ', 'chatbot-main'))->getOwnerId());
		$this->assertSame(hash('sha256', 'session:session-one'), AgentConversationScope::ownerIdForSession('session-one'));
	}

	public function testConversationRoundTripsCanonicalMetadata(): void {
		$data = [
			'id' => 'conversation-one',
			'title' => 'First chat',
			'title_source' => AgentConversation::TITLE_SOURCE_MANUAL,
			'opening_message' => 'How can I help?',
			'created_at' => '2026-07-29 16:00:00.000001',
			'updated_at' => '2026-07-29 16:01:00.000001',
			'last_active_at' => '2026-07-29 16:02:00.000001'
		];

		$this->assertSame($data, AgentConversation::fromArray($data)->toArray());
	}

	public function testScopeRejectsUnknownOwnerType(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentConversationScope('unknown', '42', 'chatbot-main');
	}
}
