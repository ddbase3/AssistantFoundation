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
 * Stable user-interaction and resume state for one durable agent suspension.
 */
final class AgentSuspensionState {

	public const LIFECYCLE_ACTIVE = 'active';
	public const LIFECYCLE_RESOLVED = 'resolved';
	public const LIFECYCLE_EXPIRED = 'expired';

	/** @param array<int,mixed> $interactionRequests */
	public function __construct(
		private readonly bool $suspended = false,
		private readonly string $status = AgentExecutionStatus::RUNNING,
		private readonly array $interactionRequests = [],
		private readonly string $resumeHandle = '',
		private readonly string $createdAt = '',
		private readonly string $expiresAt = '',
		private readonly string $lifecycle = self::LIFECYCLE_ACTIVE,
		private readonly ?AgentSuspensionResolution $resolution = null,
		private readonly string $id = ''
	) {
		if (!in_array($this->status, AgentExecutionStatus::all(), true)) {
			throw new \InvalidArgumentException('Unsupported agent suspension state status: ' . $this->status);
		}
		if (!in_array($this->lifecycle, self::getAllowedLifecycles(), true)) {
			throw new \InvalidArgumentException('Unsupported agent suspension lifecycle: ' . $this->lifecycle);
		}
		if ($this->suspended && !AgentExecutionStatus::isSuspended($this->status)) {
			throw new \InvalidArgumentException('Suspended agent state requires an awaiting status.');
		}
		if ($this->suspended && $this->lifecycle !== self::LIFECYCLE_ACTIVE) {
			throw new \InvalidArgumentException('Suspended agent state requires the active lifecycle.');
		}
	}

	public function isSuspended(): bool { return $this->suspended; }
	public function isActive(): bool { return $this->lifecycle === self::LIFECYCLE_ACTIVE; }
	public function getStatus(): string { return $this->status; }
	/** @return array<int,mixed> */ public function getInteractionRequests(): array { return $this->interactionRequests; }
	public function getResumeHandle(): string { return $this->resumeHandle; }
	public function getCreatedAt(): string { return $this->createdAt; }
	public function getExpiresAt(): string { return $this->expiresAt; }
	public function getLifecycle(): string { return $this->lifecycle; }
	public function getResolution(): ?AgentSuspensionResolution { return $this->resolution; }
	public function getId(): string { return $this->id; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'id' => $this->id,
			'suspended' => $this->suspended,
			'status' => $this->status,
			'lifecycle' => $this->lifecycle,
			'interaction_requests' => array_map(
				static fn(mixed $value): mixed => $value instanceof AgentInteractionRequest
					? $value->toArray()
					: $value,
				$this->interactionRequests
			),
			'resume_handle' => $this->resumeHandle,
			'created_at' => $this->createdAt,
			'expires_at' => $this->expiresAt,
			'resolution' => $this->resolution?->toArray()
		];
	}

	/** @return array<int,string> */
	public static function getAllowedLifecycles(): array {
		return [self::LIFECYCLE_ACTIVE, self::LIFECYCLE_RESOLVED, self::LIFECYCLE_EXPIRED];
	}
}
