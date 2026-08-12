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

/**
 * Read-only diagnostic access to stored retrieval points.
 *
 * This contract is intended for administration and diagnostics. It returns
 * stored payload data and optional vector metadata and must not be exposed as
 * an agent-facing retrieval result without an explicit domain projection.
 */
interface IRetrievalIndexInspector {

	/**
	 * Returns one page of stored points from a logical retrieval collection.
	 *
	 * The implementation resolves the logical collection key through the active
	 * IRetrievalCollectionDefinition. Vector values are not returned; when
	 * $withVectorSummary is enabled only backend-neutral vector metadata is
	 * included.
	 *
	 * @param array<string,mixed>|null $filterSpec Structured retrieval filter
	 * @return array{
	 *     collection_key:string,
	 *     collection:string,
	 *     points:array<int,array<string,mixed>>,
	 *     next_offset:string|int|null
	 * }
	 */
	public function inspectPoints(
		string $collectionKey,
		int $limit = 10,
		?array $filterSpec = null,
		string|int|null $offset = null,
		bool $withVectorSummary = false
	): array;
}
