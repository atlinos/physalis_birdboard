<div class="card mt-3">
    <ul class="text-xs list-reset">
        @foreach($model->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }}">
                @include('activities.' . $activity->description)
                <span class="text-grey">{{ $activity->created_at->locale('fr_FR')->diffForHumans(null, true) }}</span>
            </li>
        @endforeach
    </ul>
</div>