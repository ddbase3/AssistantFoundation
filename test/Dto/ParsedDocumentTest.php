<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\ParsedDocument;
use AssistantFoundation\Dto\ParsedDocumentBlock;
use PHPUnit\Framework\TestCase;

final class ParsedDocumentTest extends TestCase {

	public function testTextExtractsOnlyNonemptySemanticBlocksWithParagraphSeparator(): void {
		$blocks = [
			new ParsedDocumentBlock('heading', ' Title ', 1, 2),
			new ParsedDocumentBlock('paragraph', '   '),
			'bad-block',
			new ParsedDocumentBlock('paragraph', "First line\nSecond line"),
			new ParsedDocumentBlock('table', 'Rows')
		];
		$document = new ParsedDocument('My file', $blocks, ['mime' => 'text/html']);
		$this->assertSame("Title\n\nFirst line\nSecond line\n\nRows", $document->getText());
		$this->assertSame('My file', $document->getTitle());
		$this->assertSame($blocks, $document->getBlocks());
		$this->assertSame(['mime' => 'text/html'], $document->getMetadata());
		$this->assertSame(1, $blocks[0]->getLevel());
		$this->assertSame(2, $blocks[0]->getPage());
		$this->assertSame('heading', $blocks[0]->getType());
	}

	public function testDocumentWithNoValidTextHasEmptyRepresentation(): void {
		$this->assertSame('', (new ParsedDocument('', [new ParsedDocumentBlock('text', ''), new \stdClass()]))->getText());
	}
}
