<?php

declare(strict_types=1);

?>
{{-- Page Component --}}
@props([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null,
    'data' => [],
])

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
<<<<<<< Updated upstream
        @foreach($blocks as $block)
            {{-- BlockData ha già gestito tutto: vista, dati, fallback --}}
            @include($block->view, array_merge($data, $block->data))
=======
        @foreach($blocks as $index => $block)
            @php
                $blockType = (string) data_get($block, 'type', 'content');
                $delayStep = (($index % 5) + 1);
                $isEnabled = data_get($block, 'enabled', true);
                $blockData = data_get($block, 'data', []);
                $blockView = data_get($block, 'view', '');
            @endphp

            @if($isEnabled)
            <section
                class="reveal-kinetic kinetic-delay-{{ $delayStep }} page-block page-block-{{ str_replace('_', '-', $blockType) }}"
                data-kinetic-block
                data-block-index="{{ $index }}"
                data-block-type="{{ $blockType }}"
            >
                @if(isset($blockData['component']))
                    @php
                        $livewireParams = [];
                        foreach (($blockData['params'] ?? []) as $paramKey => $paramValue) {
                            $resolvedKey = str_ends_with($paramKey, '_key') ? substr($paramKey, 0, -4) : $paramKey;
                            if (str_ends_with($paramKey, '_key') && is_string($paramValue)) {
                                $parts = explode('.', $paramValue);
                                $val = $data;
                                foreach ($parts as $part) {
                                    $val = is_array($val) ? ($val[$part] ?? null) : (is_object($val) ? ($val->{$part} ?? null) : null);
                                }
                                $livewireParams[$resolvedKey] = $val;
                            } else {
                                $livewireParams[$resolvedKey] = $paramValue;
                            }
                        }
                    @endphp
                    @livewire($blockData['component'], $livewireParams)
                @elseif($blockView)
                    @php
                        $viewParams = [];
                        foreach (($blockData['params'] ?? []) as $paramKey => $paramValue) {
                            $resolvedKey = str_ends_with($paramKey, '_key') ? substr($paramKey, 0, -4) : $paramKey;
                            if (str_ends_with($paramKey, '_key') && is_string($paramValue)) {
                                $parts = explode('.', $paramValue);
                                $val = $data;
                                foreach ($parts as $part) {
                                    $val = is_array($val) ? ($val[$part] ?? null) : (is_object($val) ? ($val->{$part} ?? null) : null);
                                }
                                $viewParams[$resolvedKey] = $val;
                            } else {
                                $viewParams[$resolvedKey] = $paramValue;
                            }
                        }
                        $mergedParams = array_merge($data, $blockData, $viewParams);
                    @endphp
                    @include($blockView, $mergedParams)
                @endif
            </section>
            @endif
>>>>>>> Stashed changes
        @endforeach
    </div>
@endif
