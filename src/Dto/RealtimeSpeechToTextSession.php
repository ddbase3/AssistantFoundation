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

final class RealtimeSpeechToTextSession {

	/**
	 * @param array<string,mixed> $options
	 */
	public function __construct(
		private readonly string $provider,
		private readonly string $transport,
		private readonly string $endpoint,
		private readonly string $clientToken,
		private readonly string $expiresAt,
		private readonly string $model,
		private readonly string $audioEncoding,
		private readonly int $sampleRate,
		private readonly array $options = []
	) {}

	public function getProvider(): string {
		return $this->provider;
	}

	public function getTransport(): string {
		return $this->transport;
	}

	public function getEndpoint(): string {
		return $this->endpoint;
	}

	public function getClientToken(): string {
		return $this->clientToken;
	}

	public function getExpiresAt(): string {
		return $this->expiresAt;
	}

	public function getModel(): string {
		return $this->model;
	}

	public function getAudioEncoding(): string {
		return $this->audioEncoding;
	}

	public function getSampleRate(): int {
		return $this->sampleRate;
	}

	/** @return array<string,mixed> */
	public function getOptions(): array {
		return $this->options;
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'provider' => $this->provider,
			'transport' => $this->transport,
			'endpoint' => $this->endpoint,
			'clientToken' => $this->clientToken,
			'expiresAt' => $this->expiresAt,
			'model' => $this->model,
			'audioEncoding' => $this->audioEncoding,
			'sampleRate' => $this->sampleRate,
			'options' => $this->options
		];
	}
}
