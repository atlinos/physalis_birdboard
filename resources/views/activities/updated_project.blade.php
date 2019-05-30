@if(count($activity->changes['after']) == 1)
    {{ $activity->user->name }} a mis à jour {{ __('dict.project.' . key($activity->changes['after'])) }} de la généalogie
@else
    {{ $activity->user->name }} a mis à jour la généalogie
@endif