<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\SpeechToTextRequest;
use PHPUnit\Framework\TestCase;

final class SpeechToTextRequestTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new SpeechToTextRequest('speech', "\x00\x01", 'audio/pcm', 'de-DE', ['sample_rate' => 16000]);
		$this->assertSame('speech', $dto->getServiceId());
		$this->assertSame("\x00\x01", $dto->getAudio());
		$this->assertSame('audio/pcm', $dto->getMimeType());
		$this->assertSame('de-DE', $dto->getLanguage());
		$this->assertSame(['sample_rate' => 16000], $dto->getOptions());
	}
}
