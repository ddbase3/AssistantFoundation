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
 * One chunk prepared for a multi-representation retrieval index.
 */
final class RetrievalIndexItem {

	/** @var array<float> */
	public array $denseVector;

	/** @var array<string,string> */
	public array $representations;

	/**
	 * @param array<string,mixed> $metadata
	 * @param array<float> $denseVector
	 * @param array<string,string> $representations
	 */
	public function __construct(
		public string $collectionKey,
		public int $chunkIndex,
		public string $text,
		public string $hash,
		public array $metadata = [],
		array $denseVector = [],
		array $representations = []
	) {
		$this->denseVector = $denseVector;
		$this->representations = $representations;
	}

	public function hasDenseVector(): bool {
		return $this->denseVector !== [];
	}

	public function getRepresentation(string $name): string {
		$value = $this->representations[$name] ?? '';
		return is_string($value) ? trim($value) : '';
	}
}
