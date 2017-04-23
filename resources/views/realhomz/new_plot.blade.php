<?php
if(!Auth::guest()){
    $user = Auth::user();
}
?>
<style>
    #newPlotOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #newPlotOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 32px 36px;
        padding-top: 8px;border-radius: 6px;
        width: 500px;
	    max-height: 400px;
	    overflow: hidden;
	    overflow-y: auto;
    }

    @media only screen and (max-width: 760px) {
        #newPlotOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
	        height: 100vh;
	        max-height: calc(100vh - 20px) !important;
        }
    }
</style>
<div id="newPlotOuter" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewPlot()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">New Plot</h5>

            <button disabled onclick="addNewPlot()" class="btn save-new-plot" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeNewPlot()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="newPlot" method="POST" action="/createPlot" onsubmit="addNewPlot(event)">
                <h3 class="hidden-xs">New Plot</h3>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                {{csrf_field()}}
	            @if(isset($cur_real))
		            <input type="hidden" name="real_id" value="{{$real->id}}">
	            @endif

                <label>Name</label>
                <input autocomplete="off" id="newPlotTitle" name="name" type="text" placeholder="eg. Farming Plot" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Price</label>
                <input autocomplete="off" id="newPlotPrice" name="price" type="number" placeholder="price of the plot" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Size(square meter)</label>
                <input autocomplete="off" id="newPlotSize" name="size" type="number" placeholder="Size of the plot" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Plot Number</label>
                <input autocomplete="off" id="newPlotNumber" name="plot_number" type="text" placeholder="Plot number of the plot" style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Block</label>
                <input autocomplete="off" id="newPlotBlock" name="block" type="text" placeholder="Block where the plot is" style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Street</label>
                <input autocomplete="off" id="newHomeStreet" name="street" type="text" placeholder="Plot Street" style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Town</label>
                <input autocomplete="off" id="newHomeTown" name="town" type="text" placeholder="Plot Town" style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Description</label>
                <textarea id="newPlotDesc" placeholder="Short description about plot" name="description" cols="10" rows="5" required onkeyup="setSubmit()"></textarea>

                <label>Topographical Nature: </label>

                <select name="topographical_nature" id="newPlotNature" onchange="setSubmit()">
                    <option value="Valley(Bondeni)">Valley(Bondeni)</option>
                    <option value="Level ground(Tambarare)">Level ground(Tambarare)</option>
                    <option value="Hill land">Hill Land</option>
                    <option value="Shrubs(Vichaka)">Shrubs(Vichaka)</option>
                    <option value="Foresty(Msitu)">Foresty(Msitu)</option>
                    <option value="Steep land(Mteremkoni)">Steep land(Mteremkoni)</option>
                </select>
                <button disabled class="btn btn-primary save-new-plot hidden-xs" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn" type="submit" onclic="addNewPlot()">CREATE</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to create a plot</p>
        @endif
    </div>
</div>

<script>
    var curTitle;
    $("#newProjectTitle").val("");
    function closeNewPlot() {
        $("#newPlotOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#newPlotTitle").val("");
    }

    function openNewPlot() {
        $("#newPlotOuter").addClass("open");
        $("#newPlotTitle").focus();
        $("body").addClass("locked");

        cur_real = <?php echo isset($cur_real) ? json_encode($cur_real) : "null"?>;
        if(cur_real && cur_real != "null"){
		    var new_home = $("#newPlot");

		    new_home.find("input, select, textarea").each(function(){
			    var my_name = $(this).prop("name");
			    if(cur_real.hasOwnProperty(my_name) && cur_real[my_name] != null){
				    $(this).val(cur_real[my_name]);
			    }
		    });

		    new_home.find("h3").text("Edit Plot");
		    new_home.find("button").text("SAVE");
	    }
    }

    function addNewPlot(e){
	    if(e){
            e.preventDefault();
        }

        showLoading();
        curTitle = $("#newPlotTitle").val();
        setSubmit("");

        var formdata = new FormData($("#newPlot")[0]);
        // formdata.append("_token", $(_token).val());

        $.ajax({
            type:'POST',
            url: "/createPlot",
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            if(response.success){
                console.log("Success! from new plot, ", response);
                if(response.plot){
	                showToast("success", "Plot succesfully created");
	                window.location.href = base_url + "/realhomz/plot/" + response.plot.id + "/new";
                }
                else{
                    iziToast.success({
                        title: 'Save Successfull!',
                        message: 'Reload to see changes!',
                        position: 'topRight',
                        timeout: false,
                        close:true,
                        drag:true,
                        buttons: [
                            ['<button>RELOAD</button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOutUp' }, toast);
                                window.location.reload();
                            }]
                        ]
                    });
                }
	            closeNewPlot();
            }else{
                console.log("Success! not", response);
                $('.save-new-plot').removeAttr("disabled");
                showToast("error", response.msg);
            }
        })
        .fail(function(response){
            console.log("Error!, ", response);
            $('.save-new-plot').removeAttr("disabled");
            showToast("error", "Unknown Error occured");
        })
        .always(function(){
            console.log("Action done");
            hideLoading();
        });
    }

    function setSubmit(){
        var title = $("#newPlotTitle").val();
        var price = $("#newPlotPrice").val();
        var description = $("#newPlotDesc").val();

        if(title.length > 0 && price.length > 0 && description.length > 0){
            $('.save-new-plot').removeAttr("disabled");
        }else{
            $('.save-new-plot').attr("disabled", "disabled");
        }
    }
</script>