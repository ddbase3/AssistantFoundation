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

namespace AssistantFoundation\Api;

use AssistantFoundation\Dto\AgentToolCacheEntry;

/**
 * Interface IAgentToolResultCache
 *
 * Stores provider-neutral successful tool results behind stable cache keys.
 * Cache entries are disposable optimization data and must never be required
 * for semantic correctness.
 */
interface IAgentToolResultCache {

	/**
	 * Returns whether this runtime has an operational cache backend.
	 */
	public function isAvailable(): bool;

	/**
	 * Returns a valid cache entry or null when the key is absent or expired.
	 */
	public function get(string $key): ?AgentToolCacheEntry;

	/**
	 * Stores one cache entry for the requested TTL.
	 */
	public function put(string $key, AgentToolCacheEntry $entry, int $ttlSeconds): void;

	/**
	 * Removes one cache entry.
	 */
	public function delete(string $key): bool;
}
