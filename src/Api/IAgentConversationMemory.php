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
 * Stores visible conversation metadata and message history.
 *
 * Normal operations are restricted to the bound, server-owned scope.
 * Implementations MUST NOT infer authorization from caller-supplied owner IDs.
 * Lifecycle deletion is independent of the current login and requires separate
 * authorization at the invoking application boundary.
 */
interface IAgentConversationMemory extends IAgentMemory {

	/**
	 * Bind the owner's native ID (or opaque session owner ID), channel and active conversation.
	 * Implementations MUST validate that the trusted runtime actor may bind this scope.
	 * An unrecognized or unauthenticated actor MUST NOT access persistent user storage.
	 *
	 * @param AgentConversationScope $scope Valid, server-supplied owner/channel scope
	 * @return void
	 * @throws \RuntimeException If identity validation or storage binding fails
	 * @side-effects May create or activate the requested conversation when supported
	 */
	public function bindConversationScope(AgentConversationScope $scope): void;

	/**
	 * List all conversations belonging to the currently bound owner, channel and namespace.
	 * Other users' conversations MUST NOT be returned.
	 *
	 * @return array<int,AgentConversation> Scoped conversations, or an empty array
	 * @throws \RuntimeException If the bound scope is invalid or the store cannot be read
	 * @side-effects Read-only except for implementation-defined lazy scope initialization
	 */
	public function listConversations(): array;

	/**
	 * Look up a conversation only inside the currently bound scope.
	 *
	 * @param string $conversationId Nonempty conversation identifier
	 * @return AgentConversation|null The scoped conversation, or null if absent
	 * @throws \InvalidArgumentException For an invalid identifier
	 * @throws \RuntimeException If the scope is invalid or the store fails
	 * @side-effects Read-only except for implementation-defined lazy scope initialization
	 */
	public function getConversation(string $conversationId): ?AgentConversation;

	/**
	 * Read the most recently active conversation in the current scope.
	 *
	 * @return AgentConversation|null Active scoped conversation, or null if none exists
	 * @throws \RuntimeException If scope validation or storage access fails
	 * @side-effects Read-only except for implementation-defined lazy scope initialization
	 */
	public function getActiveConversation(): ?AgentConversation;

	/**
	 * Create a conversation for the current trusted owner and channel.
	 * Implementations MUST NOT overwrite an existing conversation with the same ID.
	 *
	 * @param string|null $conversationId Optional explicit technical ID; null generates one
	 * @param string $title Optional initial title
	 * @param string $titleSource AgentConversation title-source constant
	 * @param string $openingMessage Optional first assistant greeting or opening text
	 * @return AgentConversation Newly stored conversation
	 * @throws \InvalidArgumentException For invalid conversation metadata
	 * @throws \RuntimeException For duplicates, scope violations or failed persistence
	 * @side-effects Persists a new scoped conversation and may change the active selection
	 */
	public function createConversation(
		?string $conversationId = null,
		string $title = '',
		string $titleSource = AgentConversation::TITLE_SOURCE_TEMPORARY,
		string $openingMessage = ''
	): AgentConversation;

	/**
	 * Select an existing scoped conversation and record its activation.
	 *
	 * @param string $conversationId Existing scoped conversation ID
	 * @return AgentConversation Updated conversation metadata
	 * @throws \InvalidArgumentException For an invalid identifier
	 * @throws \RuntimeException If the conversation cannot be accessed or updated
	 * @side-effects May update activity metadata and the active selection
	 */
	public function activateConversation(string $conversationId): AgentConversation;

	/**
	 * Change the title of a scoped conversation, retaining a manual title when
	 * an automatic title is subsequently requested.
	 *
	 * @param string $conversationId Existing scoped conversation ID
	 * @param string $title New title
	 * @param string $titleSource AgentConversation title-source constant
	 * @return AgentConversation Updated conversation or the preserved manual-title conversation
	 * @throws \InvalidArgumentException For invalid metadata or an invalid identifier
	 * @throws \RuntimeException If the record cannot be updated or verified
	 * @side-effects Updates stored title metadata only when permitted by title precedence
	 */
	public function renameConversation(
		string $conversationId,
		string $title,
		string $titleSource = AgentConversation::TITLE_SOURCE_MANUAL
	): AgentConversation;

	/**
	 * Delete a single conversation only within the current trusted scope.
	 * All related message history MUST be removed; missing records are harmless.
	 *
	 * @param string $conversationId Scoped conversation identifier
	 * @return void
	 * @throws \InvalidArgumentException For invalid identifiers
	 * @throws \RuntimeException If deletion cannot be completed or verified
	 * @side-effects Permanently removes the conversation and its messages
	 */
	public function deleteConversation(string $conversationId): void;

	/**
	 * Delete all conversations belonging to an explicitly identified native user
	 * or opaque session owner, regardless of which user is currently logged in.
	 * Persisted message history MUST be removed and the result verified.
	 * An implementation unable to reach the named storage scope MUST fail rather
	 * than claim deletion; a host-specific session backend may only access its
	 * current session. HTTP and API entrypoints MUST independently authorize this
	 * lifecycle operation via the active authorization service.
	 *
	 * @param string $ownerType Exactly "user" or "session"
	 * @param string $ownerId Verbatim host-native user ID or opaque session owner ID
	 * @return void
	 * @throws \InvalidArgumentException For malformed ownership data
	 * @throws \RuntimeException If complete deletion cannot be verified
	 * @side-effects Permanently removes all accessible matching conversations/messages
	 */
	public function deleteConversationsByOwner(string $ownerType, string $ownerId): void;

	/**
	 * Delete conversations and their messages for a named logical channel.
	 * Implementations that only support a current session MUST NOT claim deletion
	 * from other, inaccessible sessions. The caller is responsible for permission
	 * checks and for backend-wide session expiration where relevant.
	 *
	 * @param string $channelId Nonempty technical channel identifier
	 * @return void
	 * @throws \InvalidArgumentException For an invalid channel
	 * @throws \RuntimeException When accessible records cannot be deleted and verified
	 * @side-effects Removes matching stored conversations and messages
	 */
	public function deleteConversationsByChannel(string $channelId): void;

	/**
	 * Update the last-active timestamp and active selection for a scoped conversation.
	 *
	 * @param string $conversationId Existing scoped conversation ID
	 * @return AgentConversation Updated conversation
	 * @throws \InvalidArgumentException For malformed identifiers
	 * @throws \RuntimeException If the scoped record is missing or cannot be updated
	 * @side-effects Updates activity metadata and may change the active conversation
	 */
	public function touchConversation(string $conversationId): AgentConversation;

	/**
	 * Merge metadata into a message of the current scoped conversation without
	 * changing its ID, role or content. Missing message IDs return false.
	 *
	 * @param string $nodeId Node-history identifier
	 * @param string $messageId Message identifier in the scoped history
	 * @param array<string,mixed> $metadata Metadata to merge; content, role and id are excluded
	 * @return bool True if persisted and verified, false for absent messages or empty updates
	 * @throws \InvalidArgumentException For malformed node or message identifiers
	 * @throws \RuntimeException If the storage or identity scope is inaccessible
	 * @side-effects Updates matching message metadata, retaining original message content
	 */
	public function updateNodeHistoryMessageMetadata(string $nodeId, string $messageId, array $metadata): bool;
}
