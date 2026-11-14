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

use Base3\AssistantFoundation\Dto\RetrievalIndexItem;
use PHPUnit\Framework\TestCase;

final class RetrievalIndexItemTest extends TestCase {

	public function testChunkKeepsDenseAndLexicalRepresentationsDistinct(): void {
		$item = new RetrievalIndexItem('collection', 3, 'Content', 'hash', ['lang' => 'en'], [0.4, -0.2], ['lexical' => ' Title ', 'phonetic' => '470']);
		$this->assertSame('collection', $item->collectionKey);
		$this->assertSame(3, $item->chunkIndex);
		$this->assertSame('Content', $item->text);
		$this->assertSame('hash', $item->hash);
		$this->assertSame(['lang' => 'en'], $item->metadata);
		$this->assertTrue($item->hasDenseVector());
		$this->assertSame([0.4, -0.2], $item->denseVector);
		$this->assertSame('Title', $item->getRepresentation('lexical'));
		$this->assertSame('470', $item->getRepresentation('phonetic'));
		$this->assertSame('', $item->getRepresentation('missing'));
	}

	public function testMissingDenseVectorAndNonStringRepresentationStayEmpty(): void {
		$item = new RetrievalIndexItem('collection', 0, '', 'hash', representations: ['lexical' => '  ', 'broken' => 123]);
		$this->assertFalse($item->hasDenseVector());
		$this->assertSame('', $item->getRepresentation('broken'));
	}
}
