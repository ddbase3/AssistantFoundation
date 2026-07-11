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
 * AgentToolCacheEntry
 *
 * Serializable provider-neutral cached tool output with provenance.
 */
final class AgentToolCacheEntry {

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $toolIdentity,
		private readonly string $toolName,
		private readonly string $argumentsHash,
		private readonly string $scope,
		private readonly mixed $output,
		private readonly string $createdAt,
		private readonly string $expiresAt,
		private readonly array $metadata = []
	) {
		if (trim($this->toolIdentity) === '' || trim($this->toolName) === '') {
			throw new \InvalidArgumentException('Tool-cache entry requires tool identity and tool name.');
		}
	}

	/**
	 * @param array<string,mixed> $data
	 */
	public static function fromArray(array $data): self {
		return new self(
			toolIdentity: (string)($data['tool_identity'] ?? ''),
			toolName: (string)($data['tool'] ?? ''),
			argumentsHash: (string)($data['arguments_hash'] ?? ''),
			scope: (string)($data['scope'] ?? ''),
			output: $data['output'] ?? null,
			createdAt: (string)($data['created_at'] ?? ''),
			expiresAt: (string)($data['expires_at'] ?? ''),
			metadata: is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}

	public function getToolIdentity(): string {
		return $this->toolIdentity;
	}

	public function getToolName(): string {
		return $this->toolName;
	}

	public function getArgumentsHash(): string {
		return $this->argumentsHash;
	}

	public function getScope(): string {
		return $this->scope;
	}

	public function getOutput(): mixed {
		return $this->output;
	}

	public function getCreatedAt(): string {
		return $this->createdAt;
	}

	public function getExpiresAt(): string {
		return $this->expiresAt;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'tool_identity' => $this->toolIdentity,
			'tool' => $this->toolName,
			'arguments_hash' => $this->argumentsHash,
			'scope' => $this->scope,
			'output' => $this->output,
			'created_at' => $this->createdAt,
			'expires_at' => $this->expiresAt,
			'metadata' => $this->metadata
		];
	}
}
