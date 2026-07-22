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
 * Immutable transport-neutral input for one agent execution.
 */
final class AgentExecutionRequest {

	/**
	 * @param array<string,mixed> $agentConfiguration
	 * @param array<string,mixed> $inputs
	 * @param array<string,mixed> $context
	 */
	public function __construct(
		private readonly array $agentConfiguration,
		private readonly array $inputs = [],
		private readonly array $context = []
	) {}

	/** @return array<string,mixed> */
	public function getAgentConfiguration(): array {
		return $this->agentConfiguration;
	}

	/** @return array<string,mixed> */
	public function getInputs(): array {
		return $this->inputs;
	}

	/** @return array<string,mixed> */
	public function getContext(): array {
		return $this->context;
	}
}
