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
 * Provider- and runtime-neutral limits for one agent run.
 *
 * Null limits are unlimited. Generic usage metrics allow the same budget
 * object to constrain non-chat operations such as generated images, search
 * queries, vector items, audio seconds, or provider-reported monetary cost.
 */
final class AgentBudget {

	/**
	 * @param array<string,int|float> $metricLimits
	 */
	public function __construct(
		private readonly ?int $maxInputTokens = null,
		private readonly ?int $maxOutputTokens = null,
		private readonly ?int $maxTotalTokens = null,
		private readonly ?int $maxAiOperations = null,
		private readonly ?int $maxToolCalls = null,
		private readonly ?float $maxElapsedMs = null,
		private readonly array $metricLimits = [],
		private readonly bool $requireUsageReporting = false
	) {
		$this->assertPositiveIntOrNull($this->maxInputTokens, 'maxInputTokens');
		$this->assertPositiveIntOrNull($this->maxOutputTokens, 'maxOutputTokens');
		$this->assertPositiveIntOrNull($this->maxTotalTokens, 'maxTotalTokens');
		$this->assertPositiveIntOrNull($this->maxAiOperations, 'maxAiOperations');
		$this->assertPositiveIntOrNull($this->maxToolCalls, 'maxToolCalls');

		if ($this->maxElapsedMs !== null && $this->maxElapsedMs <= 0) {
			throw new \InvalidArgumentException('maxElapsedMs must be greater than zero when configured.');
		}

		foreach ($this->metricLimits as $name => $limit) {
			if (!is_string($name) || trim($name) === '') {
				throw new \InvalidArgumentException('Agent budget metric names must be non-empty strings.');
			}

			if ((!is_int($limit) && !is_float($limit)) || $limit <= 0) {
				throw new \InvalidArgumentException('Agent budget metric limits must be positive numbers.');
			}
		}
	}

	public static function unlimited(): self {
		return new self();
	}

	/**
	 * Builds a budget from a flow/configuration array.
	 *
	 * Both snake_case and camelCase keys are accepted. Missing, null, empty,
	 * or zero values mean unlimited. Negative values are rejected.
	 *
	 * @param array<string,mixed> $data
	 */
	public static function fromArray(array $data): self {
		$metricLimits = self::readMetricLimits($data['metric_limits'] ?? $data['metricLimits'] ?? []);

		return new self(
			maxInputTokens: self::readPositiveInt($data, ['max_input_tokens', 'maxInputTokens']),
			maxOutputTokens: self::readPositiveInt($data, ['max_output_tokens', 'maxOutputTokens']),
			maxTotalTokens: self::readPositiveInt($data, ['max_total_tokens', 'maxTotalTokens']),
			maxAiOperations: self::readPositiveInt($data, ['max_ai_operations', 'maxAiOperations']),
			maxToolCalls: self::readPositiveInt($data, ['max_tool_calls', 'maxToolCalls']),
			maxElapsedMs: self::readPositiveFloat($data, ['max_elapsed_ms', 'maxElapsedMs']),
			metricLimits: $metricLimits,
			requireUsageReporting: self::readBool($data, ['require_usage_reporting', 'requireUsageReporting'])
		);
	}

	public function getMaxInputTokens(): ?int {
		return $this->maxInputTokens;
	}

	public function getMaxOutputTokens(): ?int {
		return $this->maxOutputTokens;
	}

	public function getMaxTotalTokens(): ?int {
		return $this->maxTotalTokens;
	}

	public function getMaxAiOperations(): ?int {
		return $this->maxAiOperations;
	}

	public function getMaxToolCalls(): ?int {
		return $this->maxToolCalls;
	}

	public function getMaxElapsedMs(): ?float {
		return $this->maxElapsedMs;
	}

	/**
	 * @return array<string,int|float>
	 */
	public function getMetricLimits(): array {
		return $this->metricLimits;
	}

	public function requiresUsageReporting(): bool {
		return $this->requireUsageReporting;
	}

	public function isUnlimited(): bool {
		return $this->maxInputTokens === null
			&& $this->maxOutputTokens === null
			&& $this->maxTotalTokens === null
			&& $this->maxAiOperations === null
			&& $this->maxToolCalls === null
			&& $this->maxElapsedMs === null
			&& $this->metricLimits === [];
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'max_input_tokens' => $this->maxInputTokens,
			'max_output_tokens' => $this->maxOutputTokens,
			'max_total_tokens' => $this->maxTotalTokens,
			'max_ai_operations' => $this->maxAiOperations,
			'max_tool_calls' => $this->maxToolCalls,
			'max_elapsed_ms' => $this->maxElapsedMs,
			'metric_limits' => $this->metricLimits,
			'require_usage_reporting' => $this->requireUsageReporting
		];
	}

	private function assertPositiveIntOrNull(?int $value, string $name): void {
		if ($value !== null && $value <= 0) {
			throw new \InvalidArgumentException($name . ' must be greater than zero when configured.');
		}
	}

	/**
	 * @param array<string,mixed> $data
	 * @param array<int,string> $keys
	 */
	private static function readPositiveInt(array $data, array $keys): ?int {
		$value = self::readFirst($data, $keys);

		if ($value === null || $value === '' || $value === 0 || $value === '0') {
			return null;
		}

		if (!is_int($value) && !is_float($value) && !is_string($value)) {
			throw new \InvalidArgumentException($keys[0] . ' must be numeric.');
		}

		if (!is_numeric($value)) {
			throw new \InvalidArgumentException($keys[0] . ' must be numeric.');
		}

		$numeric = (float)$value;
		if ($numeric <= 0 || floor($numeric) !== $numeric) {
			throw new \InvalidArgumentException($keys[0] . ' must be a positive integer.');
		}

		return (int)$numeric;
	}

	/**
	 * @param array<string,mixed> $data
	 * @param array<int,string> $keys
	 */
	private static function readPositiveFloat(array $data, array $keys): ?float {
		$value = self::readFirst($data, $keys);

		if ($value === null || $value === '' || $value === 0 || $value === '0') {
			return null;
		}

		if (!is_int($value) && !is_float($value) && !is_string($value)) {
			throw new \InvalidArgumentException($keys[0] . ' must be numeric.');
		}

		if (!is_numeric($value)) {
			throw new \InvalidArgumentException($keys[0] . ' must be numeric.');
		}

		$result = (float)$value;
		if ($result <= 0) {
			throw new \InvalidArgumentException($keys[0] . ' must be greater than zero.');
		}

		return $result;
	}

	/**
	 * @param array<string,mixed> $data
	 * @param array<int,string> $keys
	 */
	private static function readBool(array $data, array $keys): bool {
		$value = self::readFirst($data, $keys);

		if ($value === null || $value === '') {
			return false;
		}

		if (is_bool($value)) {
			return $value;
		}

		if (is_int($value) || is_float($value)) {
			return (int)$value !== 0;
		}

		if (is_string($value)) {
			$normalized = strtolower(trim($value));
			if (in_array($normalized, ['1', 'true', 'yes', 'on'], true)) {
				return true;
			}
			if (in_array($normalized, ['0', 'false', 'no', 'off'], true)) {
				return false;
			}
		}

		throw new \InvalidArgumentException($keys[0] . ' must be boolean.');
	}

	/**
	 * @param array<string,mixed> $data
	 * @param array<int,string> $keys
	 */
	private static function readFirst(array $data, array $keys): mixed {
		foreach ($keys as $key) {
			if (array_key_exists($key, $data)) {
				return $data[$key];
			}
		}

		return null;
	}

	/**
	 * @return array<string,int|float>
	 */
	private static function readMetricLimits(mixed $value): array {
		if ($value === null || $value === '') {
			return [];
		}

		if (!is_array($value)) {
			throw new \InvalidArgumentException('metric_limits must be an associative array.');
		}

		$result = [];
		foreach ($value as $name => $limit) {
			$name = is_string($name) ? trim($name) : '';
			if ($name === '') {
				throw new \InvalidArgumentException('metric_limits keys must be non-empty strings.');
			}

			if (!is_int($limit) && !is_float($limit) && !is_string($limit)) {
				throw new \InvalidArgumentException('metric_limits values must be numeric.');
			}

			if (!is_numeric($limit)) {
				throw new \InvalidArgumentException('metric_limits values must be numeric.');
			}

			$numeric = (float)$limit;
			if ($numeric === 0.0) {
				continue;
			}
			if ($numeric < 0) {
				throw new \InvalidArgumentException('metric_limits values must be greater than zero.');
			}

			$result[$name] = is_int($limit) || (is_string($limit) && preg_match('/^[0-9]+$/', $limit) === 1)
				? (int)$limit
				: $numeric;
		}

		return $result;
	}
}
