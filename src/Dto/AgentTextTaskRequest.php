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
 * Immutable request for one isolated non-conversational text task.
 */
final class AgentTextTaskRequest {

	/**
	 * @param array<string,mixed> $agentConfiguration
	 * @param array<string,mixed> $context
	 */
	public function __construct(
		private readonly array $agentConfiguration,
		private readonly string $taskName,
		private readonly string $systemPrompt,
		private readonly string $prompt,
		private readonly array $context = [],
		private readonly bool $includeContextProfile = false,
		private readonly bool $includeToolProfile = false
	) {
		if (!$this->isTechnicalName($this->taskName)) {
			throw new \InvalidArgumentException('Agent text task requires a valid task name.');
		}
		if (trim($this->prompt) === '') {
			throw new \InvalidArgumentException('Agent text task requires a prompt.');
		}
	}

	/** @return array<string,mixed> */
	public function getAgentConfiguration(): array {
		return $this->agentConfiguration;
	}

	public function getTaskName(): string {
		return $this->taskName;
	}

	public function getSystemPrompt(): string {
		return trim($this->systemPrompt);
	}

	public function getPrompt(): string {
		return trim($this->prompt);
	}

	/** @return array<string,mixed> */
	public function getContext(): array {
		return $this->context;
	}

	public function shouldIncludeContextProfile(): bool {
		return $this->includeContextProfile;
	}

	public function shouldIncludeToolProfile(): bool {
		return $this->includeToolProfile;
	}

	private function isTechnicalName(string $value): bool {
		$value = trim($value);
		return $value !== ''
			&& strlen($value) <= 100
			&& preg_match('/^[a-z0-9._-]+$/', $value) === 1;
	}
}
