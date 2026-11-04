<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentConversationScope;
use PHPUnit\Framework\TestCase;

final class AgentConversationScopeTest extends TestCase {

	public function testSessionOwnerUsesOpaqueDeterministicHashWithoutExposingSessionToken(): void {
		$owner = AgentConversationScope::ownerIdForSession(' token-123 ');
		$this->assertSame(hash('sha256', 'session:token-123'), $owner);
		$scope = new AgentConversationScope(AgentConversationScope::OWNER_SESSION, $owner, 'chat:123');
		$this->assertSame('session', $scope->getOwnerType());
		$this->assertSame($owner, $scope->getOwnerId());
		$this->assertSame('chat:123', $scope->getChannelId());
		$this->assertSame('', $scope->getConversationId());
		$this->assertFalse($scope->hasConversationId());
		$this->assertStringNotContainsString('token-123', json_encode($scope->toArray()));
	}

	public function testNewConversationScopePreservesOwnerAndLeavesOriginalUnchanged(): void {
		$scope = new AgentConversationScope('user', 'host-native-user-id', 'chat.1');
		$next = $scope->withConversationId('conversation-2');
		$this->assertSame('conversation-2', $next->getConversationId());
		$this->assertTrue($next->hasConversationId());
		$this->assertFalse($scope->hasConversationId());
		$this->assertSame('user', $next->toArray()['owner_type']);
		$this->assertSame('host-native-user-id', $next->toArray()['owner_id']);
		$this->assertFalse($next->withConversationId('')->hasConversationId());
	}

	public function testInvalidOwnersChannelsAndConversationIdsAreRejected(): void {
		foreach ([
			['root', 'user', 'channel', ''], ['user', '  ', 'channel', ''],
			['user', str_repeat('a', 192), 'channel', ''],
			['session', 'not-a-sha256', 'channel', ''],
			['user', 'user', 'channel with spaces', ''],
			['user', 'user', 'channel', str_repeat('a', 101)],
			['user', 'user', 'channel', 'evil/path']
		] as [$type, $owner, $channel, $conversation]) {
			try {
				new AgentConversationScope($type, $owner, $channel, $conversation);
				$this->fail('Invalid conversation scope accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
		$this->expectException(\InvalidArgumentException::class);
		AgentConversationScope::ownerIdForSession('  ');
	}
}
