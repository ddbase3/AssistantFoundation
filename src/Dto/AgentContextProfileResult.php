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
 * Immutable result of resolving one context profile for one agent turn.
 */
final class AgentContextProfileResult {

	/**
	 * @param array<int,AgentInstructionBlock> $blocks
	 * @param array<int,string> $warnings
	 */
	public function __construct(
		private readonly string $profileId,
		private readonly array $blocks = [],
		private readonly array $warnings = []
	) {}

	public static function empty(string $profileId = ''): self {
		return new self(trim($profileId));
	}

	public function getProfileId(): string {
		return $this->profileId;
	}

	/** @return array<int,AgentInstructionBlock> */
	public function getBlocks(): array {
		return $this->blocks;
	}

	/** @return array<int,string> */
	public function getWarnings(): array {
		return $this->warnings;
	}

	/** @return array<int,array<string,mixed>> */
	public function getDiagnostics(): array {
		return array_map(
			static fn(AgentInstructionBlock $block): array => $block->toDiagnosticArray(),
			$this->blocks
		);
	}
}
