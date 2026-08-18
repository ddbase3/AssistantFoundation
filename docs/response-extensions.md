# Assistant Response Extensions

## Purpose

`IAssistantResponseExtension` defines optional response capabilities that can affect both model instructions and the consuming client UI.

Examples include structured charts, tables, canvases, or other presentation extensions that a host wants agents to use when appropriate.

## Contract

An extension is a configured component and exposes:

* stable instance id;
* label and description;
* priority;
* default enabled state;
* requirements;
* a context-dependent system prompt;
* optional `AssistantResponseClientPlugin` metadata;
* client plugin options.

## Runtime flow

```text
configured extension
  -> host resolves enabled extensions
  -> system instructions are added to the agent context
  -> agent may produce extension-compatible output
  -> host receives client plugin metadata/options
  -> browser loads the corresponding client behavior
```

The extension contract does not require every host to support every client plugin. `getRequirements()` allows a host to decide whether the extension can be activated.

## Client plugin DTO

`AssistantResponseClientPlugin` describes client-side integration metadata in a provider-neutral form. It should carry references and configuration required by the host, not server credentials.

## Examples

`IAssistantResponseExtensionExamples` can expose example prompts for administration, testing, or discoverability. It is intentionally separate from the base extension contract so examples are optional.

## Design rule

Do not make ordinary tool execution depend on response extensions. They are presentation capabilities, not a replacement for tools, context contributors, or runtime routing.
