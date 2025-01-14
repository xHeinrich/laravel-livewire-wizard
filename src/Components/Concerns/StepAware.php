<?php

namespace Spatie\LivewireWizard\Components\Concerns;

use Livewire\Livewire;
use Spatie\LivewireWizard\Support\Step;

trait StepAware
{
    public function bootedStepAware()
    {
        $currentFound = false;

        $currentStepName = Livewire::getAlias(static::class);

        $this->steps = collect($this->allStepNames)
            ->map(function (string $stepName) use (&$currentFound, $currentStepName) {
                $className = Livewire::getClass($stepName);

                $info = (new $className())->stepInfo();

                $status = $currentFound ? 'next' : 'previous';


                if ($stepName === $currentStepName) {
                    $currentFound = true;
                    $status = 'current';
                }

                return new Step($stepName, $info, $status);
            })
            ->toArray();
    }
}
