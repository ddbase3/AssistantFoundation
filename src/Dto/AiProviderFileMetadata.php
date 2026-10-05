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

final class AiProviderFileMetadata {

	public function __construct(
		private readonly string $opaqueId,
		private readonly string $filename,
		private readonly int $size,
		private readonly ?int $expiresAt = null
	) {}

	public function getOpaqueId(): string {
		return $this->opaqueId;
	}

	public function getFilename(): string {
		return $this->filename;
	}

	public function getSize(): int {
		return $this->size;
	}

	public function getExpiresAt(): ?int {
		return $this->expiresAt;
	}

	public function isExpired(?int $now = null): bool {
		return $this->expiresAt !== null && $this->expiresAt <= ($now ?? time());
	}
}
