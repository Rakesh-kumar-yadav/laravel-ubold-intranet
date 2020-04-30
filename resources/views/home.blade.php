@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <span class="badge badge-danger width-lg font-14" style="margin-top: 5px;">{{ date('d F Y') }}</span>
                </div>
                <h4 class="page-title">@lang('dashboard.welcome') {{ Auth()->user()->name }} !</h4>
                @php $message_id = \App\Models\Message::max('id') @endphp
                @if (isset($message_id))
                    <a href="#" data-toggle="modal" data-target="#view-message"><h5><i class="fas fa-info-circle"></i>&nbsp;&nbsp; {{ \App\Models\Message::find($message_id)->admin_title }}</h5></a>
                @endif
            </div>
        </div>
    </div>

    {{-- widget api --}}
    <a class="weatherwidget-io" href="https://forecast7.com/en/3d14101d69/kuala-lumpur/" data-label_1="KUALA LUMPUR" data-label_2="WEATHER" data-icons="Climacons Animated" data-days="3" data-theme="pure" >KUALA LUMPUR WEATHER</a>
    <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
    </script>
    
    {{-- <div class="row mt-2">
        <div class="col-md-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">@lang('dashboard.widget.today_event')</h4>
                <h2 class="text-primary my-3 text-center">$<span data-plugin="counterup">31,570</span></h2>
                <p class="text-muted mb-0">@lang('dashboard.widget.total_event'): 22506 <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>10.25%</span></p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">@lang('dashboard.widget.assigned_task')</h4>
                <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">683</span></h2>
                <p class="text-muted mb-0">@lang('dashboard.widget.total_task'): 2398 <span class="float-right"><i class="fa fa-caret-down text-danger mr-1"></i>7.85%</span></p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">@lang('dashboard.widget.project')</h4>
                <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">3.2</span>M</h2>
                <p class="text-muted mb-0">@lang('dashboard.widget.total_project'): 121 M <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>3.64%</span></p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
                <h4 class="mt-0 font-16">@lang('dashboard.widget.overdue_assigned_task')</h4>
                <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">3.2</span>M</h2>
                <p class="text-muted mb-0">@lang('dashboard.widget.total_task'): 121 M <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>3.64%</span></p>
            </div>
        </div>
    </div> --}}

    <div class="row mt-3">
        <!-- Memos -->
        <div class="col-xl-3">
            <div class="card-box product-box ribbon-box" style="height: 500px;">
                <div class="ribbon ribbon-danger float-left"><i class="mdi mdi-access-point mr-1"></i> @lang('dashboard.memo.title')</div>
                @php $id = \App\Models\Memo::max('id') @endphp
                <div class="product-action">
                    <a class="dropdown-item" href="{{ route('memos.show', $id) }}" ><i class="fe-eye mr-2"></i> @lang('dashboard.memo.field.action.view')</a>
                    <a class="dropdown-item" href="{{ route('memos.index') }}"><i class="fe-folder mr-2"></i> @lang('dashboard.memo.achieved')</a>
                </div>

                <div class="product-info mt-4">
                    <div class="row align-items-center">
                        <div class="col-md-12 text-center">
                            @if (isset($id))
                                <embed id="memo_content" src="{{url('/assets/' . \App\Models\Memo::find($id)->file_path)}}#toolbar=0" style="width:100%; height:380px;" />
                            @endif
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end product info-->
            </div> <!-- end card-box-->
        </div> <!-- end col -->
        <!-- Todos app -->
        <div class="col-xl-9">
            <div class="card-box" style="height:500px;">
                <h4 class="header-title mb-3">My To Do</h4>
                <div class="todoapp">
                    <div class="row">
                        <div class="col">
                            <h5 id="todo-message"><span id="todo-remaining"></span> of <span id="todo-total"></span> remaining</h5>
                        </div>
                        <div class="col-auto">
                            <a href="" class="float-right btn btn-light btn-xs waves-effect waves-light" id="btn-archive">Archive</a>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush slimscroll todo-list" id="todo-list"></ul>

                    <div class="row">
                        <div class="col">
                            <input type="text" id="todo-input-text" name="todo-input-text" class="form-control" placeholder="Add new todo">
                        </div>
                        <div class="col-auto">
                            <button class="btn-primary btn-md btn-block btn waves-effect waves-light" type="button" id="todo-btn-submit">Add</button>
                        </div>
                    </div>
                </div> <!-- .todoapp -->
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <!-- Portlet card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="true" aria-controls="cardCollpase4" class=""><i class="mdi mdi-minus"></i></a>
                        <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                    </div>
                    <h4 class="header-title mb-0">Projects</h4>

                    <div id="cardCollpase4" class="pt-3 collapse show" style="">
                        <div class="table-responsive">
                            <table class="table table-centered table-borderless mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>Due Date</th>
                                        <th>Team</th>
                                        <th>Status</th>
                                        <th>Clients</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>App design and development</td>
                                        <td>Jan 03, 2015</td>
                                        <td>Oct 12, 2018</td>
                                        <td>
                                            <div class="avatar-group">
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme">
                                                    <img src="/assets/images/users/user-1.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Michael Zenaty">
                                                    <img src="/assets/images/users/user-2.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="James Anderson">
                                                    <img src="/assets/images/users/user-3.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Username">
                                                    <img src="/assets/images/users/user-5.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-info text-info p-1">Work in Progress</span></td>
                                        <td>Halette Boivin</td>
                                    </tr>
                                    <tr>
                                        <td>Coffee detail page - Main Page</td>
                                        <td>Sep 21, 2016</td>
                                        <td>May 05, 2018</td>
                                        <td>
                                            <div class="avatar-group">
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="James Anderson">
                                                    <img src="/assets/images/users/user-3.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme">
                                                    <img src="/assets/images/users/user-4.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Username">
                                                    <img src="/assets/images/users/user-5.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-warning text-warning p-1">Pending</span></td>
                                        <td>Durandana Jolicoeur</td>
                                    </tr>
                                    <tr>
                                        <th>Poster illustation design</th>
                                        <td>Mar 08, 2018</td>
                                        <td>Sep 22, 2018</td>
                                        <td>
                                            <div class="avatar-group">
                                                
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Michael Zenaty">
                                                    <img src="/assets/images/users/user-2.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme">
                                                    <img src="/assets/images/users/user-6.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Username">
                                                    <img src="/assets/images/users/user-7.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-success text-success p-1">Completed</span></td>
                                        <td>Lucas Sabourin</td>
                                    </tr>
                                    <tr>
                                        <td>Drinking bottle graphics</td>
                                        <td>Oct 10, 2017</td>
                                        <td>May 07, 2018</td>
                                        <td>
                                            <div class="avatar-group">
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme">
                                                    <img src="/assets/images/users/user-9.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Michael Zenaty">
                                                    <img src="/assets/images/users/user-10.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="James Anderson">
                                                    <img src="/assets/images/users/user-1.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-info text-info p-1">Work in Progress</span></td>
                                        <td>Donatien Brunelle</td>
                                    </tr>
                                    <tr>
                                        <td>Landing page design - Home</td>
                                        <td>Coming Soon</td>
                                        <td>May 25, 2021</td>
                                        <td>
                                            <div class="avatar-group">
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Michael Zenaty">
                                                    <img src="/assets/images/users/user-5.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="James Anderson">
                                                    <img src="/assets/images/users/user-8.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mat Helme">
                                                    <img src="/assets/images/users/user-2.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
        
                                                <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Username">
                                                    <img src="/assets/images/users/user-7.jpg" class="rounded-circle avatar-xs" alt="friend">
                                                </a>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-dark text-dark p-1">Coming Soon</span></td>
                                        <td>Karel Auberjo</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div> <!-- .table-responsive -->
                    </div> <!-- end collapse-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div> --}}
</div>
<div class="modal fade" id="add-category" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 d-block">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add a category</h4>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="form-group">
                        <label class="control-label">Category Name</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Choose Category Color</label>
                        <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                            <option value="primary">Primary</option>
                            <option value="success">Success</option>
                            <option value="danger">Danger</option>
                            <option value="info">Info</option>
                            <option value="warning">Warning</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>

                </form>

                <div class="text-right">
                    <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary ml-1   save-category" data-dismiss="modal">Save</button>
                </div>

            </div>
            <!-- end modal-body-->
        </div>
        <!-- end modal-content-->
    </div>
    <!-- end modal dialog-->
</div>
<div class="modal fade" id="view-message" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ \App\Models\Message::find($message_id)->admin_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>{{ \App\Models\Message::find($message_id)->admin_message }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <!-- end modal dialog-->
</div>

@endsection
@section('javascript')
    <script>
        var todoList = $('#todo-list');
        var todoTotal = $("#todo-total");
        var todoInput = $("#todo-input-text");
        var todoRemaining = $("#todo-remaining");

        $(document).ready(function () {
            generate();
            $('.slimScrollDiv').css("height", "340px");
            $('.slimscroll').css("height", "340px");

            $('#todo-btn-submit').on("click", function(e) {
                if (todoInput.val() == "" || todoInput.val() == 0 || todoInput.val() == null) {
                    sweetAlert("Oops...", "You forgot to enter todo text", "error");
                    todoInput.focus();
                } else {
                    addTodo(todoInput.val())
                }
            });
            $('#btn-archive').on("click", function(e) {
                return e.preventDefault(), archives(), !1;
            });
        });
        function addTodo(){
            $.ajax({
                url: "{{ url('/dashboard/addtodo') }}",
                type: 'post',
                dataType: 'text',
                data: {
                    text: todoInput.val(),
                },
                success: function(data) {
                    generate();
                }
            });
        }
        function generate(){
            todoList.html("");
            $.ajax({
                url: "{{ url('/dashboard/gettodo') }}",
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    todoData = data;
                    for (var t = 0, i = 0; i < data.length; i++) {
                        var e = data[i];
                        if (e.done == 1){
                            todoList.prepend('<li class="list-group-item border-0"><div class="checkbox checkbox-primary"><input class="todo-done" id="' + e.id + '" type="checkbox" checked><label for="' + e.id + '" style="width:90%">' + e.text + "</label></div></li>");
                        }
                        else{
                            t ++;
                            todoList.prepend('<li class="list-group-item border-0"><div class="checkbox checkbox-primary"><input class="todo-done" id="' + e.id + '" type="checkbox"><label for="' + e.id + '" style="width:90%">' + e.text + "</label></div></li>")
                        }
                    }
                    todoTotal.text(data.length);
                    todoRemaining.text(t);

                    $(".todo-done").change(function(e){
                        var status;
                        var id = $(this).attr("id")
                        if (this.checked){
                            status = 1;
                            t = t - 1;
                        }
                        else{
                            status = 0;
                            t = t + 1;
                        }
                        $.ajax({
                            url: "{{ url('/dashboard/updatetodo') }}",
                            type: 'post',
                            dataType: 'text',
                            data: {
                                id: id,
                                status: status,
                            },
                            success: function(data) {
                                todoRemaining.text(t);
                            }
                        });
                    });

                }
            });
        }
        function archives(){
            $.ajax({
                url: "{{ url('/dashboard/deletetodo') }}",
                type: 'post',
                dataType: 'text',
                success: function(data) {
                    generate();
                }
            });
        }
        function showMessage(message) {
            swal({
                title: "title",
                text: message,
                type: "info",
                confirmButtonClass: "btn btn-confirm mt-2",
                confirmButtonText: "{{ trans('templates.yes, delete it!') }}",
            }).then(function(e) {
                if (e.value) {
                    
                }
            });
        }
    </script>
@endsection
