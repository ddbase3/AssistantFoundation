<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\RetrievalSearchResult;
use PHPUnit\Framework\TestCase;

final class RetrievalSearchResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$hit = new \AssistantFoundation\Dto\RetrievalHit('id', 0.7, ['collection' => 'course']);
		$dto = new RetrievalSearchResult([$hit], ['semantic', 'bm25'], ['total' => 1]);
		$this->assertSame([$hit], $dto->getHits());
		$this->assertSame(['semantic', 'bm25'], $dto->getChannels());
		$this->assertSame(['total' => 1], $dto->getMetadata());
		$this->assertSame([$hit->toArray()], $dto->toArray()['hits']);
		$this->assertSame(['semantic', 'bm25'], $dto->toArray()['channels']);
	}
}
