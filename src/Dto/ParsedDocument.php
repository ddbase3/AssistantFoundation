<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation provides shared contracts, DTOs, models and
 * exceptions for assistant and agent integrations.
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
 * Provider-neutral structured document representation.
 *
 * Parser integrations may preserve their native response separately, while
 * downstream consumers can rely on this normalized sequence of semantic blocks.
 */
final class ParsedDocument {

	/**
	 * @param array<int,ParsedDocumentBlock> $blocks
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $title,
		private readonly array $blocks,
		private readonly array $metadata = []
	) {}

	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @return array<int,ParsedDocumentBlock>
	 */
	public function getBlocks(): array {
		return $this->blocks;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	public function getText(): string {
		$parts = [];

		foreach ($this->blocks as $block) {
			if (!$block instanceof ParsedDocumentBlock) {
				continue;
			}

			$text = trim($block->getText());
			if ($text !== '') {
				$parts[] = $text;
			}
		}

		return trim(implode("\n\n", $parts));
	}
}
