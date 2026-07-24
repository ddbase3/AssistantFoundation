<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation extends the BASE3 framework with a unified API
 * foundation for assistants, chatbots, and agent-based systems.
 * It provides shared interfaces for modular AI integration.
 **********************************************************************/

namespace AssistantFoundation\Api;

use AssistantFoundation\Dto\AgentExecutionRequest;
use Base3\Api\IBase;

/**
 * Owns storage and materialization of one namespace of tool profiles.
 */
interface IAgentToolProfileProvider extends IBase {

	public static function getProviderId(): string;

	/** @return array<int,array<string,mixed>> */
	public function getOptions(): array;

	public function hasProfile(string $profileId): bool;

	/** @param array<int,string> $profileIds */
	public function resolve(array $profileIds, AgentExecutionRequest $request): IAgentToolSet;
}
