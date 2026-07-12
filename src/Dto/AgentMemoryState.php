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
 * Runtime diagnostics for conversation memories and context contributors.
 */
final class AgentMemoryState {

	/**
	 * @param array<int,array<string,mixed>> $contextContributions
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly int $conversationMemoryCount = 0,
		private readonly int $contextContributorCount = 0,
		private readonly array $contextContributions = [],
		private readonly array $metadata = []
	) {
		if ($this->conversationMemoryCount < 0 || $this->contextContributorCount < 0) {
			throw new \InvalidArgumentException('Agent memory counts must not be negative.');
		}
	}

	public function getConversationMemoryCount(): int { return $this->conversationMemoryCount; }
	public function getContextContributorCount(): int { return $this->contextContributorCount; }
	/** @return array<int,array<string,mixed>> */
	public function getContextContributions(): array { return $this->contextContributions; }
	/** @return array<string,mixed> */
	public function getMetadata(): array { return $this->metadata; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'conversation_memory_count' => $this->conversationMemoryCount,
			'context_contributor_count' => $this->contextContributorCount,
			'context_contributions' => $this->contextContributions,
			'metadata' => $this->metadata
		];
	}
}
