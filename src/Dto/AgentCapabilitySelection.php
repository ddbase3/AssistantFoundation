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
 * Immutable capability subset exposed to one model-decision call.
 */
final class AgentCapabilitySelection {

	/**
	 * @param array<int,AgentCapability> $capabilities
	 * @param array<string,float> $scores
	 * @param array<string,array<int,string>> $reasons
	 */
	public function __construct(
		private readonly int $iteration,
		private readonly string $strategy,
		private readonly int $catalogSize,
		private readonly int $eligibleSize,
		private readonly array $capabilities,
		private readonly array $scores = [],
		private readonly array $reasons = []
	) {
		$known = [];
		foreach ($this->capabilities as $capability) {
			if (!$capability instanceof AgentCapability) {
				throw new \InvalidArgumentException('Capability selections may contain only AgentCapability instances.');
			}
			if (isset($known[$capability->getName()])) {
				throw new \InvalidArgumentException('Duplicate selected capability: ' . $capability->getName());
			}
			$known[$capability->getName()] = true;
		}
	}

	public function getIteration(): int { return $this->iteration; }
	public function getStrategy(): string { return $this->strategy; }
	public function getCatalogSize(): int { return $this->catalogSize; }
	public function getEligibleSize(): int { return $this->eligibleSize; }
	/** @return array<int,AgentCapability> */ public function getCapabilities(): array { return $this->capabilities; }
	/** @return array<string,float> */ public function getScores(): array { return $this->scores; }
	/** @return array<string,array<int,string>> */ public function getReasons(): array { return $this->reasons; }

	/** @return array<int,string> */
	public function getToolNames(): array {
		return array_map(
			static fn(AgentCapability $capability): string => $capability->getName(),
			$this->capabilities
		);
	}

	public function has(string $toolName): bool {
		foreach ($this->capabilities as $capability) {
			if ($capability->getName() === $toolName) {
				return true;
			}
		}
		return false;
	}

	/** @return array<int,array<string,mixed>> */
	public function getToolDefinitions(): array {
		return array_map(
			static fn(AgentCapability $capability): array => $capability->getDefinition(),
			$this->capabilities
		);
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'iteration' => $this->iteration,
			'strategy' => $this->strategy,
			'catalog_size' => $this->catalogSize,
			'eligible_size' => $this->eligibleSize,
			'selected_count' => count($this->capabilities),
			'selected_tools' => $this->getToolNames(),
			'scores' => $this->scores,
			'reasons' => $this->reasons
		];
	}
}
