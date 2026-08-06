# Service and Connection Driver Contracts

## Purpose

AssistantFoundation owns the discoverable contracts used to contribute provider and driver integrations without modifying MissionBay or another consuming runtime.

The shared contracts are:

```text
AssistantFoundation\Api\IServiceDriverDefinition
AssistantFoundation\Api\IConnectionDriverDefinition
AssistantFoundation\Api\IImageGenerationModel
AssistantFoundation\Api\IAiChatModel
AssistantFoundation\Api\IAiEmbeddingModel
AssistantFoundation\Api\IAiProvider
AssistantFoundation\Api\IConfigurableVectorSearch
```

AssistantFoundation defines the extension boundary. It does not select final providers, store connection credentials, render administration forms, or contain concrete HTTP implementations.

## One service-driver contract

All service types use `IServiceDriverDefinition`.

A definition supplies:

```text
driver id
service type
human-readable label
connection requirement and supported connection types
runtime implementation interface
runtime implementation getName() value
editable service schema
default service configuration
```

There are no chat-specific, image-specific, provider-specific, or project-specific driver-definition interfaces. A specialty plugin can add a new driver by implementing the one shared contract.

Example:

```php
<?php declare(strict_types=1);

namespace ExampleImageProvider\ServiceDriver;

use AssistantFoundation\Api\IImageGenerationModel;
use AssistantFoundation\Api\IServiceDriverDefinition;
use ExampleImageProvider\ImageModel\ExampleImageModel;

final class ExampleImageServiceDriverDefinition implements IServiceDriverDefinition {

	public static function getName(): string {
		return 'exampleimageservicedriverdefinition';
	}

	public function getDriver(): string {
		return 'example-image';
	}

	public function getServiceType(): string {
		return 'image';
	}

	public function getLabel(): string {
		return 'Example Image';
	}

	public function requiresConnection(): bool {
		return true;
	}

	public function getSupportedConnectionTypes(): array {
		return ['http'];
	}

	public function getImplementationInterface(): string {
		return IImageGenerationModel::class;
	}

	public function getImplementationName(): string {
		return ExampleImageModel::getName();
	}

	public function getConfigSchema(): array {
		return [
			'type' => 'object',
			'properties' => [
				'model' => [
					'type' => 'string',
					'label' => 'Model',
					'required' => true
				]
			]
		];
	}

	public function getDefaultConfig(): array {
		return [
			'serviceType' => 'image',
			'driver' => 'example-image',
			'model' => '',
			'enabled' => true,
			'options' => []
		];
	}
}
```

The class map discovers both the definition and the named runtime implementation. Consumers resolve the implementation from the definition instead of maintaining a driver map.

## Connection-driver contract

`IConnectionDriverDefinition` describes one discoverable connection type and its connection-only settings.

Connection definitions own fields such as:

```text
base URL
authentication type
authentication header
secret resolver definition
default connection timeout
connection-specific options
```

A service-driver schema must not duplicate those values. A driver may declare an operation-specific request timeout only when that is a real operation setting rather than a second connection definition.

## Configuration ownership

The architecture boundary is strict:

```text
Connection configuration
  owns endpoint, authentication, secret and the default connection timeout

Service configuration
  references one connection
  owns driver, model, enabled state and explicitly declared operation-specific options

Runtime adapter
  receives the resolved connection and service values
  translates them into the provider request and normalized result
```

The same connection can therefore be reused by chat, embedding, image, search, speech, parser, or other configured services without copying credentials.

## Provider plugins

A provider plugin normally contributes:

```text
one or more IAiProvider transport implementations
one or more runtime model/service implementations
one IServiceDriverDefinition per configurable service driver
optionally one IConnectionDriverDefinition for a new connection protocol
```

Concrete provider selection remains a project/runtime concern. AssistantFoundation contains only stable contracts and shared DTOs.

## Dependency direction

Recommended dependency direction:

```text
Specialty provider plugin -> AssistantFoundation
MissionBay built-in implementation -> AssistantFoundation
MissionBay configured runtime -> AssistantFoundation definitions + selected runtime interface
Project plugin -> final provider/plugin composition
```

A runtime interface that uses MissionBay-owned DTOs or behavior remains in MissionBay. Its driver definition still uses the shared `IServiceDriverDefinition`, so no second definition family is introduced.


## Configurable vector search

`IConfigurableVectorSearch` extends the provider-neutral `IVectorSearch` contract with `setOptions()` and `getOptions()`. It is the runtime implementation interface for discoverable vector-search service drivers. A consuming runtime loads the referenced connection and service settings, then supplies the resolved values to the implementation.

The configured adapter therefore receives values such as `endpoint`, `auth_type`, `auth_header_name`, the resolved authentication secret, `collection`, and timeouts. It must not persist or resolve credentials itself.
