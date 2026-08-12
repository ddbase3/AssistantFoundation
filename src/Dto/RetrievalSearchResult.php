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

final class RetrievalSearchResult {

	/**
	 * @param RetrievalHit[] $hits
	 * @param string[] $channels
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly array $hits,
		private readonly array $channels = [],
		private readonly array $metadata = []
	) {}

	/**
	 * @return RetrievalHit[]
	 */
	public function getHits(): array {
		return $this->hits;
	}

	/**
	 * @return string[]
	 */
	public function getChannels(): array {
		return $this->channels;
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
			'hits' => array_map(
				static fn(RetrievalHit $hit): array => $hit->toArray(),
				$this->hits
			),
			'channels' => $this->channels,
			'metadata' => $this->metadata
		];
	}
}
