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
 * Provides mandatory or reusable retrieval filter conditions.
 */
interface IRetrievalFilterProvider {

	/**
	 * Filter structure:
	 *
	 * [
	 *     'must' => [
	 *         ['field' => 'scope', 'operator' => 'eq', 'value' => 'public']
	 *     ],
	 *     'should' => [],
	 *     'must_not' => []
	 * ]
	 *
	 * @return array<string,mixed>|null
	 */
	public function getRetrievalFilter(): ?array;
}
