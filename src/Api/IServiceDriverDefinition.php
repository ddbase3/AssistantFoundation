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

namespace AssistantFoundation\Api;

use Base3\Api\IBase;

/**
 * Describes one discoverable service driver.
 *
 * Driver definitions are provider-neutral extension metadata. They connect a
 * configured service driver id with one classmap-discovered implementation.
 * Concrete provider plugins may supply additional definitions without changing
 * MissionBay or another consuming runtime.
 */
interface IServiceDriverDefinition extends IBase {

	public function getDriver(): string;

	public function getServiceType(): string;

	public function getLabel(): string;

	public function requiresConnection(): bool;

	/**
	 * @return array<int,string>
	 */
	public function getSupportedConnectionTypes(): array;

	/**
	 * Returns the interface used to resolve the runtime implementation.
	 */
	public function getImplementationInterface(): string;

	/**
	 * Returns the technical getName() value of the runtime implementation.
	 */
	public function getImplementationName(): string;

	/**
	 * @return array<string,mixed>
	 */
	public function getConfigSchema(): array;

	/**
	 * @return array<string,mixed>
	 */
	public function getDefaultConfig(): array;
}
