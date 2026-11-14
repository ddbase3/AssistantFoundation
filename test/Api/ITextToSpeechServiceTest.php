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

namespace Base3\AssistantFoundation\Test\Api;

use Base3\AssistantFoundation\Api\ITextToSpeechService;
use Base3\AssistantFoundation\Dto\TextToSpeechResult;
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
