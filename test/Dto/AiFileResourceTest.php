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

use Base3\AssistantFoundation\Dto\AiFileResource;
use PHPUnit\Framework\TestCase;

final class AiFileResourceTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new AiFileResource('/tmp/document', 'document.txt', 'text/plain', 'Text content', 'hash');
		$this->assertSame('/tmp/document', $dto->getPath());
		$this->assertSame('document.txt', $dto->getName());
		$this->assertSame('text/plain', $dto->getMimeType());
		$this->assertSame('Text content', $dto->getContent());
		$this->assertSame('hash', $dto->getContentHash());
		$this->assertSame(12, $dto->getSize());
	}
}
