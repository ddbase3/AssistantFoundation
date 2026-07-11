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
 * Per-agent configuration for capability pool filtering and model-call selection.
 */
final class AgentCapabilitySelectionConfig {

	public const STRATEGY_HYBRID = 'hybrid';
	public const STRATEGY_ALL = 'all';

	/**
	 * @param array<int,string> $includeTools
	 * @param array<int,string> $excludeTools
	 * @param array<int,string> $includeTags
	 * @param array<int,string> $excludeTags
	 * @param array<int,string> $includeCategories
	 * @param array<int,string> $excludeCategories
	 * @param array<int,string> $alwaysAvailable
	 */
	public function __construct(
		private readonly bool $enabled = true,
		private readonly string $strategy = self::STRATEGY_HYBRID,
		private readonly int $maxTools = 16,
		private readonly int $selectAllThreshold = 16,
		private readonly array $includeTools = [],
		private readonly array $excludeTools = [],
		private readonly array $includeTags = [],
		private readonly array $excludeTags = [],
		private readonly array $includeCategories = [],
		private readonly array $excludeCategories = [],
		private readonly array $alwaysAvailable = [],
		private readonly bool $sticky = true
	) {
		if (!in_array($this->strategy, [self::STRATEGY_HYBRID, self::STRATEGY_ALL], true)) {
			throw new \InvalidArgumentException('Unsupported capability selection strategy: ' . $this->strategy);
		}
		if ($this->maxTools < 1 || $this->maxTools > 512) {
			throw new \InvalidArgumentException('Capability maxTools must be between 1 and 512.');
		}
		if ($this->selectAllThreshold < 0 || $this->selectAllThreshold > 512) {
			throw new \InvalidArgumentException('Capability selectAllThreshold must be between 0 and 512.');
		}
	}

	/** @param array<string,mixed> $config */
	public static function fromArray(array $config): self {
		return new self(
			enabled: self::boolValue($config['enabled'] ?? true, true),
			strategy: strtolower(trim((string)($config['strategy'] ?? self::STRATEGY_HYBRID))),
			maxTools: (int)($config['maxTools'] ?? $config['max_tools'] ?? 16),
			selectAllThreshold: (int)($config['selectAllThreshold'] ?? $config['select_all_threshold'] ?? 16),
			includeTools: self::strings($config['includeTools'] ?? $config['include_tools'] ?? []),
			excludeTools: self::strings($config['excludeTools'] ?? $config['exclude_tools'] ?? []),
			includeTags: self::strings($config['includeTags'] ?? $config['include_tags'] ?? []),
			excludeTags: self::strings($config['excludeTags'] ?? $config['exclude_tags'] ?? []),
			includeCategories: self::strings($config['includeCategories'] ?? $config['include_categories'] ?? []),
			excludeCategories: self::strings($config['excludeCategories'] ?? $config['exclude_categories'] ?? []),
			alwaysAvailable: self::strings($config['alwaysAvailable'] ?? $config['always_available'] ?? []),
			sticky: self::boolValue($config['sticky'] ?? true, true)
		);
	}

	/** @param array<int,string> $toolNames */
	public function withAlwaysAvailable(array $toolNames): self {
		return new self(
			$this->enabled,
			$this->strategy,
			$this->maxTools,
			$this->selectAllThreshold,
			$this->includeTools,
			$this->excludeTools,
			$this->includeTags,
			$this->excludeTags,
			$this->includeCategories,
			$this->excludeCategories,
			array_values(array_unique(array_merge($this->alwaysAvailable, self::strings($toolNames)))),
			$this->sticky
		);
	}

	public function isEnabled(): bool { return $this->enabled; }
	public function getStrategy(): string { return $this->strategy; }
	public function getMaxTools(): int { return $this->maxTools; }
	public function getSelectAllThreshold(): int { return $this->selectAllThreshold; }
	/** @return array<int,string> */ public function getIncludeTools(): array { return $this->includeTools; }
	/** @return array<int,string> */ public function getExcludeTools(): array { return $this->excludeTools; }
	/** @return array<int,string> */ public function getIncludeTags(): array { return $this->includeTags; }
	/** @return array<int,string> */ public function getExcludeTags(): array { return $this->excludeTags; }
	/** @return array<int,string> */ public function getIncludeCategories(): array { return $this->includeCategories; }
	/** @return array<int,string> */ public function getExcludeCategories(): array { return $this->excludeCategories; }
	/** @return array<int,string> */ public function getAlwaysAvailable(): array { return $this->alwaysAvailable; }
	public function isSticky(): bool { return $this->sticky; }

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'enabled' => $this->enabled,
			'strategy' => $this->strategy,
			'max_tools' => $this->maxTools,
			'select_all_threshold' => $this->selectAllThreshold,
			'include_tools' => $this->includeTools,
			'exclude_tools' => $this->excludeTools,
			'include_tags' => $this->includeTags,
			'exclude_tags' => $this->excludeTags,
			'include_categories' => $this->includeCategories,
			'exclude_categories' => $this->excludeCategories,
			'always_available' => $this->alwaysAvailable,
			'sticky' => $this->sticky
		];
	}

	/** @return array<int,string> */
	private static function strings(mixed $values): array {
		if (!is_array($values)) {
			return [];
		}
		$result = [];
		foreach ($values as $value) {
			if (!is_scalar($value)) {
				continue;
			}
			$value = trim((string)$value);
			if ($value !== '') {
				$result[$value] = true;
			}
		}
		return array_keys($result);
	}

	private static function boolValue(mixed $value, bool $default): bool {
		if (is_bool($value)) {
			return $value;
		}
		if (is_int($value) || is_float($value)) {
			return $value != 0;
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
		return $default;
	}
}
