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
 * AgentResultVerification
 *
 * Provider- and runtime-neutral verification record for one agent result
 * processing step.
 *
 * The value object deliberately does not prescribe how verification is
 * performed. Deterministic contract checks and later semantic AI verifiers can
 * publish the same representation.
 */
final class AgentResultVerification {

	public const VERDICT_VERIFIED = 'verified';
	public const VERDICT_FAILED = 'failed';
	public const VERDICT_INCONCLUSIVE = 'inconclusive';

	/**
	 * @param array<int,array<string,mixed>> $issues
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly string $verifier,
		private readonly string $verdict,
		private readonly string $summary,
		private readonly array $issues = [],
		private readonly array $metadata = []
	) {
		if (!in_array($verdict, self::getAllowedVerdicts(), true)) {
			throw new \InvalidArgumentException('Unsupported agent result verification verdict: ' . $verdict);
		}
	}

	public function getIteration(): int {
		return $this->iteration;
	}

	public function getVerifier(): string {
		return $this->verifier;
	}

	public function getVerdict(): string {
		return $this->verdict;
	}

	public function getSummary(): string {
		return $this->summary;
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	public function getIssues(): array {
		return $this->issues;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	public function isVerified(): bool {
		return $this->verdict === self::VERDICT_VERIFIED;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'iteration' => $this->iteration,
			'verifier' => $this->verifier,
			'verdict' => $this->verdict,
			'summary' => $this->summary,
			'issues' => $this->issues,
			'metadata' => $this->metadata
		];
	}

	/**
	 * @return array<int,string>
	 */
	public static function getAllowedVerdicts(): array {
		return [
			self::VERDICT_VERIFIED,
			self::VERDICT_FAILED,
			self::VERDICT_INCONCLUSIVE
		];
	}
}
