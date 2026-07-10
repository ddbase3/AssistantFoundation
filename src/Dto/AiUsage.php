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
 * Provider-neutral usage information for any AI operation.
 *
 * Token counters are first-class because they are shared by chat,
 * embeddings, image models with token billing, and search-backed models.
 * Additional measurable units remain available through metrics.
 */
final class AiUsage {

	/**
	 * @param array<string,int|float> $metrics
	 * @param array<string,mixed> $details
	 */
	public function __construct(
		private readonly ?int $inputTokens = null,
		private readonly ?int $outputTokens = null,
		private readonly ?int $totalTokens = null,
		private readonly ?int $cachedInputTokens = null,
		private readonly ?int $reasoningTokens = null,
		private readonly array $metrics = [],
		private readonly array $details = []
	) {}

	public static function none(): self {
		return new self();
	}

	public function getInputTokens(): ?int {
		return $this->inputTokens;
	}

	public function getOutputTokens(): ?int {
		return $this->outputTokens;
	}

	public function getTotalTokens(): ?int {
		return $this->totalTokens;
	}

	public function getCachedInputTokens(): ?int {
		return $this->cachedInputTokens;
	}

	public function getReasoningTokens(): ?int {
		return $this->reasoningTokens;
	}

	/**
	 * @return array<string,int|float>
	 */
	public function getMetrics(): array {
		return $this->metrics;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getDetails(): array {
		return $this->details;
	}

	public function merge(self $usage): self {
		return new self(
			$this->sumNullable($this->inputTokens, $usage->inputTokens),
			$this->sumNullable($this->outputTokens, $usage->outputTokens),
			$this->sumNullable($this->totalTokens, $usage->totalTokens),
			$this->sumNullable($this->cachedInputTokens, $usage->cachedInputTokens),
			$this->sumNullable($this->reasoningTokens, $usage->reasoningTokens),
			$this->mergeMetrics($this->metrics, $usage->metrics),
			array_merge($this->details, $usage->details)
		);
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'input_tokens' => $this->inputTokens,
			'output_tokens' => $this->outputTokens,
			'total_tokens' => $this->totalTokens,
			'cached_input_tokens' => $this->cachedInputTokens,
			'reasoning_tokens' => $this->reasoningTokens,
			'metrics' => $this->metrics,
			'details' => $this->details
		];
	}

	private function sumNullable(?int $left, ?int $right): ?int {
		if($left === null && $right === null) {
			return null;
		}

		return ($left ?? 0) + ($right ?? 0);
	}

	/**
	 * @param array<string,int|float> $left
	 * @param array<string,int|float> $right
	 * @return array<string,int|float>
	 */
	private function mergeMetrics(array $left, array $right): array {
		foreach($right as $name => $value) {
			$left[$name] = ($left[$name] ?? 0) + $value;
		}

		return $left;
	}
}
