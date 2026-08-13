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
 * File input for a shared parser service.
 */
final class ParserFileRequest {

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $path,
		private readonly string $filename = '',
		private readonly array $metadata = []
	) {}

	public function getPath(): string {
		return $this->path;
	}

	public function getFilename(): string {
		$filename = trim($this->filename);
		return $filename !== '' ? $filename : basename($this->path);
	}

	public function getExtension(): string {
		$extension = strtolower(pathinfo($this->getFilename(), PATHINFO_EXTENSION));
		if($extension === '') {
			$extension = strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
		}

		return $extension;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}
}
