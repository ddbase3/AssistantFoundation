<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentConversation;
use AssistantFoundation\Dto\AgentConversationScope;
use PHPUnit\Framework\TestCase;

final class AgentConversationTest extends TestCase {

	public function testScopeKeepsOwnerChannelAndConversationTogether(): void {
		$scope = new AgentConversationScope(str_repeat('a', 64), 'chatbot-main');
		$selected = $scope->withConversationId('conversation-one');

		$this->assertFalse($scope->hasConversationId());
		$this->assertTrue($selected->hasConversationId());
		$this->assertSame('chatbot-main', $selected->getChannelId());
		$this->assertSame('conversation-one', $selected->getConversationId());
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

	public function testScopeRejectsNonHashedOwnerIdentity(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentConversationScope('user-42', 'chatbot-main');
	}
}
