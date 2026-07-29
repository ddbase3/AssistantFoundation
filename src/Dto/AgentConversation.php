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
 * Immutable metadata of one conversation in a conversation-memory channel.
 */
final class AgentConversation {

	public const TITLE_SOURCE_TEMPORARY = 'temporary';
	public const TITLE_SOURCE_AUTOMATIC = 'automatic';
	public const TITLE_SOURCE_MANUAL = 'manual';

	private const TITLE_SOURCES = [
		self::TITLE_SOURCE_TEMPORARY,
		self::TITLE_SOURCE_AUTOMATIC,
		self::TITLE_SOURCE_MANUAL
	];

	public function __construct(
		private readonly string $id,
		private readonly string $title,
		private readonly string $titleSource,
		private readonly string $openingMessage,
		private readonly string $createdAt,
		private readonly string $updatedAt,
		private readonly string $lastActiveAt
	) {
		if (!$this->isTechnicalId($this->id, 100)) {
			throw new \InvalidArgumentException('Conversation requires a valid id.');
		}
		if (trim($this->title) === '' || $this->textLength($this->title) > 255) {
			throw new \InvalidArgumentException('Conversation requires a title with at most 255 characters.');
		}
		if (!in_array($this->titleSource, self::TITLE_SOURCES, true)) {
			throw new \InvalidArgumentException('Conversation contains an invalid title source.');
		}
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		return new self(
			id: trim((string)($data['id'] ?? $data['conversation_id'] ?? '')),
			title: trim((string)($data['title'] ?? '')),
			titleSource: trim((string)($data['title_source'] ?? self::TITLE_SOURCE_TEMPORARY)),
			openingMessage: (string)($data['opening_message'] ?? ''),
			createdAt: trim((string)($data['created_at'] ?? '')),
			updatedAt: trim((string)($data['updated_at'] ?? '')),
			lastActiveAt: trim((string)($data['last_active_at'] ?? ''))
		);
	}

	public function getId(): string {
		return $this->id;
	}

	public function getTitle(): string {
		return $this->title;
	}

	public function getTitleSource(): string {
		return $this->titleSource;
	}

	public function getOpeningMessage(): string {
		return $this->openingMessage;
	}

	public function getCreatedAt(): string {
		return $this->createdAt;
	}

	public function getUpdatedAt(): string {
		return $this->updatedAt;
	}

	public function getLastActiveAt(): string {
		return $this->lastActiveAt;
	}

	/** @return array<string,string> */
	public function toArray(): array {
		return [
			'id' => $this->id,
			'title' => $this->title,
			'title_source' => $this->titleSource,
			'opening_message' => $this->openingMessage,
			'created_at' => $this->createdAt,
			'updated_at' => $this->updatedAt,
			'last_active_at' => $this->lastActiveAt
		];
	}

	private function isTechnicalId(string $value, int $maxLength): bool {
		$value = trim($value);
		if ($value === '' || strlen($value) > $maxLength) {
			return false;
		}

		return preg_match('/^[A-Za-z0-9._:-]+$/', $value) === 1;
	}

	private function textLength(string $value): int {
		return function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);
	}
}
