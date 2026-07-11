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

use AssistantFoundation\Dto\AgentSuspension;
use AssistantFoundation\Dto\AgentSuspensionClaim;

/**
 * Stores server-owned agent suspensions behind opaque one-time handles.
 *
 * A successful resume claims a handle, validates the user response, and then
 * consumes the claim before any approved action is executed. Failed input
 * validation may release the short-lived claim so the user can retry.
 */
interface IAgentSuspensionRepository {

	public function create(AgentSuspension $suspension, int $ttlSeconds): string;

	public function claim(string $resumeHandle): AgentSuspensionClaim;

	public function release(AgentSuspensionClaim $claim): void;

	public function consume(AgentSuspensionClaim $claim): void;
}
