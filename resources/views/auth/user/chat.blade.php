
@extends('layouts.app')
@section('content')

<div class="conatiner">
    <div class="row">
    <div class="col-3">
         your friends list
         @foreach($join as $ch)
            <ul id ="pendingdRequest">
                @if(Auth::user()->id == $ch->sender_id)
                <a href="{{route('letschat',$ch->reciver_id)}}"> <li id=" {{$ch->reciver_id}}">{{getReciverName($ch->reciver_id)}}</li></a>
                @else
                <a href="{{route('letschat',$ch->sender_id)}}"><li id=" {{$ch->sender_id}}">{{getReciverName($ch->sender_id)}}</li></a>
            
                    @endif
                </ul>
                @endforeach
        </div>
        <div class="col-3">
            request pending at 
            @foreach($chat_sender as $ch)
            <ul id ="pendingdRequest"> 
                <li id=" {{$ch->reciver_id}}">
                {{$ch->reciver_id}}
               </li>
            
            </ul>
            @endforeach
        </div>
        <div class="col-3">
            request recived from 
            @foreach($chat_reciver as $_reciver)
            <ul id ="recivedRequest"> 
                <li id=" {{$_reciver->sender_id}}">
                {{$_reciver->sender_id}}
               </li>
            
            </ul>
            @endforeach
        </div>
        <div class="col-3">
        click the user name to send the request
            @foreach($user as $user)
            <ul id="sendRequest"> 
                <li id="{{$user->id}}">
                   {{$user->name}}
               </li>
            </ul>
            @endforeach
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
    $('#sendRequest li').on('click', function() {
        var id  =$(this).attr('id');
        alert(id);
        $.ajax({
            headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
            url:'sendReequest',
            type:'POST',
            data:{
                'id': id
            },
            success:function(data){
                alert(data);     
              }
            });


    });
    $('#recivedRequest li').on('click', function() {
        var id  =$(this).attr('id');
        alert(id);
        $.ajax({
            headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
            url:'acceptReequest',
            type:'POST',
            data:{
                'id': id
            },
            success:function(data){
                alert(data);     
              }
            });


    });
});


    </script>
</div>
@endsection
