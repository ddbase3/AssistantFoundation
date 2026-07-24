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

use AssistantFoundation\Dto\AgentCapabilityCatalog;
use AssistantFoundation\Dto\AgentToolResult;

/**
 * Run-local, runtime-neutral tool set resolved from configured profiles.
 *
 * Implementations own the concrete tool instances and their execution context.
 * Agent runtimes only consume the normalized catalog and execute a selected
 * function through this boundary.
 */
interface IAgentToolSet {

	public function getCatalog(): AgentCapabilityCatalog;

	/** @return array<int,string> */
	public function getWarnings(): array;

	/**
	 * @param array<string,mixed> $arguments
	 * @param array<string,mixed> $metadata
	 */
	public function execute(
		string $callId,
		string $toolName,
		array $arguments,
		array $metadata = []
	): AgentToolResult;
}
