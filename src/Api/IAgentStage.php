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

use AssistantFoundation\Dto\AgentStageResult;
use Base3\Api\IComponent;

/**
 * Interface IAgentStage
 *
 * Defines one configurable processing step in an agent pipeline.
 *
 * Stage implementations are discoverable BASE3 components. The static
 * getName() value identifies the implementation class, id() identifies one
 * configured runtime instance, and name() exposes the operational stage name.
 */
interface IAgentStage extends IComponent {

	/**
	 * Returns the operational name of this stage.
	 */
	public function name(): string;

	/**
	 * Checks whether this stage should process the current agent context.
	 */
	public function supports(IAgentContext $context): bool;

	/**
	 * Processes the current agent context and returns the resulting context patch.
	 */
	public function process(IAgentContext $context): AgentStageResult;
}
