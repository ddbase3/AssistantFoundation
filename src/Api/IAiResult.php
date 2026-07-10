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

use AssistantFoundation\Dto\AiResultMetadata;

/**
 * Common result contract for all AI operations.
 *
 * Chat, embedding, image, search, and future audio/video/document result
 * DTOs expose the same metadata and raw-response boundary.
 */
interface IAiResult {

	public function getMetadata(): AiResultMetadata;

	public function getRaw(): mixed;

	/**
	 * Returns a stable provider-neutral representation.
	 *
	 * Raw provider data is excluded by default because it can be large or
	 * contain provider-specific or sensitive details.
	 *
	 * @return array<string,mixed>
	 */
	public function toArray(bool $includeRaw = false): array;
}
