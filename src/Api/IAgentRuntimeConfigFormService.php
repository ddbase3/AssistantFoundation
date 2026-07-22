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

namespace AssistantFoundation\Api;

use Base3\Api\IBase;

/**
 * Runtime-specific configuration form used by the shared agent form facade.
 */
interface IAgentRuntimeConfigFormService extends IBase {

	public static function getRuntimeId(): string;

	/** @return array<string,mixed> */
	public function getDefaultSettings(): array;

	/**
	 * @param array<string,mixed> $settings
	 * @return array<string,mixed>
	 */
	public function normalizeSettings(array $settings): array;

	/**
	 * @param array<int,string> $errors
	 * @return array<string,mixed>
	 */
	public function getPostedSettings(array &$errors): array;

	/** @return array<string,mixed> */
	public function getPostedViewValues(): array;

	/**
	 * @param array<string,mixed> $settings
	 * @return array<string,mixed>
	 */
	public function settingsToViewValues(array $settings): array;

	/**
	 * Returns runtime-neutral values for administration lists and diagnostics.
	 *
	 * @param array<string,mixed> $settings
	 * @return array{provider:string,model:string}
	 */
	public function getConfigurationSummary(array $settings): array;

	public function getTemplate(): string;

	/**
	 * @param array<string,mixed> $values
	 * @param array<string,mixed> $options
	 * @return array<string,mixed>
	 */
	public function getTemplateData(array $values, array $options = []): array;
}
