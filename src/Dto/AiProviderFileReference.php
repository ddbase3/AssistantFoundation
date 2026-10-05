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

final class AiProviderFileReference {

	public function __construct(
		private readonly string $provider,
		private readonly string $opaqueId,
		private readonly string $contentHash,
		private readonly string $filename,
		private readonly string $mimeType,
		private readonly int $size,
		private readonly ?int $expiresAt = null
	) {}

	public function getProvider(): string {
		return $this->provider;
	}

	public function getOpaqueId(): string {
		return $this->opaqueId;
	}

	public function getContentHash(): string {
		return $this->contentHash;
	}

	public function getFilename(): string {
		return $this->filename;
	}

	public function getMimeType(): string {
		return $this->mimeType;
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

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'provider' => $this->provider,
			'opaque_id' => $this->opaqueId,
			'content_hash' => $this->contentHash,
			'filename' => $this->filename,
			'mime_type' => $this->mimeType,
			'size' => $this->size,
			'expires_at' => $this->expiresAt,
		];
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): ?self {
		$provider = trim((string)($data['provider'] ?? ''));
		$opaqueId = trim((string)($data['opaque_id'] ?? ''));
		$contentHash = trim((string)($data['content_hash'] ?? ''));
		$filename = trim((string)($data['filename'] ?? ''));
		$mimeType = trim((string)($data['mime_type'] ?? ''));
		$size = (int)($data['size'] ?? 0);
		$expiresAt = isset($data['expires_at']) && is_numeric($data['expires_at'])
			? (int)$data['expires_at']
			: null;

		if ($provider === '' || $opaqueId === '' || $contentHash === '' || $filename === '') {
			return null;
		}

		return new self(
			$provider,
			$opaqueId,
			$contentHash,
			$filename,
			$mimeType,
			max(0, $size),
			$expiresAt
		);
	}
}
