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

use Base3\AssistantFoundation\Dto\AgentSuspensionScope;
use PHPUnit\Framework\TestCase;

final class AgentSuspensionScopeTest extends TestCase {

	public function testConversationScopeUsesNonReversibleDeterministicHash(): void {
		$id = AgentSuspensionScope::forConversation(' channel ', ' c1 ');
		$this->assertSame('conversation:' . hash('sha256', "channel\0c1"), $id);
		$this->assertSame($id, AgentSuspensionScope::forConversation('channel', 'c1'));
		$this->assertNotSame($id, AgentSuspensionScope::forConversation('channel', 'c2'));
		$this->assertStringNotContainsString('channel', $id);
	}

	public function testVerifiedSubjectSeparatesApprovalScopesWithoutChangingConversationOnlyCallers(): void {
		$legacy = AgentSuspensionScope::forConversation('agent-api:jarvis', 'chat');
		$alice = AgentSuspensionScope::forConversation('agent-api:jarvis', 'chat', 'xrm:user:42');
		$bob = AgentSuspensionScope::forConversation('agent-api:jarvis', 'chat', 'xrm:user:13');
		$this->assertSame('conversation:' . hash('sha256', "agent-api:jarvis\0chat"), $legacy);
		$this->assertSame('conversation:' . hash('sha256', "agent-api:jarvis\0chat\0xrm:user:42"), $alice);
		$this->assertNotSame($legacy, $alice);
		$this->assertNotSame($bob, $alice);
		$this->assertSame($alice, AgentSuspensionScope::forConversation('agent-api:jarvis', 'chat', ' xrm:user:42 '));
	}

	public function testMissingChannelOrConversationCannotProduceScope(): void {
		$this->assertSame('', AgentSuspensionScope::forConversation('', 'c1'));
		$this->assertSame('', AgentSuspensionScope::forConversation('channel', '   '));
	}
}
