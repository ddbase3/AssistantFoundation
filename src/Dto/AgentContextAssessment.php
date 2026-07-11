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
 * AgentContextAssessment
 *
 * Provider- and runtime-neutral structural assessment of an agent context at
 * one point in an execution loop.
 *
 * Byte counts are exact serialized-size measurements, not token estimates.
 * Token usage contains only values reported by AI providers and normalized
 * through AiUsage.
 */
final class AgentContextAssessment {

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly int $messageCount,
		private readonly int $messageBytes,
		private readonly int $toolResultCount,
		private readonly int $successfulToolResultCount,
		private readonly int $failedToolResultCount,
		private readonly int $toolResultBytes,
		private readonly ?AiUsage $usage = null,
		private readonly array $metadata = []
	) {}

	public function getIteration(): int {
		return $this->iteration;
	}

	public function getMessageCount(): int {
		return $this->messageCount;
	}

	public function getMessageBytes(): int {
		return $this->messageBytes;
	}

	public function getToolResultCount(): int {
		return $this->toolResultCount;
	}

	public function getSuccessfulToolResultCount(): int {
		return $this->successfulToolResultCount;
	}

	public function getFailedToolResultCount(): int {
		return $this->failedToolResultCount;
	}

	public function getToolResultBytes(): int {
		return $this->toolResultBytes;
	}

	public function getTotalMeasuredBytes(): int {
		return $this->messageBytes + $this->toolResultBytes;
	}

	public function getUsage(): AiUsage {
		return $this->usage ?? AiUsage::none();
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'iteration' => $this->iteration,
			'message_count' => $this->messageCount,
			'message_bytes' => $this->messageBytes,
			'tool_result_count' => $this->toolResultCount,
			'successful_tool_result_count' => $this->successfulToolResultCount,
			'failed_tool_result_count' => $this->failedToolResultCount,
			'tool_result_bytes' => $this->toolResultBytes,
			'total_measured_bytes' => $this->getTotalMeasuredBytes(),
			'usage' => $this->getUsage()->toArray(),
			'metadata' => $this->metadata
		];
	}
}
