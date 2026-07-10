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
 * Shared metadata envelope for chat, embedding, image, search, and future
 * AI operations.
 */
final class AiResultMetadata {

	/**
	 * @param array<string,mixed> $extra
	 */
	public function __construct(
		private readonly string $operation,
		private readonly string $provider = '',
		private readonly string $model = '',
		private readonly string $requestId = '',
		private readonly ?int $createdAt = null,
		private readonly ?float $durationMs = null,
		private readonly ?string $finishReason = null,
		private readonly ?AiUsage $usage = null,
		private readonly array $extra = []
	) {}

	public function getOperation(): string {
		return $this->operation;
	}

	public function getProvider(): string {
		return $this->provider;
	}

	public function getModel(): string {
		return $this->model;
	}

	public function getRequestId(): string {
		return $this->requestId;
	}

	public function getCreatedAt(): ?int {
		return $this->createdAt;
	}

	public function getDurationMs(): ?float {
		return $this->durationMs;
	}

	public function getFinishReason(): ?string {
		return $this->finishReason;
	}

	public function getUsage(): AiUsage {
		return $this->usage ?? AiUsage::none();
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getExtra(): array {
		return $this->extra;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'operation' => $this->operation,
			'provider' => $this->provider,
			'model' => $this->model,
			'request_id' => $this->requestId,
			'created_at' => $this->createdAt,
			'duration_ms' => $this->durationMs,
			'finish_reason' => $this->finishReason,
			'usage' => $this->getUsage()->toArray(),
			'extra' => $this->extra
		];
	}
}
