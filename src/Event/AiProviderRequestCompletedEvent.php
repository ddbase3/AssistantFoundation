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

namespace AssistantFoundation\Event;

use AssistantFoundation\Dto\AiResultMetadata;
use AssistantFoundation\Dto\AiUsage;
use InvalidArgumentException;

/**
 * Announces one successfully completed provider request.
 *
 * The event contains normalized metadata only. Provider request payloads,
 * response contents, credentials, and raw provider responses are deliberately
 * excluded from this shared contract.
 */
final class AiProviderRequestCompletedEvent {

	private readonly string $sourceName;

	public function __construct(
		private readonly AiResultMetadata $metadata,
		string $sourceName,
		private readonly int $occurredAt
	) {
		$sourceName = trim($sourceName);

		if($sourceName === '') {
			throw new InvalidArgumentException('AI provider request event source name must not be empty.');
		}

		$this->sourceName = $sourceName;
	}

	public function getMetadata(): AiResultMetadata {
		return $this->metadata;
	}

	public function getUsage(): AiUsage {
		return $this->metadata->getUsage();
	}

	public function getSourceName(): string {
		return $this->sourceName;
	}

	public function getOccurredAt(): int {
		return $this->occurredAt;
	}
}
