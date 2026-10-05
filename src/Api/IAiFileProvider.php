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

use AssistantFoundation\Dto\AiFileResource;

interface IAiFileProvider extends IAiProvider {

	/**
	 * Uploads one file as multipart/form-data and returns the decoded provider response.
	 *
	 * @param array<string,scalar> $fields
	 * @param array<string,mixed> $options
	 * @return array<string,mixed>
	 */
	public function uploadFile(
		string $path,
		AiFileResource $file,
		array $fields = [],
		array $options = []
	): array;
}
