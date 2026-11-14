<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation defines reusable contracts for AI assistants and agents.
 * It provides DTOs, models, and interfaces for retrieval, speech and tools.
 * Implementations reside in independent BASE3 runtime plugins.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace Base3\AssistantFoundation\Dto;

final class AgentModuleActivation {

	/**
	 * @param array<int,string> $instructions
	 * @param array<int,object> $tools
	 * @param array<int,object> $resourceProviders
	 * @param array<int,object> $promptProviders
	 * @param array<int,AgentStageMount> $stages
	 */
	public function __construct(
		private array $instructions = [],
		private array $tools = [],
		private array $resourceProviders = [],
		private array $promptProviders = [],
		private array $stages = []
	) {
		$this->instructions = array_values(array_filter(array_map(
			static fn(mixed $value): string => trim((string)$value),
			$this->instructions
		)));
		foreach ($this->stages as $stage) {
			if (!$stage instanceof AgentStageMount) {
				throw new \InvalidArgumentException('Agent module stages must contain only AgentStageMount values.');
			}
		}
	}

	/** @return array<int,string> */
	public function getInstructions(): array {
		return $this->instructions;
	}

	/** @return array<int,object> */
	public function getTools(): array {
		return $this->tools;
	}

	/** @return array<int,object> */
	public function getResourceProviders(): array {
		return $this->resourceProviders;
	}

	/** @return array<int,object> */
	public function getPromptProviders(): array {
		return $this->promptProviders;
	}

	/** @return array<int,AgentStageMount> */
	public function getStages(): array {
		return $this->stages;
	}
}
