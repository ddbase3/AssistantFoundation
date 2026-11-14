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

use Base3\AssistantFoundation\Dto\RetrievalSearchResult;
use PHPUnit\Framework\TestCase;

final class RetrievalSearchResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$hit = new \Base3\AssistantFoundation\Dto\RetrievalHit('id', 0.7, ['collection' => 'course']);
		$dto = new RetrievalSearchResult([$hit], ['semantic', 'bm25'], ['total' => 1]);
		$this->assertSame([$hit], $dto->getHits());
		$this->assertSame(['semantic', 'bm25'], $dto->getChannels());
		$this->assertSame(['total' => 1], $dto->getMetadata());
		$this->assertSame([$hit->toArray()], $dto->toArray()['hits']);
		$this->assertSame(['semantic', 'bm25'], $dto->toArray()['channels']);
	}
}
