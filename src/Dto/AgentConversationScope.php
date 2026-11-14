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

namespace Base3\AssistantFoundation\Dto;

/**
 * Immutable typed owner and conversation scope.
 *
 * Native host user IDs remain verbatim; session owner IDs are opaque,
 * SHA-256-derived identifiers, never raw session authentication tokens.
 */
final class AgentConversationScope {

	public const OWNER_USER = 'user';
	public const OWNER_SESSION = 'session';

	/**
	 * @param string $ownerType Either user or session
	 * @param string $ownerId Native host user ID or opaque session owner ID
	 * @param string $channelId Logical conversation channel
	 * @param string $conversationId Optional active conversation identifier
	 * @throws \InvalidArgumentException For invalid ownership or identifiers
	 */
	public function __construct(
		private readonly string $ownerType,
		private readonly string $ownerId,
		private readonly string $channelId,
		private readonly string $conversationId = ''
	) {
		if (!in_array($this->ownerType, [self::OWNER_USER, self::OWNER_SESSION], true)) {
			throw new \InvalidArgumentException('Unknown conversation owner type.');
		}
		if (trim($this->ownerId) === '' || strlen($this->ownerId) > 191) {
			throw new \InvalidArgumentException('Conversation scope requires a valid owner ID.');
		}
		if ($this->ownerType === self::OWNER_SESSION && preg_match('/^[a-f0-9]{64}$/', $this->ownerId) !== 1) {
			throw new \InvalidArgumentException('Session scope requires an opaque owner ID.');
		}
		if (!$this->isTechnicalId($this->channelId, 191)) {
			throw new \InvalidArgumentException('Conversation scope requires a valid channel ID.');
		}
		if ($this->conversationId !== '' && !$this->isTechnicalId($this->conversationId, 100)) {
			throw new \InvalidArgumentException('Conversation scope contains an invalid conversation ID.');
		}
	}

	/**
	 * Derive an opaque session-scoped owner identifier without retaining
	 * the session authentication token.
	 *
	 * @param string $sessionId Trusted non-empty session ID
	 * @return string SHA-256 hex identifier compatible with existing session records
	 * @throws \InvalidArgumentException When the session ID is empty
	 */
	public static function ownerIdForSession(string $sessionId): string {
		$sessionId = trim($sessionId);
		if ($sessionId === '') {
			throw new \InvalidArgumentException('Conversation owner requires a session identity.');
		}

		return hash('sha256', 'session:' . $sessionId);
	}

	/** @return string Canonical owner type: user or session */
	public function getOwnerType(): string {
		return $this->ownerType;
	}

	/** @return string Native user ID or opaque session owner ID */
	public function getOwnerId(): string {
		return $this->ownerId;
	}

	/** @return string Logical channel ID */
	public function getChannelId(): string {
		return $this->channelId;
	}

	/** @return string Active conversation ID, or empty when not selected */
	public function getConversationId(): string {
		return $this->conversationId;
	}

	/** @return bool Whether an active conversation ID was selected */
	public function hasConversationId(): bool {
		return $this->conversationId !== '';
	}

	/**
	 * Return a new scope with the same owner and channel and a new conversation.
	 *
	 * @param string $conversationId Technical conversation ID, or empty to clear it
	 * @return self The new scope without mutating this instance
	 * @throws \InvalidArgumentException When the ID is invalid
	 */
	public function withConversationId(string $conversationId): self {
		return new self($this->ownerType, $this->ownerId, $this->channelId, $conversationId);
	}

	/** @return array<string,string> Typed owner and conversation identifiers */
	public function toArray(): array {
		return [
			'owner_type' => $this->ownerType,
			'owner_id' => $this->ownerId,
			'channel_id' => $this->channelId,
			'conversation_id' => $this->conversationId
		];
	}

	private function isTechnicalId(string $value, int $maxLength): bool {
		return $value !== '' && strlen($value) <= $maxLength
			&& preg_match('/^[A-Za-z0-9._:-]+$/', $value) === 1;
	}
}
