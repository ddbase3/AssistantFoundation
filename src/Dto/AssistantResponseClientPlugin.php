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

final class AssistantResponseClientPlugin {

	/**
	 * @param array<string,mixed> $options
	 */
	public function __construct(
		private readonly string $name,
		private readonly string $moduleUrl,
		private readonly string $exportName,
		private readonly array $options = []
	) {}

	public function getName(): string {
		return $this->name;
	}

	public function getModuleUrl(): string {
		return $this->moduleUrl;
	}

	public function getExportName(): string {
		return $this->exportName;
	}

	/** @return array<string,mixed> */
	public function getOptions(): array {
		return $this->options;
	}

	/** @return array<string,mixed> */
	public function toArray(): array {
		return [
			'name' => $this->name,
			'module_url' => $this->moduleUrl,
			'export_name' => $this->exportName,
			'options' => $this->options
		];
	}
}
