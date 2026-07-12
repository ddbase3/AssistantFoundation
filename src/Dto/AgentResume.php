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

/** Transport-neutral resume input containing an opaque handle and either explicit responses or natural-language input. */
final class AgentResume {

	/** @param array<int,AgentInteractionResponse> $responses */
	public function __construct(
		private readonly string $resumeHandle,
		private readonly array $responses = [],
		private readonly string $responseText = ''
	) {
		if (trim($resumeHandle) === '') {
			throw new \InvalidArgumentException('Agent resume handle must not be empty.');
		}
		foreach ($responses as $response) {
			if (!$response instanceof AgentInteractionResponse) {
				throw new \InvalidArgumentException('Agent resume responses must be AgentInteractionResponse instances.');
			}
		}
	}

	public function getResumeHandle(): string { return $this->resumeHandle; }
	/** @return array<int,AgentInteractionResponse> */
	public function getResponses(): array { return $this->responses; }
	public function getResponseText(): string { return $this->responseText; }
	public function hasExplicitResponses(): bool { return $this->responses !== []; }
	public function hasResponseText(): bool { return trim($this->responseText) !== ''; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		$result = [
			'resume_handle' => $this->resumeHandle,
			'responses' => array_map(
				static fn(AgentInteractionResponse $response): array => $response->toArray(),
				$this->responses
			)
		];

		if ($this->responseText !== '') {
			$result['response_text'] = $this->responseText;
		}

		return $result;
	}

	/** @param array<string,mixed> $data */
	public static function fromArray(array $data): self {
		$responses = [];
		foreach (($data['responses'] ?? []) as $response) {
			if (!is_array($response)) {
				throw new \InvalidArgumentException('Invalid agent interaction response payload.');
			}
			$responses[] = AgentInteractionResponse::fromArray($response);
		}

		return new self(
			trim((string)($data['resume_handle'] ?? '')),
			$responses,
			trim((string)($data['response_text'] ?? $data['response'] ?? ''))
		);
	}
}
