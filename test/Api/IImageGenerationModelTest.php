<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Api;

use AssistantFoundation\Api\IImageGenerationModel;
use Base3\Api\IBase;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

final class IImageGenerationModelTest extends TestCase {

	public function testImageModelIsDiscoverable(): void {
		$this->assertTrue(is_subclass_of(IImageGenerationModel::class, IBase::class));
	}

	public function testImageModelReturnsNormalizedResult(): void {
		$this->assertSame(
			'AssistantFoundation\\Dto\\AiImageResult',
			(string)(new ReflectionMethod(IImageGenerationModel::class, 'generateResult'))->getReturnType()
		);
	}

	public function testImageModelContainsExpectedOperations(): void {
		$this->assertTrue(method_exists(IImageGenerationModel::class, 'generate'));
		$this->assertTrue(method_exists(IImageGenerationModel::class, 'setOptions'));
		$this->assertTrue(method_exists(IImageGenerationModel::class, 'getOptions'));
	}
}
