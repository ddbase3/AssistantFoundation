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
 * It contains the context patch plus provider-neutral execution metadata for
 * tracing, diagnostics, and user interfaces. Metadata never mutates the agent
 * context unless a stage also includes it in the patch explicitly.
 */
final class AgentStageResult {

	/**
	 * @param array<string,mixed> $patch
	 * @param array<string,mixed> $metadata
	 */
	private function __construct(
		private readonly array $patch,
		private readonly array $metadata = []
	) {}

	/**
	 * Creates a stage result without context changes.
	 *
	 * @param array<string,mixed> $metadata
	 */
	public static function none(array $metadata = []): self {
		return new self([], $metadata);
	}

	/**
	 * Creates a stage result containing context values to apply.
	 *
	 * @param array<string,mixed> $patch
	 * @param array<string,mixed> $metadata
	 */
	public static function patch(array $patch, array $metadata = []): self {
		return new self($patch, $metadata);
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
	 * Returns provider-neutral execution metadata for tracing and UIs.
	 *
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * Returns whether the stage produced no context changes.
	 */
	public function isEmpty(): bool {
		return $this->patch === [];
	}
}
