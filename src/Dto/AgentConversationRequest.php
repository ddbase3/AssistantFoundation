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

namespace AssistantFoundation\Dto;

/**
 * Immutable runtime-neutral request for conversation-memory operations.
 */
final class AgentConversationRequest {

	/**
	 * @param array<string,mixed> $agentConfiguration
	 * @param array<string,mixed> $context
	 */
	public function __construct(
		private readonly array $agentConfiguration,
		private readonly array $context = [],
		private readonly string $nodeId = ''
	) {}

	/** @return array<string,mixed> */
	public function getAgentConfiguration(): array {
		return $this->agentConfiguration;
	}

	/** @return array<string,mixed> */
	public function getContext(): array {
		return $this->context;
	}

	public function getNodeId(): string {
		return trim($this->nodeId);
	}
}
