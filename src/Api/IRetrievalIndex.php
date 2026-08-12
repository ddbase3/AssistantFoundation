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

use AssistantFoundation\Dto\RetrievalIndexItem;
use AssistantFoundation\Dto\RetrievalSearchRequest;
use AssistantFoundation\Dto\RetrievalSearchResult;

/**
 * Generic storage and retrieval contract for multi-representation search indexes.
 */
interface IRetrievalIndex {

	public function upsert(RetrievalIndexItem $item): void;

	public function existsByHash(string $collectionKey, string $hash): bool;

	/**
	 * @param array<string,mixed> $filter
	 */
	public function existsByFilter(string $collectionKey, array $filter): bool;

	/**
	 * @param array<string,mixed> $filter
	 */
	public function deleteByFilter(string $collectionKey, array $filter): int;

	public function search(RetrievalSearchRequest $request): RetrievalSearchResult;

	/**
	 * Loads neighboring items around a previously returned point while applying
	 * the supplied mandatory retrieval filter again.
	 *
	 * @param array<string,mixed>|null $filterSpec
	 */
	public function context(
		string $collectionKey,
		string $pointId,
		int $before = 1,
		int $after = 1,
		?array $filterSpec = null
	): RetrievalSearchResult;

	public function createCollection(string $collectionKey): void;

	public function deleteCollection(string $collectionKey): void;

	/**
	 * @return array<string,mixed>
	 */
	public function getInfo(string $collectionKey): array;
}
