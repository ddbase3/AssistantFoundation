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

/**
 * Owns the schema and external retrieval view of one or more logical collections.
 */
interface IRetrievalCollectionDefinition {

	/**
	 * @return string[]
	 */
	public function getCollectionKeys(): array;

	public function getBackendCollectionName(string $collectionKey): string;

	/**
	 * Returns backend-neutral retrieval representations such as dense, lexical,
	 * phonetic, phrase, and phonetic_phrase.
	 *
	 * @return array<string,array<string,mixed>>
	 */
	public function getIndexSchema(string $collectionKey): array;

	/**
	 * @return array<string,array<string,mixed>>
	 */
	public function getPayloadSchema(string $collectionKey): array;

	/**
	 * Returns fields and operators that callers may expose as user/agent filters.
	 * Fields not listed here are not externally filterable.
	 *
	 * @return array<string,array<string,mixed>>
	 */
	public function getAgentFilterSchema(string $collectionKey): array;

	/**
	 * Returns payload fields that may leave the retrieval boundary.
	 *
	 * @return string[]
	 */
	public function getAgentContextFields(string $collectionKey): array;

	/**
	 * Returns the payload fields used to identify one document and its chunk order.
	 *
	 * Expected keys:
	 * - group_field
	 * - position_field
	 *
	 * @return array<string,string>
	 */
	public function getContextSchema(string $collectionKey): array;

	/**
	 * Returns technical IPhoneticEncoder names materialized for this collection.
	 * The optional context lets a domain collection select encoders from metadata
	 * such as a content language without exposing those metadata conventions here.
	 *
	 * @param array<string,mixed> $context
	 * @return string[]
	 */
	public function getPhoneticEncoderNames(string $collectionKey, array $context = []): array;

	public function validate(RetrievalIndexItem $item): void;

	/**
	 * @return array<string,mixed>
	 */
	public function buildPayload(RetrievalIndexItem $item): array;

	/**
	 * Projects a stored payload to the explicitly permitted retrieval context.
	 *
	 * @param array<string,mixed> $payload
	 * @return array<string,mixed>
	 */
	public function projectPayload(string $collectionKey, array $payload): array;
}
