<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Api;

use AssistantFoundation\Api\ITextToSpeechService;
use AssistantFoundation\Dto\TextToSpeechResult;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

final class ITextToSpeechServiceTest extends TestCase {

	public function testServiceSeparatesCompleteAndStreamingSynthesis(): void {
		$synthesize = new ReflectionMethod(ITextToSpeechService::class, 'synthesize');
		$stream = new ReflectionMethod(ITextToSpeechService::class, 'stream');

		$this->assertCount(1, $synthesize->getParameters());
		$this->assertCount(2, $stream->getParameters());
		$this->assertSame(TextToSpeechResult::class, (string)$synthesize->getReturnType());
		$this->assertSame(TextToSpeechResult::class, (string)$stream->getReturnType());
	}
}
