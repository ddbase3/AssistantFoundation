<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\ParserServiceResult;
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
