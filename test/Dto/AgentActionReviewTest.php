<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentActionReview;
use PHPUnit\Framework\TestCase;

final class AgentActionReviewTest extends TestCase {

	public function testReviewRoundTripRetainsUserFacingSummary(): void {
		$review = AgentActionReview::fromArray(['title' => ' Delete user ', 'message' => ' Confirm carefully ', 'summary' => ['user' => 'one']]);
		$this->assertSame('Delete user', $review->getTitle());
		$this->assertSame('Confirm carefully', $review->getMessage());
		$this->assertSame(['user' => 'one'], $review->getSummary());
		$this->assertSame($review->toArray(), AgentActionReview::fromArray($review->toArray())->toArray());
		$this->assertSame([], AgentActionReview::fromArray(['title' => 'Action', 'message' => 'Message', 'summary' => 'unexpected'])->getSummary());
	}

	public function testMissingTitleOrMessageIsRejected(): void {
		foreach ([['title' => '', 'message' => 'message'], ['title' => 'Title', 'message' => ' ']] as $data) {
			try {
				AgentActionReview::fromArray($data);
				$this->fail('Missing action review text accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
