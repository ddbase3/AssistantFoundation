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

use Base3\AssistantFoundation\Dto\ParserServiceResult;
use PHPUnit\Framework\TestCase;

final class ParserServiceResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new ParserServiceResult('extracted', ['sections' => [1]], ['format' => 'pdf'], [['file' => 'image.png']], ['raw' => true]);
		$this->assertSame('extracted', $dto->getText());
		$this->assertSame(['sections' => [1]], $dto->getStructured());
		$this->assertSame(['format' => 'pdf'], $dto->getMetadata());
		$this->assertSame([['file' => 'image.png']], $dto->getAttachments());
		$this->assertSame(['raw' => true], $dto->getRaw());
	}
}
