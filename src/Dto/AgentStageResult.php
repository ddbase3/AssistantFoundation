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
 * AgentStageResult
 *
 * Immutable result of one agent stage execution.
 *
 * The initial contract deliberately contains only a context patch. Further
 * stage-result semantics can be added without requiring stage implementations
 * to mutate a second result object directly.
 */
final class AgentStageResult {

	/**
	 * @param array<string,mixed> $patch
	 */
	private function __construct(
		private readonly array $patch
	) {}

	/**
	 * Creates a stage result without context changes.
	 */
	public static function none(): self {
		return new self([]);
	}

	/**
	 * Creates a stage result containing context values to apply.
	 *
	 * @param array<string,mixed> $patch
	 */
	public static function patch(array $patch): self {
		return new self($patch);
	}

	/**
	 * Returns the context values produced by the stage.
	 *
	 * @return array<string,mixed>
	 */
	public function getPatch(): array {
		return $this->patch;
	}

	/**
	 * Returns whether the stage produced no context changes.
	 */
	public function isEmpty(): bool {
		return $this->patch === [];
	}
}
