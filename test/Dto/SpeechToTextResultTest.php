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

use Base3\AssistantFoundation\Dto\SpeechToTextResult;
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
