<script src="{{ url('assets/js/vendor.min.js') }}"></script>

<script src="{{ url('assets/libs/jquery-nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ url('assets/libs/switchery/switchery.min.js') }}"></script>
<script src="{{ url('assets/libs/multiselect/jquery.multi-select.js') }}"></script>
<script src="{{ url('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ url('assets/libs/jquery-mockjax/jquery.mockjax.min.js') }}"></script>
<script src="{{ url('assets/libs/autocomplete/jquery.autocomplete.min.js') }}"></script>
<script src="{{ url('assets/libs/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ url('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ url('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

<script src="{{ url('assets/js/app.min.js') }}"></script>

<script src="{{ url('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ url('assets/libs/dropify/dropify.min.js') }}"></script>

<script src="{{ url('assets/libs/toastr/toastr.min.js') }}"></script>
<script src="{{ url('assets/libs/jquery-toast/jquery.toast.min.js') }}"></script>
<script src="{{ url('assets/js/pages/toastr.init.js') }}"></script>

<!-- Init js-->
<script src="{{ url('assets/js/pages/form-fileuploads.init.js') }}"></script>

<script src="{{ url('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ url('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ url('assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>

<script src="{{ url('assets/libs/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ url('assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ url('assets/libs/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ url('assets/libs/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ url('assets/libs/datatables/buttons.print.min.js') }}"></script>
<script src="{{ url('assets/libs/datatables/dataTables.keyTable.min.js') }}"></script>
<script src="{{ url('assets/libs/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ url('assets/libs/rwd-table/rwd-table.min.js') }}"></script>
<script src="{{ url('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ url('assets/libs/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ url('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ url('assets/libs/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
<script src="{{ url('assets/libs/autonumeric/autoNumeric-min.js') }}"></script>
<script src="{{ url('assets/js/pages/form-masks.init.js') }}"></script>

<script src="{{ url('assets/erp/es6-promise.min.js') }}"></script>
<script src="{{ url('assets/erp/jspdf.debug.js') }}"></script>
<script src="{{ url('assets/erp/html2pdf.min.js') }}"></script>

<script src="{{ url('assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

<script src="{{ url('assets/erp/select2.js') }}"></script>


<script src="{{ url('assets/libs/chart-js/Chart.bundle.min.js') }}"></script>
<script src="{{ url('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ url('assets/libs/moment/moment.min.js') }}"></script>
<script src="{{ url('assets/libs/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ url('assets/erp/jquery.validate.js') }}"></script>

<!-- Magnific Popup-->
<script src="{{ url('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

<!-- Gallery Init-->
<script src="{{ url('assets/js/pages/gallery.init.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //dataTable init
    $('#dataTable').DataTable({
        keys: !0,
        language:{
            paginate:{
                previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"
            }
        },drawCallback:function(){
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });

    // many date and time in date table...
    $(".flatpickr-input-date").flatpickr();
    $(".flatpickr-input-time").flatpickr({ enableTime: !0, noCalendar: !0, dateFormat: "H:i" });
</script>

@yield('javascript')
