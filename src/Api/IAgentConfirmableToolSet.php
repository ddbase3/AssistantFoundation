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

use AssistantFoundation\Dto\AgentInteractionResponse;
use AssistantFoundation\Dto\AgentSuspension;
use AssistantFoundation\Dto\AgentToolResult;

/**
 * Optional extension for tool sets that can suspend mutating calls for an
 * explicit user decision and later execute the exact reviewed action.
 */
interface IAgentConfirmableToolSet extends IAgentToolSet {

	/**
	 * Returns a server-owned suspension when the selected tool call requires
	 * confirmation, or null when the call may execute immediately.
	 *
	 * @param array<string,mixed> $arguments
	 * @param array<string,mixed> $metadata
	 */
	public function prepareSuspension(
		string $callId,
		string $toolName,
		array $arguments,
		array $metadata = []
	): ?AgentSuspension;

	/**
	 * Applies one explicit interaction response to a previously created
	 * suspension and returns the resulting tool observation.
	 *
	 * @param array<string,mixed> $metadata
	 */
	public function resumeSuspension(
		AgentSuspension $suspension,
		AgentInteractionResponse $response,
		array $metadata = []
	): AgentToolResult;
}
