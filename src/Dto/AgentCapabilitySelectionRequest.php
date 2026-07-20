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

use AssistantFoundation\Api\IAiChatModel;

/**
 * Context supplied to a capability selector for one model decision.
 */
final class AgentCapabilitySelectionRequest {

	/**
	 * @param array<int,string> $previousSelectedToolNames
	 * @param array<int,string> $recentToolNames
	 * @param array<int,string> $requiredToolNames
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly string $contextText,
		private readonly AgentCapabilitySelectionConfig $config,
		private readonly array $previousSelectedToolNames = [],
		private readonly array $recentToolNames = [],
		private readonly array $requiredToolNames = [],
		private readonly ?IAiChatModel $model = null
	) {}

	public function getIteration(): int { return $this->iteration; }
	public function getContextText(): string { return $this->contextText; }
	public function getConfig(): AgentCapabilitySelectionConfig { return $this->config; }
	/** @return array<int,string> */ public function getPreviousSelectedToolNames(): array { return $this->previousSelectedToolNames; }
	/** @return array<int,string> */ public function getRecentToolNames(): array { return $this->recentToolNames; }
	/** @return array<int,string> */ public function getRequiredToolNames(): array { return $this->requiredToolNames; }
	public function getModel(): ?IAiChatModel { return $this->model; }
}
