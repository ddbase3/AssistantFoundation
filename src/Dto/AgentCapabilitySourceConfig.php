<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 **********************************************************************/

namespace AssistantFoundation\Dto;

/**
 * Declares configured component ids that may contribute capabilities to one
 * agent run. The configured ids are an allow-list; discovery never expands it
 * with unrelated globally available components.
 */
final class AgentCapabilitySourceConfig {

	/**
	 * @param array<int,string> $toolIds
	 * @param array<int,string> $providerIds
	 * @param array<int,string> $moduleIds
	 * @param array<int,string> $resourceProviderIds
	 * @param array<int,string> $promptProviderIds
	 */
	public function __construct(
		private array $toolIds = [],
		private array $providerIds = [],
		private array $moduleIds = [],
		private array $resourceProviderIds = [],
		private array $promptProviderIds = [],
		private bool $strict = true
	) {
		$this->toolIds = $this->normalizeIds($this->toolIds);
		$this->providerIds = $this->normalizeIds($this->providerIds);
		$this->moduleIds = $this->normalizeIds($this->moduleIds);
		$this->resourceProviderIds = $this->normalizeIds($this->resourceProviderIds);
		$this->promptProviderIds = $this->normalizeIds($this->promptProviderIds);
	}

	public static function fromArray(array $data): self {
		return new self(
			toolIds: self::readIds($data, ['tools', 'toolIds', 'tool_ids']),
			providerIds: self::readIds($data, ['providers', 'providerIds', 'provider_ids', 'capabilityProviders', 'capability_providers']),
			moduleIds: self::readIds($data, ['modules', 'moduleIds', 'module_ids']),
			resourceProviderIds: self::readIds($data, ['resourceProviders', 'resourceProviderIds', 'resource_provider_ids', 'resource_providers']),
			promptProviderIds: self::readIds($data, ['promptProviders', 'promptProviderIds', 'prompt_provider_ids', 'prompt_providers']),
			strict: self::toBool($data['strict'] ?? true)
		);
	}

	/** @return array<int,string> */
	public function getToolIds(): array {
		return $this->toolIds;
	}

	/** @return array<int,string> */
	public function getProviderIds(): array {
		return $this->providerIds;
	}

	/** @return array<int,string> */
	public function getModuleIds(): array {
		return $this->moduleIds;
	}

	/** @return array<int,string> */
	public function getResourceProviderIds(): array {
		return $this->resourceProviderIds;
	}

	/** @return array<int,string> */
	public function getPromptProviderIds(): array {
		return $this->promptProviderIds;
	}

	public function isStrict(): bool {
		return $this->strict;
	}

	public function isEmpty(): bool {
		return $this->toolIds === []
			&& $this->providerIds === []
			&& $this->moduleIds === []
			&& $this->resourceProviderIds === []
			&& $this->promptProviderIds === [];
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'tools' => $this->toolIds,
			'providers' => $this->providerIds,
			'modules' => $this->moduleIds,
			'resourceProviders' => $this->resourceProviderIds,
			'promptProviders' => $this->promptProviderIds,
			'strict' => $this->strict
		];
	}

	/** @return array<int,string> */
	private function normalizeIds(array $ids): array {
		$result = [];
		foreach ($ids as $id) {
			$id = trim((string)$id);
			if ($id !== '') {
				$result[$id] = true;
			}
		}
		return array_keys($result);
	}

	/**
	 * @param array<string,mixed> $data
	 * @param array<int,string> $keys
	 * @return array<int,string>
	 */
	private static function readIds(array $data, array $keys): array {
		$value = [];
		foreach ($keys as $key) {
			if (array_key_exists($key, $data)) {
				$value = $data[$key];
				break;
			}
		}
		if (is_string($value)) {
			$value = preg_split('/[\r\n,]+/', $value) ?: [];
		}
		return is_array($value) ? $value : [];
	}

	private static function toBool(mixed $value): bool {
		if (is_bool($value)) {
			return $value;
		}
		if (is_int($value) || is_float($value)) {
			return $value !== 0;
		}
		$value = strtolower(trim((string)$value));
		return !in_array($value, ['', '0', 'false', 'off', 'no'], true);
	}
}
