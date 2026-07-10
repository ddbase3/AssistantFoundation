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

use AssistantFoundation\Api\IAiResult;

final class AiSearchResult implements IAiResult {

	/**
	 * @param array<int,array<string,mixed>> $results
	 * @param array<int,array<string,mixed>> $citations
	 */
	public function __construct(
		private readonly string $query,
		private readonly string $answer,
		private readonly array $results,
		private readonly array $citations,
		private readonly AiResultMetadata $metadata,
		private readonly mixed $raw = null
	) {}

	public function getQuery(): string {
		return $this->query;
	}

	public function getAnswer(): string {
		return $this->answer;
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	public function getResults(): array {
		return $this->results;
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	public function getCitations(): array {
		return $this->citations;
	}

	public function getMetadata(): AiResultMetadata {
		return $this->metadata;
	}

	public function getRaw(): mixed {
		return $this->raw;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(bool $includeRaw = false): array {
		$result = [
			'query' => $this->query,
			'answer' => $this->answer,
			'results' => $this->results,
			'citations' => $this->citations,
			'metadata' => $this->metadata->toArray()
		];

		if($includeRaw) {
			$result['raw'] = $this->raw;
		}

		return $result;
	}
}
