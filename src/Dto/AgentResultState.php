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
 * Stable terminal-output and verification section of an agent state.
 */
final class AgentResultState {

	/**
	 * @param array<string,mixed>|null $finalAssistantMessage
	 * @param array<int,mixed> $resultVerifications
	 * @param array<int,mixed> $continuationDecisions
	 * @param array<string,mixed> $failureDetail
	 */
	public function __construct(
		private readonly bool $completed = false,
		private readonly ?array $finalAssistantMessage = null,
		private readonly string $finalOutputContent = '',
		private readonly string $finalResponseMode = 'none',
		private readonly array $resultVerifications = [],
		private readonly array $continuationDecisions = [],
		private readonly string $finalResponseInstruction = '',
		private readonly string $failureCode = '',
		private readonly string $failureMessage = '',
		private readonly array $failureDetail = []
	) {}

	public function isCompleted(): bool { return $this->completed; }
	/** @return array<string,mixed>|null */ public function getFinalAssistantMessage(): ?array { return $this->finalAssistantMessage; }
	public function getFinalOutputContent(): string { return $this->finalOutputContent; }
	public function getFinalResponseMode(): string { return $this->finalResponseMode; }
	/** @return array<int,mixed> */ public function getResultVerifications(): array { return $this->resultVerifications; }
	/** @return array<int,mixed> */ public function getContinuationDecisions(): array { return $this->continuationDecisions; }
	public function getFinalResponseInstruction(): string { return $this->finalResponseInstruction; }
	public function getFailureCode(): string { return $this->failureCode; }
	public function getFailureMessage(): string { return $this->failureMessage; }
	/** @return array<string,mixed> */ public function getFailureDetail(): array { return $this->failureDetail; }
	public function hasFailure(): bool { return $this->failureCode !== '' || $this->failureMessage !== ''; }

	/** @param array<string,mixed>|null $finalAssistantMessage */
	public function withFinalOutput(
		string $content,
		?array $finalAssistantMessage = null,
		bool $completed = true,
		?string $finalResponseMode = null
	): self {
		$mode = trim((string)$finalResponseMode);
		if ($mode === '') {
			$mode = $this->finalResponseMode;
		}
		if ($mode === 'none' && $completed) {
			$mode = 'complete';
		}

		return new self(
			completed: $completed,
			finalAssistantMessage: $finalAssistantMessage ?? $this->finalAssistantMessage,
			finalOutputContent: $content,
			finalResponseMode: $mode,
			resultVerifications: $this->resultVerifications,
			continuationDecisions: $this->continuationDecisions,
			finalResponseInstruction: $this->finalResponseInstruction,
			failureCode: $this->failureCode,
			failureMessage: $this->failureMessage,
			failureDetail: $this->failureDetail
		);
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'completed' => $this->completed,
			'final_assistant_message' => $this->finalAssistantMessage,
			'final_output_content' => $this->finalOutputContent,
			'final_response_mode' => $this->finalResponseMode,
			'result_verifications' => self::normalizeList($this->resultVerifications),
			'continuation_decisions' => self::normalizeList($this->continuationDecisions),
			'final_response_instruction' => $this->finalResponseInstruction,
			'failure_code' => $this->failureCode,
			'failure_message' => $this->failureMessage,
			'failure_detail' => $this->failureDetail
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
