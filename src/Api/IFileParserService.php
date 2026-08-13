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

use AssistantFoundation\Dto\ParserFileRequest;
use AssistantFoundation\Dto\ParserServiceResult;
use Base3\Api\IBase;

/**
 * Shared contract for parser services that accept concrete files.
 *
 * Implementations may be local or remote. The contract deliberately exposes
 * both normalized text and a structured/native result so consumers can choose
 * the representation that best fits their next processing stage.
 */
interface IFileParserService extends IBase {

	/**
	 * @param array<string,mixed> $options
	 */
	public function setOptions(array $options): void;

	/**
	 * @return array<string,mixed>
	 */
	public function getOptions(): array;

	public function getPriority(): int;

	public function supportsFile(ParserFileRequest $request): bool;

	public function parseFile(ParserFileRequest $request): ParserServiceResult;
}
