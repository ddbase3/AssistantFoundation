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
 * AgentInteractionResponse
 *
 * Explicit response to one pending interaction request. Natural-language
 * confirmation is intentionally not interpreted by this value object.
 */
final class AgentInteractionResponse {

	public const DECISION_APPROVE = 'approve';
	public const DECISION_DENY = 'deny';
	public const DECISION_SUBMIT = 'submit';

	/**
	 * @param array<string,mixed> $input
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $requestId,
		private readonly string $decision,
		private readonly array $input = [],
		private readonly string $note = '',
		private readonly array $metadata = []
	) {
		if (trim($requestId) === '') {
			throw new \InvalidArgumentException('Agent interaction response request id must not be empty.');
		}
		if (!in_array($decision, self::getAllowedDecisions(), true)) {
			throw new \InvalidArgumentException('Unsupported agent interaction response: ' . $decision);
		}
	}

	public function getRequestId(): string { return $this->requestId; }
	public function getDecision(): string { return $this->decision; }
	/** @return array<string,mixed> */
	public function getInput(): array { return $this->input; }
	public function getNote(): string { return $this->note; }
	/** @return array<string,mixed> */
	public function getMetadata(): array { return $this->metadata; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'request_id' => $this->requestId,
			'decision' => $this->decision,
			'input' => $this->input,
			'note' => $this->note,
			'metadata' => $this->metadata
		];
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		return new self(
			trim((string)($data['request_id'] ?? $data['id'] ?? '')),
			strtolower(trim((string)($data['decision'] ?? ''))),
			is_array($data['input'] ?? null) ? $data['input'] : [],
			trim((string)($data['note'] ?? '')),
			is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}

	/** @return array<int,string> */
	public static function getAllowedDecisions(): array {
		return [self::DECISION_APPROVE, self::DECISION_DENY, self::DECISION_SUBMIT];
	}
}
