<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiImageResult;
use PHPUnit\Framework\TestCase;

final class AiImageResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$metadata = new \AssistantFoundation\Dto\AiResultMetadata('image', 'provider', 'model');
		$dto = new AiImageResult([['url' => 'http://example.test/image.png']], $metadata, ['generated' => 1]);
		$this->assertSame([['url' => 'http://example.test/image.png']], $dto->getImages());
		$this->assertSame($metadata, $dto->getMetadata());
		$this->assertSame(['generated' => 1], $dto->getRaw());
		$this->assertSame([['url' => 'http://example.test/image.png']], $dto->toArray()['images']);
		$this->assertSame(false, array_key_exists('raw', $dto->toArray()));
		$this->assertSame(['generated' => 1], $dto->toArray(true)['raw']);
	}
}
