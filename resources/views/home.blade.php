@extends('layouts.app')


@section('head')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>

</script>
{{-- end pusher --}}
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<style>

</style>
<link rel='stylesheet' href="{{ asset('css/home.css') }}">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
@endsection

@section('content')
<div class="container">
    <div class="container">
        <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Recent</h4>
                        </div>
                        <div class="srch_bar">
                            <div class="stylish-input-group">
                                <input type="text" class="search-bar" placeholder="Search">
                                <span class="input-group-addon mr-1">
                                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                                </span>
                                <span class="btn btn-sm btn-outline-primary m-1" data-bs-toggle="modal"
                                    data-bs-target="#addNewUser">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="inbox_chat">
                        @if($userMessages > 0)
                        @foreach ($users as $key => $user)
                        <div class="chat_list @if ($key == 0)
                            active_chat
                        @endif" id="{{$user->id}}">
                            <div class="chat_people">
                                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png"
                                        alt="sunil"> </div>
                                <div class="chat_ib">
                                    <h5 class="text-capitalize">{{$user->name}}
                                        <span class="chat_date">none</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center justify-content-center mt-50">
                            <h5 class="text-muted">No Messages</h5>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="msg_user_info bg-info overflow-hidden p-3 shadow">
                    @if($userMessages > 0)
                    @if (count($users) > 0)
                    <h5 class="text-capitalize">{{$users[0]->name}}
                        <span class="chat_date userStatus">
                            @if(Cache::has('user-is-online-' . $users[0]->id))
                            <span class="text-white online">Online</span>
                            @else
                            <span class="text-secondary offline">Offline</span>
                            @endif
                        </span>
                    </h5>
                    @endif
                    @else
                    <h5 class="text-muted">No Messages</h5>
                    @endif
                </div>
                <div class="mesgs">
                    @if($userMessages > 0)
                    <div class="msg_history">
                        &nbsp;
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <input type="text" class="write_msg" placeholder="Type a message" />
                            <button class="msg_send_btn" type="button"><i class='fa fa-send'></i></button>
                        </div>
                    </div>
                    @else
                    <div class="empty-inbox text-center justify-content-center mt-10">
                        <i class="fa fa-inbox fs-10" aria-hidden="true"></i>
                        <h5 class="text-muted">Empty Inbox</h5>
                    </div>
                    @endif
                </div>
            </div>


            <p class="text-center top_spac"> Contact <a target="_blank" href="#">Rayhan Al Shorif</a></p>

        </div>
    </div>
</div>
<!-- Modal -->
@include('_partials.userAddModal')

<input id="currentUserId" hidden value="{{Auth::user()->id}}" />
@endsection

@push('scripts')
<script src=" https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="{{ asset('js/home/chat.js') }}"></script>

@endpush
