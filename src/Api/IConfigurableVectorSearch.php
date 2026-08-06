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
 * Configurable vector search implementation used by service drivers.
 *
 * The runtime configuration is supplied by the consuming application. Provider
 * plugins implement this contract and do not own connection persistence.
 */
interface IConfigurableVectorSearch extends IVectorSearch {

	/**
	 * @param array<string,mixed> $options
	 */
	public function setOptions(array $options): void;

	/**
	 * @return array<string,mixed>
	 */
	public function getOptions(): array;
}
