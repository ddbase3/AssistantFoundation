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
 * Stable knowledge and observation section of the agent state.
 */
final class AgentKnowledgeState {

	/**
	 * @param array<int,mixed> $knowledge
	 * @param array<int,mixed> $observations
	 */
	public function __construct(
		private readonly array $knowledge = [],
		private readonly array $observations = []
	) {}

	/** @return array<int,mixed> */
	public function getKnowledge(): array { return $this->knowledge; }
	/** @return array<int,mixed> */
	public function getObservations(): array { return $this->observations; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'knowledge' => self::normalizeList($this->knowledge),
			'observations' => self::normalizeList($this->observations)
		];
	}

	/** @param array<int,mixed> $values */
	private static function normalizeList(array $values): array {
		return array_map(
			static fn(mixed $value): mixed => is_object($value) && method_exists($value, 'toArray')
				? $value->toArray()
				: $value,
			$values
		);
	}
}
