<section class="short">
    <div class="section-header text-center">
        <h3>Pages</h3>
        <p>
            Here's are the site pages click the button below to add a new pages.<br>

            <button class="round-btn" style="padding: 5px 20px; min-width: 0">Add new page</button>
        </p>
    </div>
</section>
<section class="layout center-justified">
    <table class="page-table">
        <thead>
            <tr>
                <th>NAME</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{$page->title}}</td>
                    <td>{{$page->url}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>