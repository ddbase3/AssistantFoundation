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

interface IAiTaskService {

	/**
	 * Executes a simple AI task based on a system prompt and an agent flow
	 * definition and returns the final assistant answer as plain text.
	 *
	 * The implementation is responsible for:
	 * - creating the agent context
	 * - creating and running the flow
	 * - injecting the system prompt into the flow inputs
	 * - extracting the final assistant response from the flow result
	 *
	 * @param string $systemPrompt Complete instruction for the task
	 * @param array $agentFlow AgentFlow configuration as array
	 * @return string Final assistant response
	 */
	public function run(string $systemPrompt, array $agentFlow): string;
}
