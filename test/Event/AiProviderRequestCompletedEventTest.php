<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Event;

use AssistantFoundation\Dto\AiResultMetadata;
use AssistantFoundation\Dto\AiUsage;
use AssistantFoundation\Event\AiProviderRequestCompletedEvent;
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
