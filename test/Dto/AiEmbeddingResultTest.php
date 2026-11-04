<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiEmbeddingResult;
use PHPUnit\Framework\TestCase;

final class AiEmbeddingResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$metadata = new \AssistantFoundation\Dto\AiResultMetadata('embedding', 'provider', 'model');
		$dto = new AiEmbeddingResult([[0.1, -0.4], [0.3, 0.9]], $metadata, ['internal' => 'response']);
		$this->assertSame([[0.1, -0.4], [0.3, 0.9]], $dto->getEmbeddings());
		$this->assertSame($metadata, $dto->getMetadata());
		$this->assertSame(['internal' => 'response'], $dto->getRaw());
		$this->assertSame($metadata->toArray(), $dto->toArray()['metadata']);
		$this->assertSame(false, array_key_exists('raw', $dto->toArray()));
		$this->assertSame(['internal' => 'response'], $dto->toArray(true)['raw']);
	}
}
