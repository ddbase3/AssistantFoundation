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
 * AgentInteractionRequest
 *
 * Structured user interaction requested by the agent harness before an action
 * may continue. Tools remain execution-only and never ask the user directly.
 */
final class AgentInteractionRequest {

	public const KIND_APPROVAL = 'approval';
	public const KIND_CLARIFICATION = 'clarification';
	public const KIND_DRY_RUN = 'dry_run';

	/**
	 * @param array<string,mixed> $summary
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $id,
		private readonly string $kind,
		private readonly AgentAction $action,
		private readonly string $actionFingerprint,
		private readonly string $title,
		private readonly string $message,
		private readonly array $summary = [],
		private readonly string $risk = 'medium',
		private readonly array $metadata = []
	) {
		if (trim($id) === '') {
			throw new \InvalidArgumentException('Agent interaction request id must not be empty.');
		}

		if (trim($actionFingerprint) === '') {
			throw new \InvalidArgumentException('Agent interaction request fingerprint must not be empty.');
		}

		if (!in_array($kind, self::getAllowedKinds(), true)) {
			throw new \InvalidArgumentException('Unsupported agent interaction kind: ' . $kind);
		}
	}

	public function getId(): string {
		return $this->id;
	}

	public function getKind(): string {
		return $this->kind;
	}

	public function getAction(): AgentAction {
		return $this->action;
	}

	public function getActionFingerprint(): string {
		return $this->actionFingerprint;
	}

	public function getTitle(): string {
		return $this->title;
	}

	public function getMessage(): string {
		return $this->message;
	}

	/** @return array<string,mixed> */
	public function getSummary(): array {
		return $this->summary;
	}

	public function getRisk(): string {
		return $this->risk;
	}

	/** @return array<string,mixed> */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'id' => $this->id,
			'kind' => $this->kind,
			'action' => $this->action->toArray(),
			'action_fingerprint' => $this->actionFingerprint,
			'title' => $this->title,
			'message' => $this->message,
			'summary' => $this->summary,
			'risk' => $this->risk,
			'metadata' => $this->metadata
		];
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		$action = $data['action'] ?? null;
		if (!is_array($action)) {
			throw new \InvalidArgumentException('Agent interaction request requires an action array.');
		}

		return new self(
			trim((string)($data['id'] ?? '')),
			trim((string)($data['kind'] ?? '')),
			AgentAction::fromArray($action),
			trim((string)($data['action_fingerprint'] ?? '')),
			trim((string)($data['title'] ?? '')),
			trim((string)($data['message'] ?? '')),
			is_array($data['summary'] ?? null) ? $data['summary'] : [],
			trim((string)($data['risk'] ?? 'medium')),
			is_array($data['metadata'] ?? null) ? $data['metadata'] : []
		);
	}

	/** @return array<int,string> */
	public static function getAllowedKinds(): array {
		return [self::KIND_APPROVAL, self::KIND_CLARIFICATION, self::KIND_DRY_RUN];
	}
}
