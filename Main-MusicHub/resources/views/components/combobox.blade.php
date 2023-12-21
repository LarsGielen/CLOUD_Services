@props(['class' => '', 'submitOnSelect' => false, 'id' => '', 'name' => ''])

@php
$onchangevalue = ($submitOnSelect ?? false)
            ? "this.form.submit()"
            : "";
@endphp

<select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $class }}"  onchange="{{ $onchangevalue }}" id="{{ $id }}" name="{{ $name }}">
    {{ $Content }}
</select>