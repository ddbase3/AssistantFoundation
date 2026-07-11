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
 * AgentToolCacheConfig
 *
 * Run-specific explicit configuration for safe tool-result caching.
 */
final class AgentToolCacheConfig {

	public const SCOPE_GLOBAL = 'global';
	public const SCOPE_CONFIGURATION = 'configuration';
	public const SCOPE_CHATBOT = 'chatbot';
	public const SCOPE_TURN = 'turn';
	public const SCOPE_CUSTOM = 'custom';

	/**
	 * @param array<int,AgentToolCacheRule> $rules
	 */
	public function __construct(
		private readonly bool $enabled = false,
		private readonly string $scope = self::SCOPE_CONFIGURATION,
		private readonly string $scopeKey = '',
		private readonly string $keyNamespace = 'default',
		private readonly int $maxEntryBytes = 262144,
		private readonly array $rules = []
	) {
		if (!in_array($this->scope, self::getAllowedScopes(), true)) {
			throw new \InvalidArgumentException('Unsupported tool-cache scope: ' . $this->scope);
		}

		if ($this->scope === self::SCOPE_CUSTOM && trim($this->scopeKey) === '') {
			throw new \InvalidArgumentException('Custom tool-cache scope requires scope_key.');
		}

		if ($this->maxEntryBytes < 1) {
			throw new \InvalidArgumentException('Tool-cache max_entry_bytes must be greater than zero.');
		}

		foreach ($this->rules as $rule) {
			if (!$rule instanceof AgentToolCacheRule) {
				throw new \InvalidArgumentException('Tool-cache rules must be AgentToolCacheRule instances.');
			}
		}
	}

	public static function disabled(): self {
		return new self();
	}

	/**
	 * @param array<string,mixed> $data
	 */
	public static function fromArray(array $data): self {
		$enabled = self::toBool($data['enabled'] ?? false);
		$scope = strtolower(trim((string)($data['scope'] ?? self::SCOPE_CONFIGURATION)));
		$scopeKey = trim((string)($data['scope_key'] ?? ''));
		$keyNamespace = trim((string)($data['key_namespace'] ?? $data['namespace'] ?? 'default'));
		$maxEntryBytes = (int)($data['max_entry_bytes'] ?? 262144);
		$rules = [];

		$rawRules = $data['rules'] ?? [];
		if (!is_array($rawRules)) {
			throw new \InvalidArgumentException('Tool-cache rules must be an array.');
		}

		foreach ($rawRules as $rawRule) {
			if (!is_array($rawRule)) {
				throw new \InvalidArgumentException('Each tool-cache rule must be an associative array.');
			}

			$rules[] = AgentToolCacheRule::fromArray($rawRule);
		}

		$tools = $data['tools'] ?? [];
		if (!is_array($tools)) {
			throw new \InvalidArgumentException('Tool-cache tools must be an array.');
		}

		foreach ($tools as $toolName => $toolConfig) {
			if (is_int($toolConfig) || is_float($toolConfig) || (is_string($toolConfig) && is_numeric($toolConfig))) {
				$rules[] = new AgentToolCacheRule((string)$toolName, (int)$toolConfig);
				continue;
			}

			if (!is_array($toolConfig)) {
				throw new \InvalidArgumentException('Tool-cache shorthand values must be TTL numbers or arrays.');
			}

			$toolConfig['tool'] = (string)$toolName;
			$rules[] = AgentToolCacheRule::fromArray($toolConfig);
		}

		if ($keyNamespace === '') {
			$keyNamespace = 'default';
		}

		return new self(
			enabled: $enabled,
			scope: $scope,
			scopeKey: $scopeKey,
			keyNamespace: $keyNamespace,
			maxEntryBytes: $maxEntryBytes,
			rules: $rules
		);
	}

	public function isEnabled(): bool {
		return $this->enabled && $this->rules !== [];
	}

	public function getScope(): string {
		return $this->scope;
	}

	public function getScopeKey(): string {
		return $this->scopeKey;
	}

	public function getKeyNamespace(): string {
		return $this->keyNamespace;
	}

	public function getMaxEntryBytes(): int {
		return $this->maxEntryBytes;
	}

	/**
	 * @return array<int,AgentToolCacheRule>
	 */
	public function getRules(): array {
		return $this->rules;
	}

	public function findRule(string $toolName, string $resourceId, string $implementationName): ?AgentToolCacheRule {
		foreach ($this->rules as $rule) {
			if ($rule->matches($toolName, $resourceId, $implementationName)) {
				return $rule;
			}
		}

		return null;
	}

	/**
	 * @return array<int,string>
	 */
	public static function getAllowedScopes(): array {
		return [
			self::SCOPE_GLOBAL,
			self::SCOPE_CONFIGURATION,
			self::SCOPE_CHATBOT,
			self::SCOPE_TURN,
			self::SCOPE_CUSTOM
		];
	}

	private static function toBool(mixed $value): bool {
		if (is_bool($value)) {
			return $value;
		}

		if (is_int($value) || is_float($value)) {
			return (int)$value !== 0;
		}

		if (is_string($value)) {
			return in_array(strtolower(trim($value)), ['1', 'true', 'yes', 'on'], true);
		}

		return false;
	}
}
