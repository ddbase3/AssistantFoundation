<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiModelConfiguration;
use PHPUnit\Framework\TestCase;

final class AiModelConfigurationTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new AiModelConfiguration('test', 'Test model', 'api', 'mistral', 'https://example.test/model', 'secret-token', ['temperature' => 0.4]);
		$this->assertSame('test', $dto->getId());
		$this->assertSame('Test model', $dto->getLabel());
		$this->assertSame('api', $dto->getDriver());
		$this->assertSame('mistral', $dto->getModel());
		$this->assertSame('https://example.test/model', $dto->getEndpoint());
		$this->assertSame('secret-token', $dto->getApiKey());
		$this->assertSame(['temperature' => 0.4], $dto->getOptions());
	}
}
