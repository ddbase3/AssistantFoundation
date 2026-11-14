<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation defines reusable contracts for AI assistants and agents.
 * It provides DTOs, models, and interfaces for retrieval, speech and tools.
 * Implementations reside in independent BASE3 runtime plugins.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace Base3\AssistantFoundation\Test\Dto;

use Base3\AssistantFoundation\Dto\AiEmbeddingResult;
use PHPUnit\Framework\TestCase;

final class AiEmbeddingResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$metadata = new \Base3\AssistantFoundation\Dto\AiResultMetadata('embedding', 'provider', 'model');
		$dto = new AiEmbeddingResult([[0.1, -0.4], [0.3, 0.9]], $metadata, ['internal' => 'response']);
		$this->assertSame([[0.1, -0.4], [0.3, 0.9]], $dto->getEmbeddings());
		$this->assertSame($metadata, $dto->getMetadata());
		$this->assertSame(['internal' => 'response'], $dto->getRaw());
		$this->assertSame($metadata->toArray(), $dto->toArray()['metadata']);
		$this->assertSame(false, array_key_exists('raw', $dto->toArray()));
		$this->assertSame(['internal' => 'response'], $dto->toArray(true)['raw']);
	}
}
