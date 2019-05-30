@if(count($activity->changes['after']) == 1)
    {{ $activity->user->name }} a mis à jour {{ __('dict.person.' . key($activity->changes['after'])) }}
    de {{ $activity->subject->firstname }} {{ $activity->subject->name }}
@else
    {{ $activity->user->name }} a mis à jour {{ $activity->subject->firstname }} {{ $activity->subject->name }}
@endif