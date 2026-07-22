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
 * One named incremental event produced during an agent execution.
 */
final class AgentExecutionEvent {

	private readonly string $name;

	/** @var array<string,mixed> */
	private readonly array $payload;

	/** @param array<string,mixed> $payload */
	public function __construct(string $name, array $payload = []) {
		$name = trim($name);
		if ($name === '') {
			throw new \InvalidArgumentException('Agent execution event name must not be empty.');
		}
		$this->name = $name;
		$this->payload = $payload;
	}

	public function getName(): string {
		return $this->name;
	}

	/** @return array<string,mixed> */
	public function getPayload(): array {
		return $this->payload;
	}

	/** @return array{name:string,payload:array<string,mixed>} */
	public function toArray(): array {
		return [
			'name' => $this->name,
			'payload' => $this->payload
		];
	}
}
