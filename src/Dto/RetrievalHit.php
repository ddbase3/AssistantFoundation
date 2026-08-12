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

final class RetrievalHit {

	/**
	 * @param array<string,mixed> $payload
	 */
	public function __construct(
		public readonly string $id,
		public readonly ?float $score,
		public readonly array $payload
	) {}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		$out = [
			'id' => $this->id,
			'payload' => $this->payload
		];

		if($this->score !== null) {
			$out['score'] = $this->score;
		}

		return $out;
	}
}
