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

use AssistantFoundation\Dto\AgentAction;
use AssistantFoundation\Dto\AgentActionDecision;
use Base3\Api\IComponent;

/**
 * Interface IAgentActionPolicy
 *
 * Defines one configured policy that evaluates a semantic agent action before
 * the action is executed by the runtime.
 */
interface IAgentActionPolicy extends IComponent {

	public const AI_USAGE_NONE = 'none';
	public const AI_USAGE_CONDITIONAL = 'conditional';
	public const AI_USAGE_REQUIRED = 'required';

	/**
	 * Returns the operational policy name.
	 */
	public function name(): string;

	/**
	 * Returns a concise factual description of the policy responsibility.
	 */
	public function getDescription(): string;

	/**
	 * Returns whether the policy uses AI.
	 *
	 * Allowed values are the AI_USAGE_* constants declared by this interface.
	 */
	public function getAiUsage(): string;

	/**
	 * Evaluates one action and returns a provider-neutral decision.
	 */
	public function evaluate(AgentAction $action, IAgentContext $context): AgentActionDecision;
}
