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
 * Stable task identity and normalized task input for one agent run.
 */
final class AgentTaskState {

	/**
	 * @param array<string,mixed> $input
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $id = '',
		private readonly string $description = '',
		private readonly array $input = [],
		private readonly array $metadata = []
	) {}

	public function getId(): string { return $this->id; }
	public function getDescription(): string { return $this->description; }
	/** @return array<string,mixed> */
	public function getInput(): array { return $this->input; }
	/** @return array<string,mixed> */
	public function getMetadata(): array { return $this->metadata; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'id' => $this->id,
			'description' => $this->description,
			'input' => $this->input,
			'metadata' => $this->metadata
		];
	}
}
