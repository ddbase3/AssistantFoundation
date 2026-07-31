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

use AssistantFoundation\Dto\AssistantResponseClientPlugin;
use Base3\Api\IComponent;

/**
 * Adds one optional output capability to assistant responses.
 *
 * Implementations are discovered through IClassMap. They may contribute
 * model instructions, one browser plugin and options for existing client
 * plugins. Activation is owned by the consuming application.
 */
interface IAssistantResponseExtension extends IComponent {

	public function id(): string;

	public function getLabel(): string;

	public function getDescription(): string;

	public function getPriority(): int;

	public function isEnabledByDefault(): bool;

	/** @return array<int,string> */
	public function getRequirements(): array;

	/** @param array<string,mixed> $context */
	public function getSystemPrompt(array $context): string;

	/** @param array<string,mixed> $context */
	public function getClientPlugin(array $context): ?AssistantResponseClientPlugin;

	/**
	 * Returns options merged into the host client's pluginOptions map.
	 *
	 * @param array<string,mixed> $context
	 * @return array<string,array<string,mixed>>
	 */
	public function getClientPluginOptions(array $context): array;
}
