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
 * Immutable resolved model configuration including the exact request endpoint and credentials.
 */
final class AiModelConfiguration {

	/** @param array<string,mixed> $options */
	public function __construct(
		private readonly string $id,
		private readonly string $label,
		private readonly string $driver,
		private readonly string $model,
		private readonly string $endpoint,
		private readonly string $apiKey,
		private readonly array $options = []
	) {}

	public function getId(): string { return $this->id; }
	public function getLabel(): string { return $this->label; }
	public function getDriver(): string { return $this->driver; }
	public function getModel(): string { return $this->model; }
	public function getEndpoint(): string { return $this->endpoint; }
	public function getApiKey(): string { return $this->apiKey; }
	/** @return array<string,mixed> */ public function getOptions(): array { return $this->options; }
}
