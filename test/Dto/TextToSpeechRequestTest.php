<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\TextToSpeechRequest;
use PHPUnit\Framework\TestCase;

final class TextToSpeechRequestTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new TextToSpeechRequest('tts', 'Hello', 'en-GB', ['voice' => 'default']);
		$this->assertSame('tts', $dto->getServiceId());
		$this->assertSame('Hello', $dto->getText());
		$this->assertSame('en-GB', $dto->getLanguage());
		$this->assertSame(['voice' => 'default'], $dto->getOptions());
	}
}
