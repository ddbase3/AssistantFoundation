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
 * AgentProgressAssessment
 *
 * Provider-neutral assessment describing whether the latest agent iteration
 * added materially new evidence or only repeated previously successful,
 * read-only observations.
 */
final class AgentProgressAssessment {

	public const VERDICT_PROGRESS = 'progress';
	public const VERDICT_STALLED = 'stalled';
	public const VERDICT_UNKNOWN = 'unknown';

	/**
	 * @param array<int,string> $currentSignatures
	 * @param array<int,string> $repeatedSignatures
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly string $verdict,
		private readonly int $consecutiveStalledIterations,
		private readonly string $reason,
		private readonly array $currentSignatures = [],
		private readonly array $repeatedSignatures = [],
		private readonly array $metadata = []
	) {
		if (!in_array($this->verdict, self::getAllowedVerdicts(), true)) {
			throw new \InvalidArgumentException('Unsupported agent progress verdict: ' . $this->verdict);
		}

		if ($this->consecutiveStalledIterations < 0) {
			throw new \InvalidArgumentException('Consecutive stalled iterations must not be negative.');
		}
	}

	public function getIteration(): int {
		return $this->iteration;
	}

	public function getVerdict(): string {
		return $this->verdict;
	}

	public function getConsecutiveStalledIterations(): int {
		return $this->consecutiveStalledIterations;
	}

	public function getReason(): string {
		return $this->reason;
	}

	/**
	 * @return array<int,string>
	 */
	public function getCurrentSignatures(): array {
		return $this->currentSignatures;
	}

	/**
	 * @return array<int,string>
	 */
	public function getRepeatedSignatures(): array {
		return $this->repeatedSignatures;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	public function hasProgress(): bool {
		return $this->verdict === self::VERDICT_PROGRESS;
	}

	public function isStalled(): bool {
		return $this->verdict === self::VERDICT_STALLED;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'iteration' => $this->iteration,
			'verdict' => $this->verdict,
			'consecutive_stalled_iterations' => $this->consecutiveStalledIterations,
			'reason' => $this->reason,
			'current_signatures' => $this->currentSignatures,
			'repeated_signatures' => $this->repeatedSignatures,
			'metadata' => $this->metadata
		];
	}

	/**
	 * @return array<int,string>
	 */
	public static function getAllowedVerdicts(): array {
		return [
			self::VERDICT_PROGRESS,
			self::VERDICT_STALLED,
			self::VERDICT_UNKNOWN
		];
	}
}
