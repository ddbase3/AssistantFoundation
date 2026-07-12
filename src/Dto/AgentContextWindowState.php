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
 * Context-window assessments and compaction records for one run.
 */
final class AgentContextWindowState {

	/**
	 * @param array<int,mixed> $assessments
	 * @param array<int,mixed> $compactions
	 */
	public function __construct(
		private readonly array $assessments = [],
		private readonly array $compactions = []
	) {}

	/** @return array<int,mixed> */ public function getAssessments(): array { return $this->assessments; }
	/** @return array<int,mixed> */ public function getCompactions(): array { return $this->compactions; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'assessments' => self::normalizeList($this->assessments),
			'compactions' => self::normalizeList($this->compactions)
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
