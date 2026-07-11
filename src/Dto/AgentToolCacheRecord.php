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
 * AgentToolCacheRecord
 *
 * Immutable diagnostic record for a cache lookup or write decision.
 */
final class AgentToolCacheRecord {

	public const STATUS_HIT = 'hit';
	public const STATUS_MISS = 'miss';
	public const STATUS_BYPASS = 'bypass';
	public const STATUS_STORED = 'stored';
	public const STATUS_SKIPPED = 'skipped';
	public const STATUS_ERROR = 'error';

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly string $callId,
		private readonly string $toolName,
		private readonly string $toolIdentity,
		private readonly string $status,
		private readonly string $cacheKey = '',
		private readonly string $scope = '',
		private readonly int $ttlSeconds = 0,
		private readonly string $reason = '',
		private readonly array $metadata = []
	) {
		if (!in_array($this->status, self::getAllowedStatuses(), true)) {
			throw new \InvalidArgumentException('Unsupported tool-cache record status: ' . $this->status);
		}
	}

	public function getStatus(): string {
		return $this->status;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'iteration' => $this->iteration,
			'call_id' => $this->callId,
			'tool' => $this->toolName,
			'tool_identity' => $this->toolIdentity,
			'status' => $this->status,
			'cache_key' => $this->cacheKey,
			'scope' => $this->scope,
			'ttl_seconds' => $this->ttlSeconds,
			'reason' => $this->reason,
			'metadata' => $this->metadata
		];
	}

	/**
	 * @return array<int,string>
	 */
	public static function getAllowedStatuses(): array {
		return [
			self::STATUS_HIT,
			self::STATUS_MISS,
			self::STATUS_BYPASS,
			self::STATUS_STORED,
			self::STATUS_SKIPPED,
			self::STATUS_ERROR
		];
	}
}
