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

use Base3\AssistantFoundation\Dto\RetrievalSearchRequest;
use PHPUnit\Framework\TestCase;

final class RetrievalSearchRequestTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new RetrievalSearchRequest('course', 'question', 'hybrid', [0.3, 0.9], ['lang' => 'en'], ['exact'], ['phonetic'], ['must'], ['except'], 'sounding', 7, 28, 0.4);
		$this->assertSame('course', $dto->collectionKey);
		$this->assertSame('question', $dto->query);
		$this->assertSame('hybrid', $dto->mode);
		$this->assertSame([0.3, 0.9], $dto->denseVector);
		$this->assertSame(['lang' => 'en'], $dto->filterSpec);
		$this->assertSame(['exact'], $dto->phrases);
		$this->assertSame(['phonetic'], $dto->phoneticPhrases);
		$this->assertSame(['must'], $dto->requiredTerms);
		$this->assertSame(['except'], $dto->excludedTerms);
		$this->assertSame('sounding', $dto->phoneticText);
		$this->assertSame(7, $dto->limit);
		$this->assertSame(28, $dto->candidateLimit);
		$this->assertSame(0.4, $dto->denseMinScore);
		$this->assertSame(RetrievalSearchRequest::MODE_AUTO, (new RetrievalSearchRequest('course', 'q'))->mode);
	}
}
