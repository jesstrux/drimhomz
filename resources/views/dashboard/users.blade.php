<section class="short">
    <div class="section-header text-center">
        <h3>Manage users</h3>
        <p>
            Here are the site users, click the button to manage or add a new one.<br>

            <button class="round-btn" style="padding: 5px 20px; min-width: 0">Manage users</button>
            <button class="round-btn dark" style="padding: 5px 20px; min-width: 0">New user</button>
        </p>
    </div>
</section>
<section class="layout center-justified">
    <table class="page-table">
        <thead>
            <tr>
                <th>NAME</th>
                <th>PHONE</th>
                <th>ROLE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @if(count($users) < 2)
                <tr>
                    <td colspan="4">No users</td>
                </tr>
            @endif

            @foreach($users as $user)
                <?php 
                    $isMe = $user->id == Auth::user()->id;
                    $isAdmin = $user->role == "admin" ? "is-admin" : "";
                ?>
                @if(!$isMe)
                    <tr>
                        <td>
                            <?php
                                $user_url = "/user/$user->id";
                            ?>
                            <a href="{{ url($user_url) }}">
                                {{$user->full_name()}}
                            </a>
                        </td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->role}}</td>
                        <td>
                            <form id="addAdmin{{$user->id}}" role="form" method="POST" action="{{ url('make-admin') }}" class="{{$isAdmin}}">
                                {{ csrf_field() }}

                                <input type="hidden" name="id" value="{{$user->id}}">
                                
                                <button type="submit" class="btn dark btn-sm">Remove</button>

                                <button type="button" class="remove-admin-btn btn btn-default btn-sm" onclick="toggleAdmin('toggle-admin', {{$user->id}})">Remove Admin</button>

                                <button type="button" class="add-admin-btn btn material-blue btn-sm" onclick="toggleAdmin('toggle-admin', {{$user->id}})">Make Admin</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</section>

<script>
    function toggleAdmin(url, id){
        var formdata = new FormData($("#addAdmin"+id)[0]);
        formdata.append('id', id);

        $.ajax({
              type:'POST',
              url: url,
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
            if(response.success){
                console.log("Switching now!!!");
                $("#addAdmin"+id).toggleClass('is-admin');
            }
        })
        .fail(function(response){
            console.log("Response!, ", response);
        })
        .always(function(){
            console.log("Action done");
        });
    }
</script>