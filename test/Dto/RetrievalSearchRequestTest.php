<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\RetrievalSearchRequest;
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
