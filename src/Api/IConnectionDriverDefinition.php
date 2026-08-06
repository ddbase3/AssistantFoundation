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
 * Describes one discoverable connection driver.
 *
 * Connection definitions own connection-level fields such as endpoint,
 * authentication and secrets. Service definitions only reference a configured
 * connection and must not duplicate these fields.
 */
interface IConnectionDriverDefinition extends IBase {

	public function getDriver(): string;

	public function getLabel(): string;

	public function getConnectionType(): string;

	/**
	 * @return array<string,mixed>
	 */
	public function getConfigSchema(): array;

	/**
	 * @return array<string,mixed>
	 */
	public function getDefaultConfig(): array;

	/**
	 * @return array<string,mixed>
	 */
	public function getHealthCheckSchema(): array;
}
