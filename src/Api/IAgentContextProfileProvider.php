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

use Base3\AssistantFoundation\Dto\AgentContextProfileResult;
use Base3\AssistantFoundation\Dto\AgentExecutionRequest;
use Base3\CoreFoundation\Api\IBase;

/**
 * Runtime-neutral provider for configured context profiles.
 *
 * A provider owns the storage and materialization details of its profiles.
 * Consumers only receive normalized instruction blocks for one execution.
 */
interface IAgentContextProfileProvider extends IBase {

	public static function getProviderId(): string;

	/** @return array<int,array<string,mixed>> */
	public function getOptions(): array;

	public function hasProfile(string $profileId): bool;

	public function build(
		string $profileId,
		AgentExecutionRequest $request
	): AgentContextProfileResult;
}
