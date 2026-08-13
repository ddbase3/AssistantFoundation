<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\TextToSpeechResult;
use MediaFoundation\Api\IAudioMedia;
use PHPUnit\Framework\TestCase;

final class TextToSpeechResultTest extends TestCase {

	public function testCompleteResultCarriesAudioMedia(): void {
		$audio = new class implements IAudioMedia {
			public function getMimeType(): string {
				return 'audio/mpeg';
			}

			public function getSize(): int {
				return 4;
			}

			public function getData(): string {
				return 'test';
			}

			public function getDuration(): float {
				return 0.0;
			}

			public function getBitrate(): int {
				return 0;
			}
		};

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
