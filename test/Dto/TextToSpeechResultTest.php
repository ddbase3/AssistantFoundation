<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\TextToSpeechResult;
use MediaFoundation\Api\IAudioMedia;
use PHPUnit\Framework\TestCase;

final class TextToSpeechResultTest extends TestCase {

	public function testCompleteResultCarriesAudioMedia(): void {
		if (!interface_exists(IAudioMedia::class)) {
			$this->markTestSkipped('This DTO contract test requires the declared MediaFoundation plugin.');
		}
		$audio = $this->createStub(IAudioMedia::class);
		$audio->method('getMimeType')->willReturn('audio/mpeg');
		$audio->method('getData')->willReturn('test');

		$result = new TextToSpeechResult('audio/mpeg', $audio, ['provider' => 'test']);

		$this->assertTrue($result->hasAudio());
		$this->assertSame($audio, $result->getAudio());
		$this->assertSame('audio/mpeg', $result->getMimeType());
		$this->assertSame('test', $result->getAudio()?->getData());
	}

	public function testStreamingResultDoesNotRequireBufferedAudio(): void {
		$result = new TextToSpeechResult('audio/pcm', null, ['streaming' => true]);

		$this->assertFalse($result->hasAudio());
		$this->assertNull($result->getAudio());
		$this->assertSame('audio/pcm', $result->getMimeType());
	}
}
