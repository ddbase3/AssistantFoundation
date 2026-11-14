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

namespace Base3\AssistantFoundation\Test\Api;

use Base3\AssistantFoundation\Api\IImageGenerationModel;
use Base3\CoreFoundation\Api\IBase;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

final class IImageGenerationModelTest extends TestCase {

	public function testImageModelIsDiscoverable(): void {
		$this->assertTrue(is_subclass_of(IImageGenerationModel::class, IBase::class));
	}

	public function testImageModelReturnsNormalizedResult(): void {
		$this->assertSame(
			'Base3\AssistantFoundation\\Dto\\AiImageResult',
			(string)(new ReflectionMethod(IImageGenerationModel::class, 'generateResult'))->getReturnType()
		);
	}

	public function testImageModelContainsExpectedOperations(): void {
		$this->assertTrue(method_exists(IImageGenerationModel::class, 'generate'));
		$this->assertTrue(method_exists(IImageGenerationModel::class, 'setOptions'));
		$this->assertTrue(method_exists(IImageGenerationModel::class, 'getOptions'));
	}
}
