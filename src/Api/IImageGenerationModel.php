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

use AssistantFoundation\Dto\AiImageResult;
use Base3\Api\IBase;

/**
 * Provider-neutral image generation model contract.
 */
interface IImageGenerationModel extends IBase {

	/**
	 * Generates images and returns normalized provider and usage metadata.
	 *
	 * @param array<string,mixed> $options
	 */
	public function generateResult(string $prompt, array $options = []): AiImageResult;

	/**
	 * @param array<string,mixed> $options
	 */
	public function setOptions(array $options): void;

	/**
	 * @return array<string,mixed>
	 */
	public function getOptions(): array;

	/**
	 * @param array<string,mixed> $options
	 * @return array<int,array<string,mixed>>
	 */
	public function generate(string $prompt, array $options = []): array;
}
