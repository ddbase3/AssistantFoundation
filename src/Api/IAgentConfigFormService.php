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

use Base3\Api\IMvcView;

/**
 * Provides runtime-selectable agent configuration fields for host displays.
 */
interface IAgentConfigFormService {

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
	public function getPostedSettings(array &$errors, ?string $runtimeId = null): array;

	/** @return array<string,mixed> */
	public function getPostedViewValues(?string $runtimeId = null): array;

	/**
	 * @param array<string,mixed> $settings
	 * @return array<string,mixed>
	 */
	public function settingsToViewValues(array $settings): array;

	/**
	 * Supported options:
	 * - form_id: root form identifier
	 * - selected_runtime: explicit selected runtime id
	 * - show_runtime_selector: whether the shared runtime select is rendered
	 * - runtime_active: whether one runtime section should initially be active
	 *
	 * The second argument contains persisted or normalized settings, not already
	 * formatted view values. The implementation performs the view conversion once.
	 *
	 * @param array<string,mixed> $settings
	 * @param array<string,mixed> $options
	 */
	public function assignViewData(IMvcView $view, array $settings, array $options = []): void;
}
