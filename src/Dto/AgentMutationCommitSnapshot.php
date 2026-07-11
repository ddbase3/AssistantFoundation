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
 * AgentMutationCommitSnapshot
 *
 * Immutable state captured before a mutation is shown to the user. A guarded
 * mutation tool can store the authorization subject and resource versions or
 * ETags that must still be valid immediately before the write is committed.
 */
final class AgentMutationCommitSnapshot {

	private readonly string $capturedAt;

	/**
	 * @param array<string,mixed> $authorization
	 * @param array<string,mixed> $resourceVersions
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $actionId,
		private readonly string $actionFingerprint,
		private readonly array $authorization = [],
		private readonly array $resourceVersions = [],
		string $capturedAt = '',
		private readonly array $metadata = []
	) {
		if (trim($this->actionId) === '') {
			throw new \InvalidArgumentException('Mutation commit snapshot action id must not be empty.');
		}
		if (trim($this->actionFingerprint) === '') {
			throw new \InvalidArgumentException('Mutation commit snapshot fingerprint must not be empty.');
		}
		$this->capturedAt = trim($capturedAt) !== '' ? trim($capturedAt) : gmdate('c');
	}

	public function getActionId(): string {
		return $this->actionId;
	}

	public function getActionFingerprint(): string {
		return $this->actionFingerprint;
	}

	/** @return array<string,mixed> */
	public function getAuthorization(): array {
		return $this->authorization;
	}

	/** @return array<string,mixed> */
	public function getResourceVersions(): array {
		return $this->resourceVersions;
	}

	public function getCapturedAt(): string {
		return $this->capturedAt;
	}

	/** @return array<string,mixed> */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'action_id' => $this->actionId,
			'action_fingerprint' => $this->actionFingerprint,
			'authorization' => $this->authorization,
			'resource_versions' => $this->resourceVersions,
			'captured_at' => $this->getCapturedAt(),
			'metadata' => $this->metadata
		];
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		return new self(
			trim((string)($data['action_id'] ?? '')),
			trim((string)($data['action_fingerprint'] ?? '')),
			is_array($data['authorization'] ?? null) ? $data['authorization'] : [],
			is_array($data['resource_versions'] ?? null) ? $data['resource_versions'] : [],
			trim((string)($data['captured_at'] ?? '')),
			is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}
}
