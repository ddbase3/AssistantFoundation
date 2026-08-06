<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Api;

use AssistantFoundation\Api\IConfigurableVectorSearch;
use AssistantFoundation\Api\IVectorSearch;
use PHPUnit\Framework\TestCase;

final class IConfigurableVectorSearchTest extends TestCase {

	public function testConfiguredSearchExtendsVectorSearchContract(): void {
		$this->assertTrue(is_subclass_of(IConfigurableVectorSearch::class, IVectorSearch::class));
	}

	public function testConfiguredSearchExposesRuntimeOptions(): void {
		$this->assertTrue(method_exists(IConfigurableVectorSearch::class, 'setOptions'));
		$this->assertTrue(method_exists(IConfigurableVectorSearch::class, 'getOptions'));
	}
}
