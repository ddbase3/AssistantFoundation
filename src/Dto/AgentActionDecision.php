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
 * AgentActionDecision
 *
 * Provider-neutral result of evaluating one semantic agent action.
 */
final class AgentActionDecision {

	public const DECISION_ALLOW = 'allow';
	public const DECISION_DENY = 'deny';
	public const DECISION_REQUIRE_APPROVAL = 'require_approval';
	public const DECISION_REQUIRE_DRY_RUN = 'require_dry_run';
	public const DECISION_REQUIRE_CLARIFICATION = 'require_clarification';

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $actionId,
		private readonly string $decision,
		private readonly string $reason = '',
		private readonly array $metadata = []
	) {
		if (!in_array($decision, self::getAllowedDecisions(), true)) {
			throw new \InvalidArgumentException('Unsupported agent action decision: ' . $decision);
		}
	}

	/**
	 * @param array<string,mixed> $metadata
	 */
	public static function allow(string $actionId, string $reason = '', array $metadata = []): self {
		return new self($actionId, self::DECISION_ALLOW, $reason, $metadata);
	}

	/**
	 * @param array<string,mixed> $metadata
	 */
	public static function deny(string $actionId, string $reason, array $metadata = []): self {
		return new self($actionId, self::DECISION_DENY, $reason, $metadata);
	}

	/**
	 * @param array<string,mixed> $metadata
	 */
	public static function requireApproval(string $actionId, string $reason, array $metadata = []): self {
		return new self($actionId, self::DECISION_REQUIRE_APPROVAL, $reason, $metadata);
	}

	/**
	 * @param array<string,mixed> $metadata
	 */
	public static function requireDryRun(string $actionId, string $reason, array $metadata = []): self {
		return new self($actionId, self::DECISION_REQUIRE_DRY_RUN, $reason, $metadata);
	}

	/**
	 * @param array<string,mixed> $metadata
	 */
	public static function requireClarification(string $actionId, string $reason, array $metadata = []): self {
		return new self($actionId, self::DECISION_REQUIRE_CLARIFICATION, $reason, $metadata);
	}

	public function getActionId(): string {
		return $this->actionId;
	}

	public function getDecision(): string {
		return $this->decision;
	}

	public function getReason(): string {
		return $this->reason;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	public function isAllowed(): bool {
		return $this->decision === self::DECISION_ALLOW;
	}

	/**
	 * @param array<string,mixed> $data
	 */
	public static function fromArray(array $data): self {
		return new self(
			trim((string)($data['action_id'] ?? '')),
			trim((string)($data['decision'] ?? '')),
			trim((string)($data['reason'] ?? '')),
			is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'action_id' => $this->actionId,
			'decision' => $this->decision,
			'reason' => $this->reason,
			'metadata' => $this->metadata
		];
	}

	/**
	 * @return array<int,string>
	 */
	public static function getAllowedDecisions(): array {
		return [
			self::DECISION_ALLOW,
			self::DECISION_DENY,
			self::DECISION_REQUIRE_APPROVAL,
			self::DECISION_REQUIRE_DRY_RUN,
			self::DECISION_REQUIRE_CLARIFICATION
		];
	}
}
