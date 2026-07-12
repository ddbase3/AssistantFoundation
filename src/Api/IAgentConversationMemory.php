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
 * Marks an IAgentMemory as persistent or volatile conversation history.
 *
 * Conversation memories load visible dialog messages and receive new visible
 * user and assistant messages. Prompt/context contributors use the separate
 * IAgentContextContributor contract.
 */
interface IAgentConversationMemory extends IAgentMemory {
}
