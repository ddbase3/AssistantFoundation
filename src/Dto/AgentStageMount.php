<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 **********************************************************************/

namespace AssistantFoundation\Dto;

use AssistantFoundation\Api\IAgentStage;

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
