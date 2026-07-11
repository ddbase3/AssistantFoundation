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
 * Normalized model-facing capability metadata for one callable function.
 */
final class AgentCapability {

	/**
	 * @param array<int,string> $tags
	 * @param array<string,mixed> $definition
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $name,
		private readonly string $title,
		private readonly string $description,
		private readonly string $category,
		private readonly array $tags,
		private readonly int $priority,
		private readonly array $definition,
		private readonly string $sourceId = '',
		private readonly string $sourceName = '',
		private readonly bool $alwaysAvailable = false,
		private readonly array $metadata = []
	) {
		if (trim($this->name) === '') {
			throw new \InvalidArgumentException('Agent capability name must not be empty.');
		}

		$definitionName = trim((string)($this->definition['function']['name'] ?? ''));
		if ($definitionName !== $this->name) {
			throw new \InvalidArgumentException('Agent capability definition name must match the capability name.');
		}

		foreach ($this->tags as $tag) {
			if (!is_string($tag) || trim($tag) === '') {
				throw new \InvalidArgumentException('Agent capability tags must be non-empty strings.');
			}
		}
	}

	public function getName(): string {
		return $this->name;
	}

	public function getTitle(): string {
		return $this->title;
	}

	public function getDescription(): string {
		return $this->description;
	}

	public function getCategory(): string {
		return $this->category;
	}

	/** @return array<int,string> */
	public function getTags(): array {
		return $this->tags;
	}

	public function getPriority(): int {
		return $this->priority;
	}

	/** @return array<string,mixed> */
	public function getDefinition(): array {
		return $this->definition;
	}

	public function getSourceId(): string {
		return $this->sourceId;
	}

	public function getSourceName(): string {
		return $this->sourceName;
	}

	public function isAlwaysAvailable(): bool {
		return $this->alwaysAvailable;
	}

	/** @return array<string,mixed> */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'name' => $this->name,
			'title' => $this->title,
			'description' => $this->description,
			'category' => $this->category,
			'tags' => $this->tags,
			'priority' => $this->priority,
			'source_id' => $this->sourceId,
			'source_name' => $this->sourceName,
			'always_available' => $this->alwaysAvailable,
			'metadata' => $this->metadata
		];
	}
}
