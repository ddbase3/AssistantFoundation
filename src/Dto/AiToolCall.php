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
 * Provider-neutral tool call requested by a chat model.
 */
final class AiToolCall {

	/**
	 * @param array<string,mixed> $arguments
	 * @param array<string,mixed> $metadata Provider-specific or adapter-specific details
	 */
	public function __construct(
		private readonly string $id,
		private readonly string $name,
		private readonly array $arguments = [],
		private readonly array $metadata = []
	) {}

	public function getId(): string {
		return $this->id;
	}

	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getArguments(): array {
		return $this->arguments;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * Returns the provider-neutral public representation.
	 *
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'arguments' => $this->arguments,
			'metadata' => $this->metadata
		];
	}
}
