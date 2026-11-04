<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\SpeechToTextResult;
use PHPUnit\Framework\TestCase;

final class SpeechToTextResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new SpeechToTextResult('Recognized', 'de-DE', ['confidence' => 0.8], ['raw' => 'provider']);
		$this->assertSame('Recognized', $dto->getText());
		$this->assertSame('de-DE', $dto->getLanguage());
		$this->assertSame(['confidence' => 0.8], $dto->getMetadata());
		$this->assertSame(['raw' => 'provider'], $dto->getRaw());
		$this->assertSame(false, array_key_exists('raw', $dto->toArray()));
		$this->assertSame(['raw' => 'provider'], $dto->toArray(true)['raw']);
	}
}
