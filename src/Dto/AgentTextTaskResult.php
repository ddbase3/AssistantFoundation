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
 * Immutable result of one isolated non-conversational text task.
 */
final class AgentTextTaskResult {

	/**
	 * @param array<int,string> $warnings
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $content,
		private readonly array $warnings = [],
		private readonly array $metadata = []
	) {}

	public function getContent(): string {
		return $this->content;
	}

	/** @return array<int,string> */
	public function getWarnings(): array {
		return $this->warnings;
	}

	/** @return array<string,mixed> */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'content' => $this->content,
			'warnings' => $this->warnings,
			'metadata' => $this->metadata
		];
	}
}
