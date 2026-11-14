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

use Base3\AssistantFoundation\Dto\RetrievalHit;
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
