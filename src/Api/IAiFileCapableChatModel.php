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
use AssistantFoundation\Dto\AiProviderFileMetadata;
use AssistantFoundation\Dto\AiProviderFileReference;

interface IAiFileCapableChatModel extends IAiChatModel {

	public function getFileProviderName(): string;

	public function uploadFile(AiFileResource $file): AiProviderFileReference;

	public function getFileMetadata(AiProviderFileReference $reference): ?AiProviderFileMetadata;

	public function deleteFile(AiProviderFileReference $reference): void;

	/** @param array<int,AiProviderFileReference> $references */
	public function setFileReferences(array $references): void;

	/** @return array<int,AiProviderFileReference> */
	public function getFileReferences(): array;
}
