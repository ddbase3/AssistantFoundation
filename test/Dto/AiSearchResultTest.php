<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiSearchResult;
use PHPUnit\Framework\TestCase;

final class AiSearchResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$metadata = new \AssistantFoundation\Dto\AiResultMetadata('search', 'provider', 'model');
		$dto = new AiSearchResult('query', 'answer', [['title' => 'one']], [['source' => 1]], $metadata, ['trace' => 'private']);
		$this->assertSame('query', $dto->getQuery());
		$this->assertSame('answer', $dto->getAnswer());
		$this->assertSame([['title' => 'one']], $dto->getResults());
		$this->assertSame([['source' => 1]], $dto->getCitations());
		$this->assertSame($metadata, $dto->getMetadata());
		$this->assertSame(['trace' => 'private'], $dto->getRaw());
		$this->assertSame($metadata->toArray(), $dto->toArray()['metadata']);
		$this->assertSame(false, array_key_exists('raw', $dto->toArray()));
		$this->assertSame(['trace' => 'private'], $dto->toArray(true)['raw']);
	}
}
