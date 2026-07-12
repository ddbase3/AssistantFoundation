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
 * Stable transport-neutral terminal result for one agent run.
 */
final class AgentResult {

	/**
	 * @param array<string,mixed> $output
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $status,
		private readonly AgentState $state,
		private readonly array $output = [],
		private readonly array $metadata = []
	) {
		if (!in_array($this->status, AgentExecutionStatus::all(), true)) {
			throw new \InvalidArgumentException('Unsupported agent result status: ' . $this->status);
		}
	}

	public function getStatus(): string { return $this->status; }
	public function getState(): AgentState { return $this->state; }
	/** @return array<string,mixed> */ public function getOutput(): array { return $this->output; }
	/** @return array<string,mixed> */ public function getMetadata(): array { return $this->metadata; }
	public function isCompleted(): bool { return $this->status === AgentExecutionStatus::COMPLETED; }
	public function isSuspended(): bool { return AgentExecutionStatus::isSuspended($this->status); }
	public function isPartial(): bool { return $this->status === AgentExecutionStatus::PARTIAL; }
	public function hasFailure(): bool {
		return in_array($this->status, [AgentExecutionStatus::FAILED, AgentExecutionStatus::PARTIAL], true)
			|| ($this->state->getResult()?->hasFailure() ?? false);
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'status' => $this->status,
			'state' => $this->state->toArray(),
			'output' => $this->output,
			'metadata' => $this->metadata
		];
	}
}
