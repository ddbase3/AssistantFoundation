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
 * AgentExecutionResult
 *
 * Small immutable result object for non-streaming agent executions.
 */
final class AgentExecutionResult {

	/**
	 * @param array<string,mixed> $output
	 * @param array<string,mixed> $effectiveFlow
	 * @param array<int,string> $warnings
	 */
	public function __construct(
		private readonly array $output,
		private readonly array $effectiveFlow = [],
		private readonly array $warnings = []
	) {}

	/**
	 * @return array<string,mixed>
	 */
	public function getOutput(): array {
		return $this->output;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getEffectiveFlow(): array {
		return $this->effectiveFlow;
	}

	/**
	 * @return array<int,string>
	 */
	public function getWarnings(): array {
		return $this->warnings;
	}

}
