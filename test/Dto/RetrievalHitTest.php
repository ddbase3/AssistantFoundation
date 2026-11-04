<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\RetrievalHit;
use PHPUnit\Framework\TestCase;

final class RetrievalHitTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new RetrievalHit('chunk-2', 0.8, ['title' => 'one']);
		$this->assertSame('chunk-2', $dto->id);
		$this->assertSame(0.8, $dto->score);
		$this->assertSame(['title' => 'one'], $dto->payload);
		$this->assertSame(0.8, $dto->toArray()['score']);
		$this->assertSame(false, array_key_exists('score', (new RetrievalHit('chunk-1', null, []))->toArray()));
	}
}
