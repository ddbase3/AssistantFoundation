<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation defines reusable contracts for AI assistants and agents.
 * It provides DTOs, models, and interfaces for retrieval, speech and tools.
 * Implementations reside in independent BASE3 runtime plugins.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace Base3\AssistantFoundation\Test\Event;

use Base3\AssistantFoundation\Dto\AiResultMetadata;
use Base3\AssistantFoundation\Dto\AiUsage;
use Base3\AssistantFoundation\Event\AiProviderRequestCompletedEvent;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class AiProviderRequestCompletedEventTest extends TestCase {

	public function testExposesNormalizedProviderRequestData(): void {
		$metadata = new AiResultMetadata(
			'chat',
			'openai',
			'gpt-test',
			'request-1',
			1700000000,
			125.5,
			'stop',
			new AiUsage(10, 4, 14, 2, 1)
		);
		$event = new AiProviderRequestCompletedEvent(
			$metadata,
			'openai-compatible-chat-model',
			1700000001
		);

		$this->assertSame($metadata, $event->getMetadata());
		$this->assertSame($metadata->getUsage(), $event->getUsage());
		$this->assertSame('openai-compatible-chat-model', $event->getSourceName());
		$this->assertSame(1700000001, $event->getOccurredAt());
	}

	public function testRejectsEmptySourceName(): void {
		$this->expectException(InvalidArgumentException::class);

		new AiProviderRequestCompletedEvent(
			new AiResultMetadata('chat'),
			' ',
			1700000001
		);
	}
}
