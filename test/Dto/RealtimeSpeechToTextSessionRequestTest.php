<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\RealtimeSpeechToTextSessionRequest;
use PHPUnit\Framework\TestCase;

final class RealtimeSpeechToTextSessionRequestTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new RealtimeSpeechToTextSessionRequest('speech', 'de-DE', ['format' => 'pcm']);
		$this->assertSame('speech', $dto->getServiceId());
		$this->assertSame('de-DE', $dto->getLanguage());
		$this->assertSame(['format' => 'pcm'], $dto->getOptions());
	}
}
