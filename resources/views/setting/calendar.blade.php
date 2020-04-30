@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-md-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div>
            <h4 class="page-title">@lang('global.cal setting.title')</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="card col-md-12 col-xs-12">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-lg font-16 btn-primary btn-block  ">
                        <i class="mdi mdi-plus-circle-outline"></i> Create New Event
                    </a>
                    <div id="external-events" class="m-t-20">
                        <br>
                        @foreach($events as $event)
                            <div class="external-event {{ $event->classname }}" data-class="{{ $event->classname }}">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>{{ $event->title }}
                                @if($event->user_id == \Illuminate\Support\Facades\Auth::user()->id)
                                    <button type="button" class="close" data-id="{{ $event->id }}" onclick="removeEvt(this)" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- checkbox -->
{{--                    <div class="custom-control custom-checkbox mt-3">--}}
{{--                        <input type="checkbox" class="custom-control-input" id="drop-remove">--}}
{{--                        <label class="custom-control-label" for="drop-remove">Remove after drop</label>--}}
{{--                    </div>--}}

{{--                    <div class="mt-5 d-none d-xl-block">--}}
{{--                        <h5 class="text-center">How It Works ?</h5>--}}

{{--                        <ul class="pl-3">--}}
{{--                            <li class="text-muted mb-3">--}}
{{--                                It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.--}}
{{--                            </li>--}}
{{--                            <li class="text-muted mb-3">--}}
{{--                                Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage.--}}
{{--                            </li>--}}
{{--                            <li class="text-muted mb-3">--}}
{{--                                It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}

                </div> <!-- end col-->

                <div class="col-lg-9">
                    <div id="calendar"></div>
                </div> <!-- end col -->

            </div>  <!-- end row -->
        </div>
    </div>
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
                        <input class="form-control form-white" id="category" placeholder="Enter name" type="text" name="category-name" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Choose Category Color</label>
                        <select class="form-control form-white" id="skin" data-placeholder="Choose a color..." name="category-color">
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
                    <button type="button" class="btn btn-primary ml-1   save-category" onclick="storeEvtName(0)" data-dismiss="modal">Save</button>
                </div>

            </div>
            <!-- end modal-body-->
        </div>
        <!-- end modal-content-->
    </div>
    <!-- end modal dialog-->
</div>
<div class="modal fade" id="event-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title evt-title">Add New Event</h4>
            </div>
            <div class="modal-body pt-3 pr-4 pl-4">
            </div>
            <div class="text-right pb-4 pr-4">
                <button type="button" class="btn btn-danger delete-event  " data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-success save-event  ">Create event</button>
                <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- end modal-content-->
    </div>
    <!-- end modal dialog-->
</div>
@stop

@section('javascript')
    <script>
        var CalendarApp;
        var calendar = function() {
            this.$body = $("body"),
                this.$modal = $("#event-modal"),
                this.$event = "#external-events div.external-event",
                this.$calendar = $("#calendar"),
                this.$saveCategoryBtn = $(".save-category"),
                this.$categoryForm = $("#add-category form"),
                this.$extEvents = $("#external-events"),
                this.$calendarObj = null
        };
        calendar.prototype.onDrop = function(element, n) {
            var evtObj = element.data("eventObject");
            var class_name = element.attr("data-class");
            var evtExt = $.extend({}, evtObj);
            evtExt.start = n;
            var str = evtExt.title.replace("×", "").replace("\n", "").trim();
            console.log(str);
            evtExt.title = str;
            class_name && (evtExt.className = [class_name]);
            this.$calendar.fullCalendar("renderEvent", evtExt, !0);
            $("#drop-remove").is(":checked") && element.remove();
        }
        calendar.prototype.onEventClick = function(t, n, a) {
            var obj = this;
            var form = $("<form></form>");
            form.append("<label>Event name</label>");
            form.append(
                "<div class='input-group m-b-15'>" +
                "<input class='form-control' type=text readonly='' value='" + t.title + "' />" +
                // "<span class='input-group-append'>" +
                // "<button type='submit' class='btn btn-success btn-md  '>" +
                // "<i class='fa fa-check'></i> Save" +
                // "</button>" +
                // "</span>" +
                "</div>");
            obj.$modal.modal({
                // backdrop: "static"
            });
            obj.$modal.find(".evt-title")
                .text("View/Delete event")
                .end()
                .find(".delete-event")
                .show()
                .end()
                .find(".save-event")
                .hide()
                .end()
                .find(".modal-body")
                .empty()
                .prepend(form)
                .end()
                .find(".delete-event")
                .unbind("click")
                .click(function() {
                    obj.$calendarObj.fullCalendar("removeEvents", function(e) {
                    return e._id == t._id
                });
                this.$modal.modal("hide");
            });
            obj.$modal.find("form").on("submit", function() {
                return t.title = form.find("input[type=text]").val(), obj.$calendarObj.fullCalendar("updateEvent", t), this.$modal.modal("hide"), !1
            });
        }
        calendar.prototype.onSelect = function(t, n, a) {
            var l = this;
            l.$modal.modal({
                backdrop: "static"
            });
            var i = $("<form></form>");
            i.append("<div class='row'></div>");
            i.find(".row")
                .append("<div class='col-12'>" +
                    "<div class='form-group'>" +
                    "<label class='control-label'>Event Name</label>" +
                    "<input class='form-control' placeholder='Insert Event Name' type='text' name='title'/>" +
                    "</div>" +
                    "</div>")
                .append("<div class='col-12'>" +
                    "<div class='form-group'>" +
                    "<label class='control-label'>Category</label>" +
                    "<select class='form-control' name='category'></select>" +
                    "</div>" +
                    "</div>")
                .find("select[name='category']")
                    .append("<option value='bg-danger'>Danger</option>")
                    .append("<option value='bg-success'>Success</option>")
                    .append("<option value='bg-primary'>Primary</option>")
                    .append("<option value='bg-info'>Info</option>")
                    .append("<option value='bg-dark'>Dark</option>")
                    .append("<option value='bg-warning'>Warning</option>" +
                        "</div></div>");
            l.$modal.find(".delete-event")
                .hide()
                .end()
                .find(".save-event")
                .show()
                .end()
                .find(".modal-body").empty()
                .prepend(i)
                .end()
                .find(".save-event")
                .unbind("click")
                .click(function() {
                    i.submit()
                });
            l.$modal.find("form").on("submit", function() {
                var e = i.find("input[name='title']").val();
                var a = (i.find("input[name='beginning']").val(), i.find("input[name='ending']").val(), i.find("select[name='category'] option:checked").val());
                return null !== e && 0 != e.length ? (l.$calendarObj.fullCalendar("renderEvent", {
                    title: e,
                    start: t,
                    end: n,
                    allDay: !1,
                    className: a
                }, !0), l.$modal.modal("hide")) : alert("You have to give a title to your event"), !1
            });
            l.$calendarObj.fullCalendar("unselect");
        }
        calendar.prototype.enableDrag = function() {
            $(this.$event).each(function() {
                var t = {
                    title: $.trim($(this).text())
                };
                $(this).data("eventObject", t), $(this).draggable({
                    zIndex: 999,
                    revert: !0,
                    revertDuration: 0
                })
            })
        }
        calendar.prototype.init = function() {
            this.enableDrag();
            var a = [{
                title: "Hey!",
                start: "2019-11-01",
                className: "bg-warning"
            }, {
                title: "See John Deo",
                start: "2019-11-03",
                className: "bg-success"
            }, {
                title: "See",
                start: "2019-11-03",
                className: "bg-danger"
            }, {
                title: "Meet John Deo",
                start: "2019-11-04",
                className: "bg-info"
            }, {
                title: "Buy a Theme",
                start: "2019-11-09",
                className: "bg-primary"
            }, {
                title: "Buy a Theme",
                start: "2019-12-04",
                className: "bg-primary"
            }];
            var obj = this;
            obj.$calendarObj = obj.$calendar.fullCalendar({
                slotDuration: "00:15:00",
                minTime: "08:00:00",
                maxTime: "19:00:00",
                defaultView: "month",
                handleWindowResize: !0,
                height: $(window).height() - 200,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: ""//"month,agendaWeek,agendaDay"
                },
                events: a,
                editable: !0,
                droppable: !0,
                eventLimit: !0,
                selectable: !0,
                drop: function(t) {
                    obj.onDrop($(this), t)
                },
                select: function(e, t, n) {
                    obj.onSelect(e, t, n)
                },
                eventClick: function(e, t, n) {
                    obj.onEventClick(e, t, n)
                }
            });
        }
        function storeEvtName(id){
            $.ajax({
                url: "{{ url('/calendar/storeevtname') }}",
                type: 'post',
                data: {id : id, skin: $('#skin').val(), title: $('#category').val()},
                success: function(data) {
                    if(parseInt(data) > 0) {
                        toastr.options.closeButton = true;
                        toastr.options.closeMethod = 'fadeOut';
                        toastr.options.timeOut = 2000; // How long the toast will display without user interaction
                        toastr.options.progressBar = true;
                        toastr.success("That was added successfully.", "Congratulation!");

                        var e = CalendarApp.$categoryForm.find("input[name='category-name']").val(),
                            t = CalendarApp.$categoryForm.find("select[name='category-color']").val();
                        null !== e && 0 != e.length && (CalendarApp.$extEvents.append('<div class="external-event bg-' + t + '" data-class="bg-' + t +
                            '" style="position: relative;"><i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>' + e +
                            '<button type="button" class="close" data-id="'+ data + '" onclick="removeEvt(this)" data-dismiss="alert" aria-label="Close">\n' +
                            '                                        <span aria-hidden="true">×</span>\n' +
                            '                                    </button></div>'), CalendarApp.enableDrag())
                    }
                }
            });
        }
        function removeEvt(obj){
            swal({
                title: "{{ trans('templates.are you sure?') }}",
                text: "{{ trans('templates.you would not be able to revert this!') }}",
                type: "warning",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-confirm mt-2",
                cancelButtonClass: "btn btn-cancel ml-2 mt-2",
                confirmButtonText: "{{ trans('templates.yes, delete it!') }}",
                cancelButtonText: "{{ trans('templates.cancel') }}",
            }).then(function(e) {
                if (e.value) {
                    $.ajax({
                        url: "{{ url('/calendar/destroy') }}" + "/" + $(obj).attr("data-id"),
                        type: 'post',
                        success: function(data) {
                            if(data == "ok") {
                                $(obj).parent().remove();
                                toastr.options.closeButton = true;
                                toastr.options.closeMethod = 'fadeOut';
                                toastr.options.timeOut = 2000; // How long the toast will display without user interaction
                                toastr.options.progressBar = true;
                                toastr.success("That was deleted successfully.", "Congratulation!");
                            }
                        }
                    });
                }
            });
        }
        $(document).ready(function(){
            CalendarApp = new calendar;
            CalendarApp.Constructor = calendar;
            CalendarApp.init();
            var events = CalendarApp.$calendar.fullCalendar('clientEvents');
            for (var i = 0; i < events.length; i++) {
                var start_date = new Date(events[i].start._d);
                var end_date = '';
                if (events[i].end != null) {
                    end_date = new Date(events[i].end._d);
                }
                var title = events[i].title;

                var st_day = start_date.getDate();
                var st_monthIndex = start_date.getMonth() + 1;
                var st_year = start_date.getFullYear();

                var en_day ='';
                var en_monthIndex = '';
                var en_year = '';
                if (end_date != '') {
                    en_day = end_date.getDate()-1;
                    en_monthIndex = end_date.getMonth()+1;
                    en_year = end_date.getFullYear();
                }

                console.log('Title-'+title+', start Date-' + st_year + '-' + st_monthIndex + '-' + st_day + ' , End Date-' + en_year + '-' + en_monthIndex + '-' + en_day);
            }
        });
    </script>
@endsection
