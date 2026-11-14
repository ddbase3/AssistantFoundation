<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation defines reusable contracts for AI assistants and agents.
 * It provides DTOs, models, and interfaces for retrieval, speech and tools.
 * Implementations reside in independent BASE3 runtime plugins.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace Base3\AssistantFoundation\Dto;

use Base3\AssistantFoundation\Api\IAgentStage;

final class AgentStageMount {

	public function __construct(
		private string $slot,
		private IAgentStage $stage,
		private int $order = 0
	) {
		$this->slot = AgentStageSlot::assert($this->slot);
	}

	public function getSlot(): string {
		return $this->slot;
	}

	public function getStage(): IAgentStage {
		return $this->stage;
	}

	public function getOrder(): int {
		return $this->order;
	}
}
