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

use Base3\AssistantFoundation\Dto\TextToSpeechResult;
use Base3\MediaFoundation\Api\IAudioMedia;
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
