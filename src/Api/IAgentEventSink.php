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

use AssistantFoundation\Dto\AgentExecutionEvent;

/**
 * Transport-neutral receiver for incremental agent execution events.
 *
 * Sinks are run-scoped objects. They may forward events to SSE, collect them
 * for another transport, write diagnostics or discard them.
 */
interface IAgentEventSink {

	public const CONTEXT_KEY = 'agent_event_sink';

	public function emit(AgentExecutionEvent $event): void;

	public function isCancelled(): bool;
}
