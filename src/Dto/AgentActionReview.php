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
 * AgentActionReview
 *
 * Immutable, transport-neutral user-facing description of an action that is
 * about to be reviewed. The review deliberately contains only a title, a
 * message and a flat or otherwise directly renderable summary. The exact
 * technical action remains available separately through AgentAction.
 *
 * A review must describe the action that is bound to the same fingerprint and,
 * for guarded mutations, to the same AgentMutationCommitSnapshot that will be
 * validated immediately before execution.
 */
final class AgentActionReview {

	/**
	 * @param array<string,mixed> $summary User-facing values suitable for direct display
	 */
	public function __construct(
		private readonly string $title,
		private readonly string $message,
		private readonly array $summary = []
	) {
		if (trim($this->title) === '') {
			throw new \InvalidArgumentException('Agent action review title must not be empty.');
		}
		if (trim($this->message) === '') {
			throw new \InvalidArgumentException('Agent action review message must not be empty.');
		}
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

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'title' => $this->title,
			'message' => $this->message,
			'summary' => $this->summary
		];
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		return new self(
			trim((string)($data['title'] ?? '')),
			trim((string)($data['message'] ?? '')),
			is_array($data['summary'] ?? null) ? $data['summary'] : []
		);
	}
}
