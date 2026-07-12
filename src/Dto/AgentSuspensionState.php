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
 * Stable user-interaction and resume state for a paused agent run.
 */
final class AgentSuspensionState {

	/** @param array<int,mixed> $interactionRequests */
	public function __construct(
		private readonly bool $suspended = false,
		private readonly string $status = AgentExecutionStatus::RUNNING,
		private readonly array $interactionRequests = [],
		private readonly string $resumeHandle = ''
	) {
		if (!in_array($this->status, AgentExecutionStatus::all(), true)) {
			throw new \InvalidArgumentException('Unsupported agent suspension state status: ' . $this->status);
		}
		if ($this->suspended && !AgentExecutionStatus::isSuspended($this->status)) {
			throw new \InvalidArgumentException('Suspended agent state requires an awaiting status.');
		}
	}

	public function isSuspended(): bool { return $this->suspended; }
	public function getStatus(): string { return $this->status; }
	/** @return array<int,mixed> */ public function getInteractionRequests(): array { return $this->interactionRequests; }
	public function getResumeHandle(): string { return $this->resumeHandle; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'suspended' => $this->suspended,
			'status' => $this->status,
			'interaction_requests' => array_map(
				static fn(mixed $value): mixed => is_object($value) && method_exists($value, 'toArray')
					? $value->toArray()
					: $value,
				$this->interactionRequests
			),
			'resume_handle' => $this->resumeHandle
		];
	}
}
