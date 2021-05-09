
@if(session()->has('Success'))
    <div class="Float_MSG_Success animated fadeInDownBig slower" style="max-width: 320px;">
        <div id="Close_Btn" onclick="close_Success_div()">
            {{--<i class="fa fa-close"></i>--}}
            <i class="fa fa-times"></i>
        </div>
        <h4 style="line-height: 20px; padding: 10px; font-size: 14px; color: #06a130!important;">
            {{ session('Success') }}
        </h4>
    </div>
@endif


@if(session()->has('Error'))
    <div class="Float_MSG_Error animated fadeInDownBig slower" style="max-width: 320px;">
        <div id="Close_Btn" onclick="close_Error_div()">
            {{--<i class="fa fa-close"></i>--}}
            <i class="fa fa-times"></i>
        </div>
        <strong style="color: red;">Error:</strong>
        <ul class="Error_Ul">
            <li>- {{ session('Error') }}</li>
        </ul>
        <div style="color: black;text-align: center;">Fill the form correctly and try again.</div>
    </div>
@endif


@if($errors->any())
    <div class="Float_MSG_Error animated fadeInDownBig slower" style="max-width: 320px;">
        <div id="Close_Btn" onclick="close_Error_div()">
            {{--<i class="fa fa-close"></i>--}}
            <i class="fa fa-times"></i>
        </div>
        <strong style="color: red;">Error:</strong>
        <ul class="Error_Ul">
            @foreach($errors->all() as $err)
                <li>- {{ $err }}</li>
            @endforeach
        </ul>
        <div style="color: black;text-align: center;">Fill the form correctly and try again.</div>
    </div>
@endif








<script>
    function close_Success_div(){
        document.querySelector('.Float_MSG_Success').style.display = 'none';
    }
    function close_Success_div2(){
        document.querySelector('.Float_MSG_Success2').style.display = 'none';
    }
</script>
<script>
    function close_Error_div(){
        document.querySelector('.Float_MSG_Error').style.display = 'none';
    }
    function close_Error_div2(){
        document.querySelector('.Float_MSG_Error2').style.display = 'none';
    }
    function close_Error_div3(){
        document.querySelector('.Float_MSG_Error3').style.display = 'none';
    }
    function close_Error_div4(){
        document.querySelector('.Float_MSG_Error4').style.display = 'none';
    }
</script>


<script>
    function close_div_warning(){
        document.querySelector('.Warning_Review').style.display = 'none';
    }

    function close_div(){
        document.querySelector('.Float_MSG_Error').style.display = 'none';
    }
</script>


