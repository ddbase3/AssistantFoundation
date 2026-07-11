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
 * AgentToolCacheRule
 *
 * Explicit opt-in rule for caching one provider-neutral tool function.
 */
final class AgentToolCacheRule {

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $toolName,
		private readonly int $ttlSeconds,
		private readonly string $resourceId = '',
		private readonly string $implementationName = '',
		private readonly string $variant = '',
		private readonly array $metadata = []
	) {
		if (trim($this->toolName) === '') {
			throw new \InvalidArgumentException('Tool-cache rule requires a tool name.');
		}

		if ($this->ttlSeconds < 1) {
			throw new \InvalidArgumentException('Tool-cache TTL must be greater than zero.');
		}
	}

	/**
	 * @param array<string,mixed> $data
	 */
	public static function fromArray(array $data): self {
		return new self(
			toolName: trim((string)($data['tool'] ?? $data['tool_name'] ?? '')),
			ttlSeconds: (int)($data['ttl_seconds'] ?? $data['ttl'] ?? 0),
			resourceId: trim((string)($data['resource_id'] ?? '')),
			implementationName: trim((string)($data['implementation'] ?? $data['implementation_name'] ?? '')),
			variant: trim((string)($data['variant'] ?? '')),
			metadata: is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}

	public function matches(string $toolName, string $resourceId, string $implementationName): bool {
		if ($this->toolName !== $toolName) {
			return false;
		}

		if ($this->resourceId !== '' && $this->resourceId !== $resourceId) {
			return false;
		}

		if ($this->implementationName !== '' && $this->implementationName !== $implementationName) {
			return false;
		}

		return true;
	}

	public function getToolName(): string {
		return $this->toolName;
	}

	public function getTtlSeconds(): int {
		return $this->ttlSeconds;
	}

	public function getResourceId(): string {
		return $this->resourceId;
	}

	public function getImplementationName(): string {
		return $this->implementationName;
	}

	public function getVariant(): string {
		return $this->variant;
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
			'tool' => $this->toolName,
			'ttl_seconds' => $this->ttlSeconds,
			'resource_id' => $this->resourceId,
			'implementation' => $this->implementationName,
			'variant' => $this->variant,
			'metadata' => $this->metadata
		];
	}
}
