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

use Base3\AssistantFoundation\Dto\AiSearchResult;
use PHPUnit\Framework\TestCase;

final class AiSearchResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$metadata = new \Base3\AssistantFoundation\Dto\AiResultMetadata('search', 'provider', 'model');
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
