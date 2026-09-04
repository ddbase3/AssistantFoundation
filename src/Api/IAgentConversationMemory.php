<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation extends the BASE3 framework with a unified API
 * foundation for assistants, chatbots, and agent-based systems.
 * It provides shared interfaces for modular AI integration.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace AssistantFoundation\Api;

use AssistantFoundation\Dto\AgentConversation;
use AssistantFoundation\Dto\AgentConversationScope;

/**
 * Stores visible dialog history and conversation metadata.
 *
 * The bound scope defines the server-owned user identity, the logical agent
 * channel, and optionally the current conversation. Implementations must keep
 * every operation inside that scope.
 */
interface IAgentConversationMemory extends IAgentMemory {

	public function bindConversationScope(AgentConversationScope $scope): void;

	/** @return array<int,AgentConversation> */
	public function listConversations(): array;

	public function getConversation(string $conversationId): ?AgentConversation;

	public function getActiveConversation(): ?AgentConversation;

	public function createConversation(
		?string $conversationId = null,
		string $title = '',
		string $titleSource = AgentConversation::TITLE_SOURCE_TEMPORARY,
		string $openingMessage = ''
	): AgentConversation;

	public function activateConversation(string $conversationId): AgentConversation;

	public function renameConversation(
		string $conversationId,
		string $title,
		string $titleSource = AgentConversation::TITLE_SOURCE_MANUAL
	): AgentConversation;

	public function deleteConversation(string $conversationId): void;

	public function touchConversation(string $conversationId): AgentConversation;

	/**
	 * Merges metadata into one stored conversation message without changing
	 * its id, role, or content.
	 *
	 * @param string $nodeId Node history identifier
	 * @param string $messageId Stored message identifier
	 * @param array<string,mixed> $metadata Metadata fields to merge
	 */
	public function updateNodeHistoryMessageMetadata(string $nodeId, string $messageId, array $metadata): bool;
}
