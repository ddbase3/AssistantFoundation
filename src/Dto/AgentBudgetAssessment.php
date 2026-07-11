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
 * Immutable result of one agent budget check.
 *
 * Unknown limits are recorded separately from exceeded limits. This prevents
 * missing provider usage metadata from being silently treated as zero.
 */
final class AgentBudgetAssessment {

	/**
	 * @param array<string,array<string,mixed>> $exceededLimits
	 * @param array<string,array<string,mixed>> $unknownLimits
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly AgentBudget $budget,
		private readonly AiUsage $usage,
		private readonly int $aiOperationCount,
		private readonly int $toolCallCount,
		private readonly float $elapsedMs,
		private readonly array $exceededLimits = [],
		private readonly array $unknownLimits = [],
		private readonly array $metadata = []
	) {}

	public function getIteration(): int {
		return $this->iteration;
	}

	public function getBudget(): AgentBudget {
		return $this->budget;
	}

	public function getUsage(): AiUsage {
		return $this->usage;
	}

	public function getAiOperationCount(): int {
		return $this->aiOperationCount;
	}

	public function getToolCallCount(): int {
		return $this->toolCallCount;
	}

	public function getElapsedMs(): float {
		return $this->elapsedMs;
	}

	/**
	 * @return array<string,array<string,mixed>>
	 */
	public function getExceededLimits(): array {
		return $this->exceededLimits;
	}

	/**
	 * @return array<string,array<string,mixed>>
	 */
	public function getUnknownLimits(): array {
		return $this->unknownLimits;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	public function hasExceededLimits(): bool {
		return $this->exceededLimits !== [];
	}

	public function hasUnknownLimits(): bool {
		return $this->unknownLimits !== [];
	}

	public function canContinue(): bool {
		if ($this->hasExceededLimits()) {
			return false;
		}

		return !$this->budget->requiresUsageReporting() || !$this->hasUnknownLimits();
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'iteration' => $this->iteration,
			'budget' => $this->budget->toArray(),
			'usage' => $this->usage->toArray(),
			'ai_operation_count' => $this->aiOperationCount,
			'tool_call_count' => $this->toolCallCount,
			'elapsed_ms' => $this->elapsedMs,
			'exceeded_limits' => $this->exceededLimits,
			'unknown_limits' => $this->unknownLimits,
			'can_continue' => $this->canContinue(),
			'metadata' => $this->metadata
		];
	}
}
