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
 * Configured run budget and recorded budget checkpoints.
 */
final class AgentBudgetState {

	/** @param array<int,mixed> $assessments */
	public function __construct(
		private readonly ?AgentBudget $budget = null,
		private readonly array $assessments = []
	) {}

	public function getBudget(): ?AgentBudget { return $this->budget; }
	/** @return array<int,mixed> */ public function getAssessments(): array { return $this->assessments; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'budget' => $this->budget?->toArray(),
			'assessments' => array_map(
				static fn(mixed $value): mixed => is_object($value) && method_exists($value, 'toArray')
					? $value->toArray()
					: $value,
				$this->assessments
			)
		];
	}
}
