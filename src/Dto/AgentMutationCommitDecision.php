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

/** Provider-neutral result of the final mutation check immediately before commit. */
final class AgentMutationCommitDecision {

	public const CODE_ALLOWED = 'allowed';
	public const CODE_UNAUTHORIZED = 'mutation_unauthorized';
	public const CODE_STALE = 'mutation_stale';
	public const CODE_INVALID_SNAPSHOT = 'mutation_invalid_snapshot';
	public const CODE_GUARD_UNAVAILABLE = 'mutation_commit_guard_unavailable';
	public const CODE_REJECTED = 'mutation_commit_rejected';

	/** @param array<string,mixed> $metadata */
	public function __construct(
		private readonly bool $allowed,
		private readonly string $code,
		private readonly string $reason = '',
		private readonly array $metadata = []
	) {
		if (trim($this->code) === '') {
			throw new \InvalidArgumentException('Mutation commit decision code must not be empty.');
		}
	}

	/** @param array<string,mixed> $metadata */
	public static function allow(string $reason = '', array $metadata = []): self {
		return new self(true, self::CODE_ALLOWED, $reason, $metadata);
	}

	/** @param array<string,mixed> $metadata */
	public static function deny(string $code, string $reason, array $metadata = []): self {
		return new self(false, $code, $reason, $metadata);
	}

	public function isAllowed(): bool {
		return $this->allowed;
	}

	public function getCode(): string {
		return $this->code;
	}

	public function getReason(): string {
		return $this->reason;
	}

	/** @return array<string,mixed> */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'allowed' => $this->allowed,
			'code' => $this->code,
			'reason' => $this->reason,
			'metadata' => $this->metadata
		];
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		return new self(
			($data['allowed'] ?? false) === true,
			trim((string)($data['code'] ?? '')),
			trim((string)($data['reason'] ?? '')),
			is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}
}
