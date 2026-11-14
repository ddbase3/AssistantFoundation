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

namespace Base3\AssistantFoundation\Api;

use Base3\AssistantFoundation\Dto\AgentExecutionRequest;
use Base3\AssistantFoundation\Dto\AgentExecutionResult;
use Base3\CoreFoundation\Api\IBase;

/**
 * Executes one agent request independently of HTTP transport and UI concerns.
 *
 * Implementations own agent configuration resolution and runtime execution.
 * Callers own request parsing, persistence, event transport and response
 * formatting. Incremental output is delivered through the optional event sink.
 */
interface IAgentExecutionService extends IBase {

	public function execute(
		AgentExecutionRequest $request,
		?IAgentEventSink $eventSink = null
	): AgentExecutionResult;
}
