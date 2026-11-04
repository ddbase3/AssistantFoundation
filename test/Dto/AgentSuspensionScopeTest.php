<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentSuspensionScope;
use PHPUnit\Framework\TestCase;

final class AgentSuspensionScopeTest extends TestCase {

	public function testConversationScopeUsesNonReversibleDeterministicHash(): void {
		$id = AgentSuspensionScope::forConversation(' channel ', ' c1 ');
		$this->assertSame('conversation:' . hash('sha256', "channel\0c1"), $id);
		$this->assertSame($id, AgentSuspensionScope::forConversation('channel', 'c1'));
		$this->assertNotSame($id, AgentSuspensionScope::forConversation('channel', 'c2'));
		$this->assertStringNotContainsString('channel', $id);
	}

	public function testMissingChannelOrConversationCannotProduceScope(): void {
		$this->assertSame('', AgentSuspensionScope::forConversation('', 'c1'));
		$this->assertSame('', AgentSuspensionScope::forConversation('channel', '   '));
	}
}
