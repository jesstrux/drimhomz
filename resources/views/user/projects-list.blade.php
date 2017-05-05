@foreach($projects as $project)
    <?php
    $house_count = $project->houses()->count();
    $trailingS = $house_count == 1 ? "" : "s";
    $houses_text = $house_count > 0 ? $project->houses()->count() : "No";
    $houses_text .= " house" . $trailingS;
    ?>

    <a href="{{url('/project/').'/'.$project->id}}" class="house-card">
        <div class="image" style="pointer-events: auto;">
            {!! $project->cover() !!}
        </div>
        <div class="content">
            <h3 style="line-height: 30px;margin: 0; margin-top: 4px;">{{$project->title}}</h3>
        </div>
    </a>
@endforeach