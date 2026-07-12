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
 * One typed prompt/context contribution produced for an agent turn.
 */
final class AgentInstructionBlock {

	private string $id;
	private string $content;
	private int $priority;
	private string $source;

	/**
	 * @var array<string,mixed>
	 */
	private array $metadata;

	/**
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		string $id,
		string $content,
		int $priority = 0,
		string $source = '',
		array $metadata = []
	) {
		$id = trim($id);
		$content = trim($content);

		if ($id === '') {
			throw new \InvalidArgumentException('Agent instruction block id must not be empty.');
		}

		if ($content === '') {
			throw new \InvalidArgumentException('Agent instruction block content must not be empty.');
		}

		$this->id = $id;
		$this->content = $content;
		$this->priority = $priority;
		$this->source = trim($source);
		$this->metadata = $metadata;
	}

	public function getId(): string {
		return $this->id;
	}

	public function getContent(): string {
		return $this->content;
	}

	public function getPriority(): int {
		return $this->priority;
	}

	public function getSource(): string {
		return $this->source;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'id' => $this->id,
			'content' => $this->content,
			'priority' => $this->priority,
			'source' => $this->source,
			'metadata' => $this->metadata
		];
	}

	/**
	 * Returns non-content diagnostics suitable for run metadata.
	 *
	 * @return array<string,mixed>
	 */
	public function toDiagnosticArray(): array {
		return [
			'id' => $this->id,
			'priority' => $this->priority,
			'source' => $this->source,
			'metadata' => $this->metadata,
			'content_length' => strlen($this->content)
		];
	}

	/**
	 * @return array{role:string,content:string}
	 */
	public function toMessage(): array {
		return [
			'role' => 'system',
			'content' => $this->content
		];
	}
}
