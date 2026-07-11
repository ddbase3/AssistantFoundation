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
 * AgentContinuationDecision
 *
 * Provider- and runtime-neutral decision describing whether an agent loop
 * should continue gathering information, proceed to the final response, or
 * stop and ask the user for clarification.
 *
 * The decision object contains no execution logic. A runtime stage may derive
 * it from deterministic checks, semantic verification, policy results, or a
 * combination of those inputs.
 */
final class AgentContinuationDecision {

	public const DECISION_CONTINUE = 'continue';
	public const DECISION_ANSWER = 'answer';
	public const DECISION_CLARIFY = 'clarify';

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly string $decision,
		private readonly string $reason,
		private readonly string $source,
		private readonly ?float $confidence = null,
		private readonly array $metadata = []
	) {
		if (!in_array($decision, self::getAllowedDecisions(), true)) {
			throw new \InvalidArgumentException('Unsupported agent continuation decision: ' . $decision);
		}

		if ($confidence !== null && ($confidence < 0.0 || $confidence > 1.0)) {
			throw new \InvalidArgumentException('Agent continuation confidence must be between 0.0 and 1.0.');
		}
	}

	public function getIteration(): int {
		return $this->iteration;
	}

	public function getDecision(): string {
		return $this->decision;
	}

	public function getReason(): string {
		return $this->reason;
	}

	public function getSource(): string {
		return $this->source;
	}

	public function getConfidence(): ?float {
		return $this->confidence;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	public function shouldContinue(): bool {
		return $this->decision === self::DECISION_CONTINUE;
	}

	public function shouldAnswer(): bool {
		return $this->decision === self::DECISION_ANSWER;
	}

	public function shouldClarify(): bool {
		return $this->decision === self::DECISION_CLARIFY;
	}

	public function isTerminal(): bool {
		return $this->decision !== self::DECISION_CONTINUE;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'iteration' => $this->iteration,
			'decision' => $this->decision,
			'reason' => $this->reason,
			'source' => $this->source,
			'confidence' => $this->confidence,
			'metadata' => $this->metadata
		];
	}

	/**
	 * @return array<int,string>
	 */
	public static function getAllowedDecisions(): array {
		return [
			self::DECISION_CONTINUE,
			self::DECISION_ANSWER,
			self::DECISION_CLARIFY
		];
	}
}
