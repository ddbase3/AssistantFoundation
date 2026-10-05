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

final class AiFileResource {

	public function __construct(
		private readonly string $path,
		private readonly string $name,
		private readonly string $mimeType,
		private readonly string $content,
		private readonly string $contentHash
	) {}

	public function getPath(): string {
		return $this->path;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getMimeType(): string {
		return $this->mimeType;
	}

	public function getContent(): string {
		return $this->content;
	}

	public function getContentHash(): string {
		return $this->contentHash;
	}

	public function getSize(): int {
		return strlen($this->content);
	}
}
