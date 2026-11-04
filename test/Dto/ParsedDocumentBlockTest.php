<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\ParsedDocumentBlock;
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
