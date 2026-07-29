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
 * Immutable ownership and channel scope for conversation memory.
 */
final class AgentConversationScope {

	public function __construct(
		private readonly string $ownerKey,
		private readonly string $channelId,
		private readonly string $conversationId = ''
	) {
		if (preg_match('/^[a-f0-9]{64}$/', $this->ownerKey) !== 1) {
			throw new \InvalidArgumentException('Conversation scope requires a SHA-256 owner key.');
		}
		if (!$this->isTechnicalId($this->channelId, 191)) {
			throw new \InvalidArgumentException('Conversation scope requires a valid channel id.');
		}
		if ($this->conversationId !== '' && !$this->isTechnicalId($this->conversationId, 100)) {
			throw new \InvalidArgumentException('Conversation scope contains an invalid conversation id.');
		}
	}

	public function getOwnerKey(): string {
		return $this->ownerKey;
	}

	public function getChannelId(): string {
		return $this->channelId;
	}

	public function getConversationId(): string {
		return $this->conversationId;
	}

	public function hasConversationId(): bool {
		return $this->conversationId !== '';
	}

	public function withConversationId(string $conversationId): self {
		return new self($this->ownerKey, $this->channelId, $conversationId);
	}

	/** @return array<string,string> */
	public function toArray(): array {
		return [
			'owner_key' => $this->ownerKey,
			'channel_id' => $this->channelId,
			'conversation_id' => $this->conversationId
		];
	}

	private function isTechnicalId(string $value, int $maxLength): bool {
		$value = trim($value);
		if ($value === '' || strlen($value) > $maxLength) {
			return false;
		}

		return preg_match('/^[A-Za-z0-9._:-]+$/', $value) === 1;
	}
}
