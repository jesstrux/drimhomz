<div>
    <h4>Location:</h4>
    <div>
        <span><b>Country:</b> {{$shop->country}}</span>
        <span class="real-description hidden-xs"><br><b>Town:</b> {{$shop->town}}</span>
    </div>

    <br>
    <h4>Statements:</h4>
    <div>
        <label>Quality Statement: </label>
        <div>{{$shop->quality_statement}}</div>
    </div>
    <br>
    <div>
        <label>Service Statement:</label>
        <div>{{$shop->service_statement}}</div>
    </div>
</div>