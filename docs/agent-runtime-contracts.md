# Agent Runtime Contracts

## Purpose

This document explains the AssistantFoundation contracts that connect consumers, AssistantRuntime, and concrete agent runtimes.

## Execution

`IAgentExecutionService` is the generic entry point:

```php
public function execute(
    AgentExecutionRequest $request,
    ?IAgentEventSink $eventSink = null
): AgentExecutionResult;
```

A consumer supplies an `AgentExecutionRequest`. The configured router selects a runtime and returns a typed `AgentExecutionResult`.

`IAgentRuntimeService` extends the execution service and adds static runtime metadata:

* runtime id;
* label;
* description;
* default priority.

These values allow discovery without instantiating runtime-specific administration code.

## Registry and selector

`IAgentRuntimeRegistry` discovers runtime capability implementations and resolves the service for a selected runtime id.

It exposes separate capability lookups for:

* execution;
* configuration forms;
* conversations;
* isolated text tasks.

A runtime can therefore implement normal execution without falsely advertising a conversation or text-task capability.

`IAgentRuntimeSelector` interprets stored agent configuration and selects the runtime id. The default runtime id is part of the selector policy, not part of every consumer.

## Conversation operations

`IAgentConversationService` provides explicit operations:

* get state;
* create;
* activate;
* rename;
* delete;
* append message;
* touch.

`IAgentConversationRuntimeService` binds those operations to one runtime id.

This contract is deliberately separate from normal execution. UI conversation management must not simulate lifecycle operations by sending hidden chat turns.

## Isolated text tasks

`IAgentTextTaskService` executes `AgentTextTaskRequest` and returns `AgentTextTaskResult`.

Text tasks are intended for isolated operations such as title generation or auxiliary text production. A runtime decides how to honor optional context/tool profile inclusion, but the contract does not make a text task a conversation turn.

`IAgentTextTaskRuntimeService` binds this capability to one runtime id.

## Configuration forms

`IAgentConfigFormService` is runtime-neutral and can compose settings for multiple runtimes.

`IAgentRuntimeConfigFormService` is owned by one runtime. It provides:

* defaults;
* normalization;
* posted settings parsing;
* posted view values;
* stored-settings to view-value conversion;
* a configuration summary;
* a template path;
* template data.

This split lets shared UIs render the selected runtime without importing runtime-specific form logic.

## Event sink

`IAgentEventSink` receives typed `AgentExecutionEvent` objects during execution and exposes `isCancelled()`.

The sink is caller-owned. A runtime should treat it as an optional output and cancellation boundary, not as persistent conversation storage.

## Context profiles

`IAgentContextProfileProvider` is discoverable and owns one namespace of context profiles. `IAgentContextProfileService` aggregates providers and presents one runtime-neutral profile namespace to consumers.

Profile build output is `AgentContextProfileResult`, which contains ordered `AgentInstructionBlock` values and warnings.

## Tool profiles

`IAgentToolProfileProvider` resolves one provider's profile ids into `IAgentToolSet`. `IAgentToolProfileService` aggregates providers.

`IAgentToolSet` exposes:

* a typed `AgentCapabilityCatalog`;
* warnings;
* execution of one named function.

`IAgentConfirmableToolSet` adds preparation and resume of suspended calls.

## Suspension repository

`IAgentSuspensionRepository` owns durable server-side suspension state. The sequence is:

```text
create -> resume handle
findPending by scope
findAll by scope -> active and terminal interaction lifecycle
claim handle -> claim token + suspension
release on recoverable failure
consume after successful completion + terminal resolution
```

The opaque handle is the client-facing reference while the suspension is active. Full resume state remains server-side. Terminal lifecycle entries keep only the interaction information required to restore the user-visible history.

## Source-defined agents and editable configurations

`IAgentDefinition` is a classmap-discoverable contract. Any BASE3 plugin can
publish one or more code-owned agents by implementing it. Every implementation
has a unique classmap `getName()`, a globally unique fixed `getId()`, a stable
fixed `getLabel()` and editable `getDefaultSettings()`. The definition never
writes to SettingsStore and must not implement a second execution runtime.

`IAgentConfigurationService` is the one consumer-facing contract for agent
configuration. In the standard `agent` group it resolves stored records and
all discovered definitions together. A defined agent exists without a stored
record. The implementation must preserve existing saved configuration, force
only the code-owned identity label, prevent deletion, and permit updates to
all other settings. It must reject duplicate definition IDs and must not
silently repair malformed stored fixed-agent records.

Consumers resolve an agent with `getAgent($id)` or list through `getAgents()`.
To edit use `saveAgent($id, $settings)`; deletion is permitted only for
non-fixed agents. `isFixed($id)` lets UIs display immutable identity fields.
Custom SettingsStore groups passed to the read methods do not inherit the
`agent` group's code-owned declarations. Authorization remains the caller's
responsibility and execution continues through `IAgentExecutionService`.

Definitions are project or domain code. They are not a replacement for
configurable orchestrator profiles, model presets or memory implementations.
