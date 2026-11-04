<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentResume;
use AssistantFoundation\Dto\AgentInteractionResponse;
use PHPUnit\Framework\TestCase;

final class AgentResumeTest extends TestCase {

	public function testExplicitApprovalsAndFreeTextAreDistinct(): void {
		$explicit = new AgentResume('opaque', [new AgentInteractionResponse('r', 'deny')]);
		$this->assertTrue($explicit->hasExplicitResponses());
		$this->assertFalse($explicit->hasResponseText());
		$this->assertSame('opaque', $explicit->getResumeHandle());
		$this->assertCount(1, $explicit->getResponses());
		$this->assertSame($explicit->toArray(), AgentResume::fromArray($explicit->toArray())->toArray());
		$text = AgentResume::fromArray(['resume_handle' => 'opaque', 'response' => '  details  ']);
		$this->assertFalse($text->hasExplicitResponses());
		$this->assertTrue($text->hasResponseText());
		$this->assertSame('details', $text->getResponseText());
		$this->assertSame('details', $text->toArray()['response_text']);
	}

	public function testEmptyHandleAndForeignResponsesAreRejected(): void {
		foreach ([[' ', []], ['opaque', ['approve']]] as [$handle, $responses]) {
			try {
				new AgentResume($handle, $responses);
				$this->fail('Invalid resume accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
		$this->expectException(\InvalidArgumentException::class);
		AgentResume::fromArray(['resume_handle' => 'opaque', 'responses' => ['approve']]);
	}
}
