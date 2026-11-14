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

use Base3\AssistantFoundation\Dto\ParsedDocumentBlock;
use PHPUnit\Framework\TestCase;

final class ParsedDocumentBlockTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new ParsedDocumentBlock('heading', 'Title', 2, 5, ['source' => 'pdf']);
		$this->assertSame('heading', $dto->getType());
		$this->assertSame('Title', $dto->getText());
		$this->assertSame(2, $dto->getLevel());
		$this->assertSame(5, $dto->getPage());
		$this->assertSame(['source' => 'pdf'], $dto->getMetadata());
	}
}
