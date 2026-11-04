<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\ParserFileRequest;
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
