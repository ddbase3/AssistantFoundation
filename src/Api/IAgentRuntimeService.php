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

/**
 * Named agent runtime implementation discoverable through the BASE3 class map.
 */
interface IAgentRuntimeService extends IAgentExecutionService {

	public static function getRuntimeId(): string;

	public static function getRuntimeLabel(): string;

	public static function getRuntimeDescription(): string;

	/**
	 * Higher values win when no host-specific selector and no stored runtime are available.
	 */
	public static function getDefaultPriority(): int;
}
