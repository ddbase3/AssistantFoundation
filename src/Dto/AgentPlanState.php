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
 * Provider-neutral plan state. Planning stages may populate this later.
 */
final class AgentPlanState {

	/**
	 * @param array<int,mixed> $steps
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly array $steps = [],
		private readonly ?int $currentStepIndex = null,
		private readonly string $status = 'none',
		private readonly array $metadata = []
	) {
		if ($this->currentStepIndex !== null && $this->currentStepIndex < 0) {
			throw new \InvalidArgumentException('Agent plan current step index must not be negative.');
		}
	}

	/** @return array<int,mixed> */
	public function getSteps(): array { return $this->steps; }
	public function getCurrentStepIndex(): ?int { return $this->currentStepIndex; }
	public function getStatus(): string { return $this->status; }
	/** @return array<string,mixed> */
	public function getMetadata(): array { return $this->metadata; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'steps' => $this->steps,
			'current_step_index' => $this->currentStepIndex,
			'status' => $this->status,
			'metadata' => $this->metadata
		];
	}
}
