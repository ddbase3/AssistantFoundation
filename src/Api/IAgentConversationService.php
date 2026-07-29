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
use AssistantFoundation\Dto\AgentConversationRequest;
use AssistantFoundation\Dto\AgentConversationState;
use Base3\Api\IBase;

/**
 * Runtime-neutral access to the configured conversation memory of an agent.
 */
interface IAgentConversationService extends IBase {

	public function getState(
		AgentConversationRequest $request,
		string $conversationId = ''
	): AgentConversationState;

	public function createConversation(
		AgentConversationRequest $request,
		?string $conversationId = null,
		string $title = '',
		string $titleSource = AgentConversation::TITLE_SOURCE_TEMPORARY,
		string $openingMessage = ''
	): AgentConversationState;

	public function activateConversation(
		AgentConversationRequest $request,
		string $conversationId
	): AgentConversationState;

	public function renameConversation(
		AgentConversationRequest $request,
		string $conversationId,
		string $title,
		string $titleSource = AgentConversation::TITLE_SOURCE_MANUAL
	): AgentConversationState;

	public function deleteConversation(
		AgentConversationRequest $request,
		string $conversationId
	): AgentConversationState;

	public function appendMessage(
		AgentConversationRequest $request,
		string $conversationId,
		array $message
	): AgentConversationState;

	public function touchConversation(
		AgentConversationRequest $request,
		string $conversationId
	): AgentConversationState;
}
