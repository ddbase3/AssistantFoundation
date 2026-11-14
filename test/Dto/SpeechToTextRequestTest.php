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

namespace Base3\AssistantFoundation\Test\Dto;

use Base3\AssistantFoundation\Dto\SpeechToTextRequest;
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
