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
	 * Executes a simple AI task and returns the final assistant answer.
	 *
	 * The implementation is responsible for:
	 * - creating the agent context
	 * - creating and running the flow
	 * - injecting the task inputs into the flow
	 * - extracting the final assistant response
	 *
	 * @param string $systemPrompt Complete system instruction
	 * @param string $userPrompt User task input
	 * @param array $agentFlow AgentFlow configuration
	 * @return string Final assistant response
	 */
	public function run(string $systemPrompt, string $userPrompt, array $agentFlow): string;
}
