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
 * Immutable stable state aggregate for one agent run.
 *
 * Stage-specific or experimental values intentionally remain in the dynamic
 * IAgentContext variable bag. This object only contains durable runtime axes.
 */
final class AgentState {

	public function __construct(
		private readonly ?AgentTaskState $task = null,
		private readonly ?AgentPlanState $plan = null,
		private readonly ?AgentKnowledgeState $knowledge = null,
		private readonly ?AgentExecutionState $execution = null,
		private readonly ?AgentMemoryState $memory = null,
		private readonly ?AgentContextWindowState $contextWindow = null,
		private readonly ?AgentBudgetState $budget = null,
		private readonly ?AgentSuspensionState $suspension = null,
		private readonly ?AgentResultState $result = null
	) {}

	public static function empty(): self { return new self(); }
	public function getTask(): ?AgentTaskState { return $this->task; }
	public function getPlan(): ?AgentPlanState { return $this->plan; }
	public function getKnowledge(): ?AgentKnowledgeState { return $this->knowledge; }
	public function getExecution(): ?AgentExecutionState { return $this->execution; }
	public function getMemory(): ?AgentMemoryState { return $this->memory; }
	public function getContextWindow(): ?AgentContextWindowState { return $this->contextWindow; }
	public function getBudget(): ?AgentBudgetState { return $this->budget; }
	public function getSuspension(): ?AgentSuspensionState { return $this->suspension; }
	public function getResult(): ?AgentResultState { return $this->result; }

	public function withTask(?AgentTaskState $task): self {
		return new self($task, $this->plan, $this->knowledge, $this->execution, $this->memory, $this->contextWindow, $this->budget, $this->suspension, $this->result);
	}

	public function withPlan(?AgentPlanState $plan): self {
		return new self($this->task, $plan, $this->knowledge, $this->execution, $this->memory, $this->contextWindow, $this->budget, $this->suspension, $this->result);
	}

	public function withKnowledge(?AgentKnowledgeState $knowledge): self {
		return new self($this->task, $this->plan, $knowledge, $this->execution, $this->memory, $this->contextWindow, $this->budget, $this->suspension, $this->result);
	}

	public function withExecution(?AgentExecutionState $execution): self {
		return new self($this->task, $this->plan, $this->knowledge, $execution, $this->memory, $this->contextWindow, $this->budget, $this->suspension, $this->result);
	}

	public function withMemory(?AgentMemoryState $memory): self {
		return new self($this->task, $this->plan, $this->knowledge, $this->execution, $memory, $this->contextWindow, $this->budget, $this->suspension, $this->result);
	}

	public function withContextWindow(?AgentContextWindowState $contextWindow): self {
		return new self($this->task, $this->plan, $this->knowledge, $this->execution, $this->memory, $contextWindow, $this->budget, $this->suspension, $this->result);
	}

	public function withBudget(?AgentBudgetState $budget): self {
		return new self($this->task, $this->plan, $this->knowledge, $this->execution, $this->memory, $this->contextWindow, $budget, $this->suspension, $this->result);
	}

	public function withSuspension(?AgentSuspensionState $suspension): self {
		return new self($this->task, $this->plan, $this->knowledge, $this->execution, $this->memory, $this->contextWindow, $this->budget, $suspension, $this->result);
	}

	public function withResult(?AgentResultState $result): self {
		return new self($this->task, $this->plan, $this->knowledge, $this->execution, $this->memory, $this->contextWindow, $this->budget, $this->suspension, $result);
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'task' => $this->task?->toArray(),
			'plan' => $this->plan?->toArray(),
			'knowledge' => $this->knowledge?->toArray(),
			'execution' => $this->execution?->toArray(),
			'memory' => $this->memory?->toArray(),
			'context_window' => $this->contextWindow?->toArray(),
			'budget' => $this->budget?->toArray(),
			'suspension' => $this->suspension?->toArray(),
			'result' => $this->result?->toArray()
		];
	}
}
