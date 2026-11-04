<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiFileResource;
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
