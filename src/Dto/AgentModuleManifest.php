<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 **********************************************************************/

namespace AssistantFoundation\Dto;

final class AgentModuleManifest {

	/**
	 * @param array<int,string> $tags
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private string $name,
		private string $title = '',
		private string $description = '',
		private array $tags = [],
		private array $metadata = []
	) {
		$this->name = trim($this->name);
		if ($this->name === '') {
			throw new \InvalidArgumentException('Agent module manifest name must not be empty.');
		}
		$this->tags = array_values(array_unique(array_filter(array_map(
			static fn(mixed $value): string => trim((string)$value),
			$this->tags
		))));
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

	/** @return array<int,string> */
	public function getTags(): array {
		return $this->tags;
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
			'tags' => $this->tags,
			'metadata' => $this->metadata
		];
	}
}
