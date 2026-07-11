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
 * Serializable pause state returned when explicit user input is required.
 * Persistence and one-time resume handling belong to IAgentSuspensionRepository implementations.
 */
final class AgentSuspension {

	/**
	 * @param array<int,AgentInteractionRequest> $requests
	 * @param array<string,mixed> $state
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $id,
		private readonly string $status,
		private readonly array $requests,
		private readonly array $state,
		private readonly string $createdAt,
		private readonly array $metadata = []
	) {
		if (trim($id) === '') {
			throw new \InvalidArgumentException('Agent suspension id must not be empty.');
		}
		if (!AgentExecutionStatus::isSuspended($status)) {
			throw new \InvalidArgumentException('Agent suspension requires an awaiting status.');
		}
		if ($requests === []) {
			throw new \InvalidArgumentException('Agent suspension requires at least one interaction request.');
		}
		foreach ($requests as $request) {
			if (!$request instanceof AgentInteractionRequest) {
				throw new \InvalidArgumentException('Agent suspension requests must be AgentInteractionRequest instances.');
			}
		}
	}

	public function getId(): string { return $this->id; }
	public function getStatus(): string { return $this->status; }
	/** @return array<int,AgentInteractionRequest> */
	public function getRequests(): array { return $this->requests; }
	/** @return array<string,mixed> */
	public function getState(): array { return $this->state; }
	public function getCreatedAt(): string { return $this->createdAt; }
	/** @return array<string,mixed> */
	public function getMetadata(): array { return $this->metadata; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'id' => $this->id,
			'status' => $this->status,
			'requests' => array_map(
				static fn(AgentInteractionRequest $request): array => $request->toArray(),
				$this->requests
			),
			'state' => $this->state,
			'created_at' => $this->createdAt,
			'metadata' => $this->metadata
		];
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		$requests = [];
		foreach (($data['requests'] ?? []) as $request) {
			if (!is_array($request)) {
				throw new \InvalidArgumentException('Invalid agent suspension request payload.');
			}
			$requests[] = AgentInteractionRequest::fromArray($request);
		}

		return new self(
			trim((string)($data['id'] ?? '')),
			trim((string)($data['status'] ?? '')),
			$requests,
			is_array($data['state'] ?? null) ? $data['state'] : [],
			trim((string)($data['created_at'] ?? gmdate('c'))),
			is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}
}
