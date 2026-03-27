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
 * Interface IVectorSearch
 *
 * Defines a generic contract for vector similarity search.
 * Implementations may wrap Qdrant, Pinecone, Weaviate, FAISS, etc.
 */
interface IVectorSearch {

	/**
	 * Search the vector store for the most similar items.
	 *
	 * @param array<float> $vector   The embedding vector to search for.
	 * @param int          $limit    Maximum number of results to return.
	 * @param float|null   $minScore Optional similarity threshold (0..1).
	 *
	 * @return array<int, array<string,mixed>> Results including payload and score.
	 */
	public function search(array $vector, int $limit = 3, ?float $minScore = null): array;
}

