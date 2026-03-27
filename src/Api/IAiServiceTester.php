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

interface IAiServiceTester {

	/**
	 * Returns the service type this tester supports,
	 * e.g. "openai", "qdrant", "deepl".
	 *
	 * @return string
	 */
	public static function getType(): string;

	/**
	 * Performs a quick health test and returns array with status & message.
	 *
	 * Example:
	 * return [
	 *     'ok' => true,
	 *     'message' => 'Models reachable',
	 *     'details' => ['modelCount' => 37]
	 * ];
	 *
	 * @param array $config
	 * @return array
	 */
	public function test(array $config): array;
}
