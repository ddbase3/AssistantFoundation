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

namespace AssistantFoundation\Api;

use Base3\Api\IBase;
use AssistantFoundation\Dto\AgentExecutionResult;

/**
 * IAgentExecutionService
 *
 * Executes configured MissionBay agents for HTTP endpoints, jobs and other
 * runtime callers. The caller owns storage, request parsing and response
 * formatting; this service owns context creation, effective flow building and
 * flow execution.
 */
interface IAgentExecutionService extends IBase {

	/**
	 * Builds the effective runtime flow configuration from stored agent settings.
	 *
	 * @param array<string,mixed> $agentSettings
	 * @return array<string,mixed>
	 */
	public function buildEffectiveFlow(array $agentSettings): array;

	/**
	 * Executes the configured agent and returns terminal flow output.
	 *
	 * @param array<string,mixed> $agentSettings
	 * @param array<string,mixed> $inputs
	 * @param array<string,mixed> $contextVars
	 */
	public function run(array $agentSettings, array $inputs = [], array $contextVars = []): AgentExecutionResult;

	/**
	 * Executes the configured agent for streaming flows.
	 *
	 * Streaming output is produced by the configured streaming node. This method
	 * intentionally returns no payload.
	 *
	 * @param array<string,mixed> $agentSettings
	 * @param array<string,mixed> $inputs
	 * @param array<string,mixed> $contextVars
	 */
	public function stream(array $agentSettings, array $inputs = [], array $contextVars = []): void;

	/**
	 * Returns non-fatal warnings from the last effective flow build.
	 *
	 * @return array<int,string>
	 */
	public function getWarnings(): array;

}
