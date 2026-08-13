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
 * Shared parser service result.
 *
 * text is the normalized text representation.
 * structured is the parser-family representation suitable for further parsing.
 * raw preserves the original provider response where available.
 */
final class ParserServiceResult {

	/**
	 * @param array<string,mixed> $metadata
	 * @param array<int,mixed> $attachments
	 */
	public function __construct(
		private readonly string $text,
		private readonly mixed $structured = null,
		private readonly array $metadata = [],
		private readonly array $attachments = [],
		private readonly mixed $raw = null
	) {}

	public function getText(): string {
		return $this->text;
	}

	public function getStructured(): mixed {
		return $this->structured;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * @return array<int,mixed>
	 */
	public function getAttachments(): array {
		return $this->attachments;
	}

	public function getRaw(): mixed {
		return $this->raw;
	}
}
