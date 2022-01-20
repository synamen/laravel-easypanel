<?php

namespace EasyPanel\Parsers\HTMLInputs;

abstract class BaseInput
{
    protected $key;
    protected $action;
    protected $mode;
    protected $label;
    protected $placeholder;
    protected $inputStyle;
    protected $autocomplete = 'on';

    public function __construct($label)
    {
        $this->label = $label;
        $this->mode = config('easy_panel.lazy_mode') ? 'wire:model.lazy' : 'wire:model';
    }

    public static function label($label)
    {
        return new static($label);
    }

    public function inputStyle($inputStyle)
    {
        $this->inputStyle = $inputStyle;

        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function lazyMode()
    {
        $this->mode = 'wire:model.lazy';

        return $this;
    }

    public function normalMode()
    {
        $this->mode = 'wire:model';

        return $this;
    }

    public function deferMode()
    {
        $this->mode = 'wire:model.defer';

        return $this;
    }

    public function withoutAutocomplete()
    {
        $this->autocomplete = 'off';

        return $this;
    }

    public function withoutAutofill()
    {
        $this->withoutAutocomplete();

        return $this;
    }

    public function render()
    {
        $array = [
            '{{ Title }}' => $this->label,
            '{{ Name }}' => $this->key,
            '{{ Mode }}' => $this->mode,
            '{{ Action }}' => $this->action,
            '{{ placeholder }}' => $this->placeholder,
            '{{ inputStyle }}' => $this->inputStyle,
            '{{ autocomplete }}' => $this->autocomplete,
        ];

        return str_replace(array_keys($array), array_values($array), file_get_contents(__DIR__.'/stubs/'.$this->stub));
    }

    public function getTitle()
    {
        return $this->label;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

}
