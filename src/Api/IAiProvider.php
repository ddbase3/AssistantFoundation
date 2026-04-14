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

interface IAiProvider extends IBase {

	/**
	 * Sets provider-specific runtime options like endpoint, api key or timeout.
	 *
	 * @param array $options
	 * @return void
	 */
	public function setOptions(array $options): void;

	/**
	 * Returns the currently active provider options.
	 *
	 * @return array
	 */
	public function getOptions(): array;

	/**
	 * Sends a request to the provider and returns the decoded response.
	 *
	 * @param string $path Relative or provider-specific API path
	 * @param array $payload Request payload
	 * @param array $options Optional request options
	 * @return array Decoded response data
	 */
	public function request(string $path, array $payload, array $options = []): array;

	/**
	 * Sends a streaming request to the provider.
	 *
	 * The provider implementation MUST:
	 * - open the streaming connection
	 * - forward incoming chunks to $onChunk
	 * - stop when the remote side signals completion
	 *
	 * @param string $path Relative or provider-specific API path
	 * @param array $payload Request payload
	 * @param callable $onChunk function(string $chunk) : void
	 * @param array $options Optional request options
	 * @return void
	 */
	public function stream(string $path, array $payload, callable $onChunk, array $options = []): void;
}
