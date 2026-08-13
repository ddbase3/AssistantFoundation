<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation provides shared contracts, DTOs, models and
 * exceptions for assistant and agent integrations.
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
 * Provider-neutral description of one configured parser service.
 */
final class ParserServiceDefinition {

	/**
	 * @param array<int,string> $supportedTypes
	 * @param array<int,string> $supportedExtensions
	 */
	public function __construct(
		private readonly string $id,
		private readonly string $name,
		private readonly string $driver,
		private readonly int $priority = 50,
		private readonly array $supportedTypes = [],
		private readonly array $supportedExtensions = []
	) {}

	public function getId(): string {
		return $this->id;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getDriver(): string {
		return $this->driver;
	}

	public function getPriority(): int {
		return $this->priority;
	}

	/**
	 * @return array<int,string>
	 */
	public function getSupportedTypes(): array {
		return $this->supportedTypes;
	}

	/**
	 * @return array<int,string>
	 */
	public function getSupportedExtensions(): array {
		return $this->supportedExtensions;
	}

	public function supportsType(string $type): bool {
		$type = strtolower(trim($type));
		return $type !== '' && in_array($type, $this->supportedTypes, true);
	}
}
