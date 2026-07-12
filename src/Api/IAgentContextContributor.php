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

use AssistantFoundation\Dto\AgentInstructionBlock;
use Base3\Api\IComponent;

/**
 * Provides run-local instruction/context blocks for an agent turn.
 *
 * A context contributor is not conversation history. It is read when a new
 * turn is prepared and is not written to when user or assistant messages are
 * appended. One implementation may also expose tools or other capabilities.
 */
interface IAgentContextContributor extends IComponent {

	/**
	 * Returns instruction blocks that should be added to the model context.
	 *
	 * @return iterable<AgentInstructionBlock>
	 */
	public function contribute(IAgentContext $context): iterable;

	/**
	 * Defines contributor ordering. Lower values are added first.
	 */
	public function getPriority(): int;
}
