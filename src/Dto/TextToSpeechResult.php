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

use MediaFoundation\Api\IAudioMedia;

final class TextToSpeechResult {

	/**
	 * Complete synthesis results carry $audio. Streaming results may leave
	 * it null because audio is delivered through ITextToSpeechStream.
	 *
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $mimeType,
		private readonly ?IAudioMedia $audio = null,
		private readonly array $metadata = [],
		private readonly mixed $raw = null
	) {}

	public function getMimeType(): string {
		return $this->mimeType;
	}

	public function getAudio(): ?IAudioMedia {
		return $this->audio;
	}

	public function hasAudio(): bool {
		return $this->audio !== null;
	}

	/** @return array<string,mixed> */
	public function getMetadata(): array {
		return $this->metadata;
	}

	public function getRaw(): mixed {
		return $this->raw;
	}
}
