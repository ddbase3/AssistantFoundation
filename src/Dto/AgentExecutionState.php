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
 * Stable execution section for phases, loop counters and execution records.
 */
final class AgentExecutionState {

	/**
	 * @param array<int,mixed> $actions
	 * @param array<int,mixed> $actionDecisions
	 * @param array<int,mixed> $executedToolCalls
	 * @param array<int,mixed> $modelResults
	 * @param array<int,mixed> $stageTrace
	 * @param array<int,mixed> $capabilitySelections
	 * @param array<int,mixed> $toolContractValidations
	 * @param array<int,mixed> $toolCacheRecords
	 * @param array<int,mixed> $progressAssessments
	 */
	public function __construct(
		private readonly string $status = AgentExecutionStatus::RUNNING,
		private readonly string $phase = '',
		private readonly int $iteration = 0,
		private readonly int $maxIterations = 0,
		private readonly int $callIndex = 0,
		private readonly array $actions = [],
		private readonly array $actionDecisions = [],
		private readonly array $executedToolCalls = [],
		private readonly array $modelResults = [],
		private readonly array $stageTrace = [],
		private readonly array $capabilitySelections = [],
		private readonly array $toolContractValidations = [],
		private readonly array $toolCacheRecords = [],
		private readonly array $progressAssessments = []
	) {
		if (!in_array($this->status, AgentExecutionStatus::all(), true)) {
			throw new \InvalidArgumentException('Unsupported agent execution state status: ' . $this->status);
		}
		if ($this->iteration < 0 || $this->maxIterations < 0 || $this->callIndex < 0) {
			throw new \InvalidArgumentException('Agent execution counters must not be negative.');
		}
	}

	public function getStatus(): string { return $this->status; }
	public function getPhase(): string { return $this->phase; }
	public function getIteration(): int { return $this->iteration; }
	public function getMaxIterations(): int { return $this->maxIterations; }
	public function getCallIndex(): int { return $this->callIndex; }
	/** @return array<int,mixed> */ public function getActions(): array { return $this->actions; }
	/** @return array<int,mixed> */ public function getActionDecisions(): array { return $this->actionDecisions; }
	/** @return array<int,mixed> */ public function getExecutedToolCalls(): array { return $this->executedToolCalls; }
	/** @return array<int,mixed> */ public function getModelResults(): array { return $this->modelResults; }
	/** @return array<int,mixed> */ public function getStageTrace(): array { return $this->stageTrace; }
	/** @return array<int,mixed> */ public function getCapabilitySelections(): array { return $this->capabilitySelections; }
	/** @return array<int,mixed> */ public function getToolContractValidations(): array { return $this->toolContractValidations; }
	/** @return array<int,mixed> */ public function getToolCacheRecords(): array { return $this->toolCacheRecords; }
	/** @return array<int,mixed> */ public function getProgressAssessments(): array { return $this->progressAssessments; }

	/** @param array<int,mixed> $modelResults */
	public function withModelResults(array $modelResults): self {
		return new self(
			status: $this->status,
			phase: $this->phase,
			iteration: $this->iteration,
			maxIterations: $this->maxIterations,
			callIndex: $this->callIndex,
			actions: $this->actions,
			actionDecisions: $this->actionDecisions,
			executedToolCalls: $this->executedToolCalls,
			modelResults: $modelResults,
			stageTrace: $this->stageTrace,
			capabilitySelections: $this->capabilitySelections,
			toolContractValidations: $this->toolContractValidations,
			toolCacheRecords: $this->toolCacheRecords,
			progressAssessments: $this->progressAssessments
		);
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'status' => $this->status,
			'phase' => $this->phase,
			'iteration' => $this->iteration,
			'max_iterations' => $this->maxIterations,
			'call_index' => $this->callIndex,
			'actions' => self::normalizeList($this->actions),
			'action_decisions' => self::normalizeList($this->actionDecisions),
			'executed_tool_calls' => self::normalizeList($this->executedToolCalls),
			'model_results' => self::normalizeList($this->modelResults),
			'stage_trace' => self::normalizeList($this->stageTrace),
			'capability_selections' => self::normalizeList($this->capabilitySelections),
			'tool_contract_validations' => self::normalizeList($this->toolContractValidations),
			'tool_cache_records' => self::normalizeList($this->toolCacheRecords),
			'progress_assessments' => self::normalizeList($this->progressAssessments)
		];
	}

	/** @param array<int,mixed> $values */
	private static function normalizeList(array $values): array {
		return array_map(
			static fn(mixed $value): mixed => is_object($value) && method_exists($value, 'toArray')
				? $value->toArray()
				: $value,
			$values
		);
	}
}
