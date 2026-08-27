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
 * Immutable terminal resolution of one durable agent suspension.
 */
final class AgentSuspensionResolution {

	public const OUTCOME_APPROVED = 'approved';
	public const OUTCOME_DENIED = 'denied';
	public const OUTCOME_SUBMITTED = 'submitted';
	public const OUTCOME_MIXED = 'mixed';
	public const OUTCOME_RESOLVED = 'resolved';

	/** @param array<int,AgentInteractionResponse> $responses */
	public function __construct(
		private readonly array $responses,
		private readonly string $source = 'explicit',
		private readonly string $resolvedAt = ''
	) {
		foreach ($this->responses as $response) {
			if (!$response instanceof AgentInteractionResponse) {
				throw new \InvalidArgumentException('Agent suspension resolution accepts AgentInteractionResponse instances only.');
			}
		}
	}

	/** @return array<int,AgentInteractionResponse> */
	public function getResponses(): array {
		return $this->responses;
	}

	public function getSource(): string {
		return trim($this->source);
	}

	public function getResolvedAt(): string {
		return trim($this->resolvedAt);
	}

	public function getOutcome(): string {
		if ($this->responses === []) {
			return self::OUTCOME_RESOLVED;
		}

		$decisions = array_values(array_unique(array_map(
			static fn(AgentInteractionResponse $response): string => $response->getDecision(),
			$this->responses
		)));
		if (count($decisions) !== 1) {
			return self::OUTCOME_MIXED;
		}

		return match ($decisions[0]) {
			AgentInteractionResponse::DECISION_APPROVE => self::OUTCOME_APPROVED,
			AgentInteractionResponse::DECISION_DENY => self::OUTCOME_DENIED,
			AgentInteractionResponse::DECISION_SUBMIT => self::OUTCOME_SUBMITTED,
			default => self::OUTCOME_RESOLVED
		};
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'outcome' => $this->getOutcome(),
			'source' => $this->getSource(),
			'resolved_at' => $this->getResolvedAt(),
			'responses' => array_map(
				static fn(AgentInteractionResponse $response): array => $response->toArray(),
				$this->responses
			)
		];
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		$responses = [];
		foreach (($data['responses'] ?? []) as $response) {
			if (!is_array($response)) {
				throw new \InvalidArgumentException('Invalid agent suspension resolution response payload.');
			}
			$responses[] = AgentInteractionResponse::fromArray($response);
		}

		return new self(
			$responses,
			trim((string)($data['source'] ?? 'explicit')),
			trim((string)($data['resolved_at'] ?? ''))
		);
	}
}
