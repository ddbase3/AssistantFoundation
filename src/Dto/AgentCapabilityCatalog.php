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

use Countable;

/**
 * Run-specific normalized view of all capabilities active for one agent.
 */
final class AgentCapabilityCatalog implements Countable {

	/** @var array<string,AgentCapability> */
	private array $capabilities = [];

	/** @param array<int,AgentCapability> $capabilities */
	public function __construct(array $capabilities = []) {
		foreach ($capabilities as $capability) {
			if (!$capability instanceof AgentCapability) {
				throw new \InvalidArgumentException('Agent capability catalogs may contain only AgentCapability instances.');
			}

			$name = $capability->getName();
			if (isset($this->capabilities[$name])) {
				throw new \InvalidArgumentException('Duplicate agent capability name: ' . $name);
			}

			$this->capabilities[$name] = $capability;
		}
	}

	public function count(): int {
		return count($this->capabilities);
	}

	public function has(string $name): bool {
		return isset($this->capabilities[$name]);
	}

	public function get(string $name): ?AgentCapability {
		return $this->capabilities[$name] ?? null;
	}

	/** @return array<int,AgentCapability> */
	public function all(): array {
		return array_values($this->capabilities);
	}

	/** @return array<int,string> */
	public function names(): array {
		return array_keys($this->capabilities);
	}

	/** @return array<int,array<string,mixed>> */
	public function getToolDefinitions(): array {
		return array_map(
			static fn(AgentCapability $capability): array => $capability->getDefinition(),
			$this->all()
		);
	}

	/** @return array<int,array<string,mixed>> */
	public function toArray(): array {
		return array_map(
			static fn(AgentCapability $capability): array => $capability->toArray(),
			$this->all()
		);
	}
}
