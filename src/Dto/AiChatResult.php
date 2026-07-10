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

use AssistantFoundation\Api\IAiResult;

/**
 * Provider-neutral result of one non-streaming chat-model call.
 */
final class AiChatResult implements IAiResult {

	/**
	 * @param array<int,AiToolCall> $toolCalls
	 */
	public function __construct(
		private readonly string $content,
		private readonly array $toolCalls,
		private readonly AiResultMetadata $metadata,
		private readonly mixed $raw = null
	) {}

	public function getContent(): string {
		return $this->content;
	}

	/**
	 * @return array<int,AiToolCall>
	 */
	public function getToolCalls(): array {
		return $this->toolCalls;
	}

	public function hasToolCalls(): bool {
		return $this->toolCalls !== [];
	}

	public function getMetadata(): AiResultMetadata {
		return $this->metadata;
	}

	public function getRaw(): mixed {
		return $this->raw;
	}

	/**
	 * Returns the provider-neutral public representation.
	 *
	 * @return array<string,mixed>
	 */
	public function toArray(bool $includeRaw = false): array {
		$result = [
			'content' => $this->content,
			'tool_calls' => array_map(
				static fn(AiToolCall $toolCall): array => $toolCall->toArray(),
				$this->toolCalls
			),
			'metadata' => $this->metadata->toArray()
		];

		if($includeRaw) {
			$result['raw'] = $this->raw;
		}

		return $result;
	}
}
