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

use Base3\AssistantFoundation\Dto\AgentActionReview;
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
