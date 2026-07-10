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

/**
 * Interface for a flow-wide agent execution context.
 * Carries memory, scoped variables, and possibly other runtime state.
 */
interface IAgentContext extends IBase {

	/**
	 * Returns the associated memory instance for this context.
	 *
	 * @return IAgentMemory
	 */
	public function getMemory(): IAgentMemory;

	/**
	 * Replaces the memory instance at runtime.
	 * Useful for subflows, testing, or switching memory strategies dynamically.
	 *
	 * @param IAgentMemory $memory
	 */
	public function setMemory(IAgentMemory $memory): void;

	/**
	 * Sets an agent-run-scoped variable.
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function setVar(string $key, mixed $value): void;

	/**
	 * Retrieves an agent-run-scoped variable.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getVar(string $key): mixed;

	/**
	 * Forgets an agent-run-scoped variable.
	 *
	 * @param string $key
	 */
	public function forgetVar(string $key): void;

	/**
	 * Returns a list of all variable keys.
	 *
	 * @return string[]
	 */
	public function listVars(): array;
}
