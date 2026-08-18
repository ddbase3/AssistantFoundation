# AssistantFoundation Architecture and Boundary

## Purpose

This document explains the architectural ownership rules for AssistantFoundation.

## Foundation rule

AssistantFoundation defines stable shared contracts. It should stay implementation-light.

```text
AssistantFoundation
  Api/
  Dto/
  Event/
  Exception/

Implementation plugins
  implement AssistantFoundation interfaces

Consumer plugins
  depend on AssistantFoundation interfaces

Project/runtime composition
  selects final implementations
```

The Foundation must not become a hidden implementation plugin.

## Discoverable components versus known services

Some contracts represent discoverable components. They generally extend BASE3 `IComponent` or `IBase` and are discovered through `IClassMap` or resolved as configured components.

Examples:

* `IAgentStage`
* `IAgentActionPolicy`
* `IAgentCapabilityProvider`
* `IAgentModule`
* `IAgentContextContributor`
* `IAssistantResponseExtension`
* `IConnectionDriverDefinition`
* `IServiceDriverDefinition`
* `IPhoneticEncoder`

Other contracts represent one active shared runtime service and belong in the DI container.

Examples:

* `IAgentExecutionService`
* `IAgentRuntimeRegistry`
* `IAgentRuntimeSelector`
* `IAgentSuspensionRepository`
* `IAgentCapabilitySelector`

Direct adapter contracts such as `IAiChatModel` and `IRetrievalIndex` are often instantiated from a configured service or component rather than bound globally as one final provider.

## Runtime identity

Runtime implementations expose an explicit runtime id through `IAgentRuntimeService::getRuntimeId()` and companion runtime capability contracts.

The runtime id is not an implementation class name. It is the stable public routing key used by AssistantRuntime and stored agent configuration.

A missing selected runtime is an error at the runtime selection boundary. A router must not silently choose an unrelated runtime.

## Conversation, context, memory, and tools

These concepts are intentionally separate:

* conversation memory stores visible conversation history;
* agent context stores run-local variables and exposes the active memory;
* context contributors add typed instruction blocks;
* context profiles select and order context contributions;
* tool profiles resolve tool sets;
* tool sets expose a catalog and execute calls;
* suspensions represent server-owned paused interactions requiring a future response.

Merging these responsibilities into one generic profile or memory abstraction would erase important security and lifecycle boundaries.

## DTO boundary

DTOs are used where structured values cross plugin boundaries. They should not contain service dependencies or provider-specific transport clients.

A runtime may maintain additional internal objects, but external consumers should receive Foundation DTOs whenever the contract defines them.

## Extension ownership

When a MissionBay-specific concept becomes useful to another runtime, move the stable minimal contract into AssistantFoundation and keep runtime implementation logic in MissionBay.

Do not move an entire implementation subsystem merely because one interface is shared.

## Compatibility

Compatibility contracts may remain broader than the newest runtime model. New code should prefer the narrowest modern contract while respecting existing interface signatures.
