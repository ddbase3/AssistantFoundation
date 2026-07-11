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
 * AgentContextCompaction
 *
 * Records one attempted tool-result compaction without hiding whether the
 * original value was preserved or replaced.
 */
final class AgentContextCompaction {

	/**
	 * @param array<string,mixed> $modelMetadata
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly string $callId,
		private readonly string $toolName,
		private readonly bool $applied,
		private readonly int $originalBytes,
		private readonly int $compactedBytes,
		private readonly bool $inputTruncated,
		private readonly array $modelMetadata = [],
		private readonly string $errorMessage = ''
	) {}

	public function getIteration(): int {
		return $this->iteration;
	}

	public function getCallId(): string {
		return $this->callId;
	}

	public function getToolName(): string {
		return $this->toolName;
	}

	public function wasApplied(): bool {
		return $this->applied;
	}

	public function getOriginalBytes(): int {
		return $this->originalBytes;
	}

	public function getCompactedBytes(): int {
		return $this->compactedBytes;
	}

	public function wasInputTruncated(): bool {
		return $this->inputTruncated;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getModelMetadata(): array {
		return $this->modelMetadata;
	}

	public function getErrorMessage(): string {
		return $this->errorMessage;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'iteration' => $this->iteration,
			'call_id' => $this->callId,
			'tool' => $this->toolName,
			'applied' => $this->applied,
			'original_bytes' => $this->originalBytes,
			'compacted_bytes' => $this->compactedBytes,
			'input_truncated' => $this->inputTruncated,
			'model_metadata' => $this->modelMetadata,
			'error_message' => $this->errorMessage
		];
	}
}
