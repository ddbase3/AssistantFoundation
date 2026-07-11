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
 * AgentStageTraceEntry
 *
 * Immutable runtime trace entry for one stage decision or execution.
 */
final class AgentStageTraceEntry {

	public const STATUS_SKIPPED = 'skipped';
	public const STATUS_COMPLETED = 'completed';
	public const STATUS_FAILED = 'failed';

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $stageId,
		private readonly string $stageName,
		private readonly string $implementationName,
		private readonly string $description,
		private readonly string $aiUsage,
		private readonly int $iteration,
		private readonly string $phaseBefore,
		private readonly string $phaseAfter,
		private readonly string $status,
		private readonly ?float $durationMs = null,
		private readonly array $metadata = []
	) {}

	public function getStageId(): string {
		return $this->stageId;
	}

	public function getStageName(): string {
		return $this->stageName;
	}

	public function getImplementationName(): string {
		return $this->implementationName;
	}

	public function getDescription(): string {
		return $this->description;
	}

	public function getAiUsage(): string {
		return $this->aiUsage;
	}

	public function getIteration(): int {
		return $this->iteration;
	}

	public function getPhaseBefore(): string {
		return $this->phaseBefore;
	}

	public function getPhaseAfter(): string {
		return $this->phaseAfter;
	}

	public function getStatus(): string {
		return $this->status;
	}

	public function getDurationMs(): ?float {
		return $this->durationMs;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'stage_id' => $this->stageId,
			'stage_name' => $this->stageName,
			'implementation' => $this->implementationName,
			'description' => $this->description,
			'ai_usage' => $this->aiUsage,
			'iteration' => $this->iteration,
			'phase_before' => $this->phaseBefore,
			'phase_after' => $this->phaseAfter,
			'status' => $this->status,
			'duration_ms' => $this->durationMs,
			'metadata' => $this->metadata
		];
	}
}
