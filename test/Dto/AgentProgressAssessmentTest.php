<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentProgressAssessment;
use PHPUnit\Framework\TestCase;

final class AgentProgressAssessmentTest extends TestCase {

	public function testEachProgressVerdictHasDistinctIndicatorsAndSerializedEvidence(): void {
		foreach (AgentProgressAssessment::getAllowedVerdicts() as $verdict) {
			$assessment = new AgentProgressAssessment(5, $verdict, 2, 'observation', ['new'], ['old'], ['source' => 'tool']);
			$this->assertSame($verdict === AgentProgressAssessment::VERDICT_PROGRESS, $assessment->hasProgress());
			$this->assertSame($verdict === AgentProgressAssessment::VERDICT_STALLED, $assessment->isStalled());
			$this->assertSame(5, $assessment->getIteration());
			$this->assertSame(2, $assessment->getConsecutiveStalledIterations());
			$this->assertSame('observation', $assessment->getReason());
			$this->assertSame(['new'], $assessment->getCurrentSignatures());
			$this->assertSame(['old'], $assessment->getRepeatedSignatures());
			$this->assertSame(['source' => 'tool'], $assessment->getMetadata());
			$this->assertSame($verdict, $assessment->toArray()['verdict']);
		}
	}

	public function testInvalidVerdictAndNegativeStallCountAreRejected(): void {
		foreach ([['unknown-bad', 0], ['progress', -1]] as [$verdict, $stalled]) {
			try {
				new AgentProgressAssessment(0, $verdict, $stalled, 'reason');
				$this->fail('Invalid progress assessment accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
