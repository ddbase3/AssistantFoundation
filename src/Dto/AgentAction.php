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
 * AgentAction
 *
 * Provider-neutral semantic action proposed by an agent before execution.
 */
final class AgentAction {

	public const TYPE_TOOL_CALL = 'tool_call';

	/**
	 * @param array<string,mixed> $input
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $id,
		private readonly string $type,
		private readonly string $name,
		private readonly array $input = [],
		private readonly array $metadata = []
	) {}

	public function getId(): string {
		return $this->id;
	}

	public function getType(): string {
		return $this->type;
	}

	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getInput(): array {
		return $this->input;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * @param array<string,mixed> $data
	 */
	public static function fromArray(array $data): self {
		return new self(
			trim((string)($data['id'] ?? '')),
			trim((string)($data['type'] ?? self::TYPE_TOOL_CALL)),
			trim((string)($data['name'] ?? '')),
			is_array($data['input'] ?? null) ? $data['input'] : [],
			is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'id' => $this->id,
			'type' => $this->type,
			'name' => $this->name,
			'input' => $this->input,
			'metadata' => $this->metadata
		];
	}
}
