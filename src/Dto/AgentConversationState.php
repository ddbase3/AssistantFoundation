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

namespace AssistantFoundation\Dto;

/**
 * Immutable snapshot of one conversation channel.
 */
final class AgentConversationState {

	/**
	 * @param array<int,AgentConversation> $conversations
	 * @param array<int,array<string,mixed>> $messages
	 * @param array<int,string> $warnings
	 */
	public function __construct(
		private readonly array $conversations,
		private readonly ?AgentConversation $activeConversation,
		private readonly array $messages,
		private readonly string $nodeId,
		private readonly array $warnings = []
	) {
		foreach ($this->conversations as $conversation) {
			if (!$conversation instanceof AgentConversation) {
				throw new \InvalidArgumentException('Conversation state accepts AgentConversation instances only.');
			}
		}
	}

	/** @return array<int,AgentConversation> */
	public function getConversations(): array {
		return $this->conversations;
	}

	public function getActiveConversation(): ?AgentConversation {
		return $this->activeConversation;
	}

	/** @return array<int,array<string,mixed>> */
	public function getMessages(): array {
		return $this->messages;
	}

	public function getNodeId(): string {
		return $this->nodeId;
	}

	/** @return array<int,string> */
	public function getWarnings(): array {
		return $this->warnings;
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'conversations' => array_map(
				static fn(AgentConversation $conversation): array => $conversation->toArray(),
				$this->conversations
			),
			'active_conversation' => $this->activeConversation?->toArray(),
			'messages' => $this->messages,
			'node_id' => $this->nodeId,
			'warnings' => $this->warnings
		];
	}
}
