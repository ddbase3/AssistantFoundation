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
 * One normalized semantic block inside a parsed document.
 */
final class ParsedDocumentBlock {

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $type,
		private readonly string $text,
		private readonly int $level = 0,
		private readonly ?int $page = null,
		private readonly array $metadata = []
	) {}

	public function getType(): string {
		return $this->type;
	}

	public function getText(): string {
		return $this->text;
	}

	public function getLevel(): int {
		return $this->level;
	}

	public function getPage(): ?int {
		return $this->page;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}
}
