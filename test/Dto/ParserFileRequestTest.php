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

use Base3\AssistantFoundation\Dto\ParserFileRequest;
use PHPUnit\Framework\TestCase;

final class ParserFileRequestTest extends TestCase {

	public function testPathFallbackDerivesFilenameAndLowercaseExtension(): void {
		$request = new ParserFileRequest('/tmp/Report.DOCX', metadata: ['provider' => 'upload']);
		$this->assertSame('/tmp/Report.DOCX', $request->getPath());
		$this->assertSame('Report.DOCX', $request->getFilename());
		$this->assertSame('docx', $request->getExtension());
		$this->assertSame(['provider' => 'upload'], $request->getMetadata());
	}

	public function testExplicitFilenameOverridesPathButFallsBackToPathExtension(): void {
		$explicit = new ParserFileRequest('/tmp/source.pdf', ' Copy.TXT ');
		$this->assertSame('Copy.TXT', $explicit->getFilename());
		$this->assertSame('txt', $explicit->getExtension());
		$unnamed = new ParserFileRequest('/tmp/source.PDF', 'name-without-extension');
		$this->assertSame('pdf', $unnamed->getExtension());
		$this->assertSame('', (new ParserFileRequest('/tmp/name'))->getExtension());
	}
}
