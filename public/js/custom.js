function loadBuildingDataOnDocumentLoad() {

    $(document).ready(function() {
        var id = $("#object_ids").val();
        var url = '/grabem/public/getBuildingData';

        if(id != '') {
            $.ajax({
                url: url+'/'+id,
                type: 'GET',
                success: function(data)
                {
                    $('#street').val(data.building_street);
                    $('#street_number').val(data.building_street_number);
                    $('#zip_code').val(data.building_zip_code);
                    $('#city').val(data.building_city);
                }
            });
        }
    });
}

function loadBuildingDataOnDropdownSelectionChange() {
    $(document).ready(function() {
        $('#object_ids').change(function() {
            var id = $("#object_ids").val();
            var url = '/grabem/public/getBuildingData';

            if($.inArray('n/a', id) === -1){

                $('#object_ids').css({
                    'border': ''
                });

                $.ajax({
                    url: url+'/'+id,
                    type: 'GET',
                    success: function(data)
                    {
                        $('#street').val(data.building_street);
                        $('#street_number').val(data.building_street_number);
                        $('#zip_code').val(data.building_zip_code);
                        $('#city').val(data.building_city);
                    }
                });
            } else {
                $('#street').val('');
                $('#street_number').val('');
                $('#zip_code').val('');
                $('#city').val('');

                $('#object_ids').css({
                    'border': '1px solid red'
                });
            }
        });
    });
}

function removeBuildingDataOnMainDomicileNo() {
    $(document).ready(function() {
        $('#is_main_domicile_no').click(function() {
            $('#street').val('');
            $('#street_number').val('');
            $('#zip_code').val('');
            $('#city').val('');
        });
    });
}

function loadBuildingDataOnMainDomicileYes() {
    $(document).ready(function() {
        $('#is_main_domicile_yes').click(function() {
            var id = $("#object_ids").val();
            var url = '/grabem/public/getBuildingData';

            $.ajax({
                url: url+'/'+id,
                /*url: 'url('/getRequest')}}',*/
                type: 'GET',
                success: function(data)
                {
                    $('#street').val(data.building_street);
                    $('#street_number').val(data.building_street_number);
                    $('#zip_code').val(data.building_zip_code);
                    $('#city').val(data.building_city);
                }
            });
        });
    });
}

function getCityFromZipCode() {
    $(document).ready(function() {
        var zip_code_input_field = document.getElementById('zip_code');

        /*when the user clicks off of the zip field*/
        $(zip_code_input_field).keyup(function(){
            if($(this).val().length == 4){
                var zip_code_value  = $(this).val();
                var country = 'Switzerland';

                $('#zip_code').css({
                    'border': ''
                });

                /*make a request to the google geocode api*/
                $.ajax({
                   url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+country+zip_code_value+'&key=AIzaSyBjWUnjUDNYBIrUpLQa-ZMyX3_I_-H2wSw',
                    dataType: 'json',
                    success: function(response){

                        /*find the city*/
                        var address_components = response.results[0].address_components;
                        $.each(address_components, function(index, component){
                            var types = component.types;
                            $.each(types, function(index, type){
                                if(type == 'locality') {
                                    city = component.long_name;
                                }
                            });
                        });
                        /*pre-fill the city & check for multiple cities and turn city into a dropdown if necessary*/
                        var cities = response.results[0].postcode_localities;
                        if(cities) {
                            var select = document.createElement('select');
                            select.id = 'city';
                            select.className = 'form-control';
                            select.name = 'city';
                            select.required = 'true';

                            $.each(cities, function(index, locality){
                                var option = document.createElement('option');
                                option.value = locality;
                                option.innerHTML = locality;

                                if(city == locality) {
                                    option.selected = 'selected';
                                }
                                select.appendChild(option);
                            });
                            $('#city_wrap').html(select);

                        } else {
                            var input = document.createElement('input');
                            input.id = 'city';
                            input.type = 'text';
                            input.className = 'form-control';
                            input.name = 'city';
                            input.required = 'true';

                            $('#city_wrap').html(input);
                            $('#city').val(city);
                        }
                    }
                });
            } else {
                $('#city').val('');
                $('#zip_code').css({
                   'border': '1px solid red'
                });
            }
        });
    });
}

function addSortTableOptions(dataTableId) {
    $(document).ready(function(){
        var date = new Date();

        var month = date.getMonth()+1;
        var day = date.getDate();

        var currentDate = date.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
            (day<10 ? '0' : '') + day;

        if(dataTableId = 'buildings_data'){
            $("#buildings_data").DataTable({
                responsive: true,
                oLanguage: { "sSearch": '<i class="fa fa-search" aria-hidden="true"></i>'},
                "order": [[0, "asc"]]
            });
        }
        if(dataTableId = 'objects_data'){
            $("#objects_data").DataTable({
                responsive: true,
                oLanguage: { "sSearch": '<i class="fa fa-search" aria-hidden="true"></i>'},
                "order": [[1, "asc"]]
            });
        }
        if(dataTableId = 'renter_data'){
            $("#renter_data").DataTable({
                responsive: true,
                oLanguage: { "sSearch": '<i class="fa fa-search" aria-hidden="true"></i>'},
                "columnDefs": [ {
                    "targets": '_all',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        /*make cell red if contract end date has been reached*/
                        if((cellData < currentDate) && (cellData > rowData[8])){
                            $(td).css('background-color', 'red');
                        }
                    }
                }],
                "order": [[1, "asc"]]
            });
        }
    });
}

function addPopoverOnIndexView() {
    $(document).ready(function(){
        $('[data-toggle="deletion_popover"]').popover();
    });
}

function addPopoverOnShowView() {
    $(document).ready(function(){
        $('[data-toggle="deletion_popover"]').popover();
    });
}

function deleteRenterAndRelationFromRenterView() {
    $(document).ready(function(){
        $(document).on('click', '#btnDeleteRenterAndRelation', function(){ //Event delegation

            var dataId = $(this).attr('data-id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = '/grabem/public/renter';

            $.ajax({
                beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                url: url+'/'+dataId,
                type: 'DELETE',
                data: {
                    'dataId': dataId,
                    '_token': CSRF_TOKEN,
                    '_method': 'DELETE',
                    'request_from': 'renter_view',
                },
                dataType: 'JSON',
                success: function (url) {
                    window.location.replace('');
                }
            });
        });
    });
}

function deleteRenterAndRelationFromObjectDetailsView(objectId) {
    $(document).ready(function(){
        $(document).on('click', '#btnDeleteRenterAndRelation', function(){ //Event delegation

            var dataId = $(this).attr('data-id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = '/grabem/public/renter';

            $.ajax({
                beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                url: url+'/'+dataId,
                type: 'DELETE',
                data: {
                    'dataId': dataId,
                    'objectId': objectId,
                    '_token': CSRF_TOKEN,
                    '_method': 'DELETE',
                    'request_from': 'object_view',
                },
                dataType: 'JSON',
                success: function (url) {
                    window.location.replace('');
                }
            });
        });
    });
}

function deleteRelationFromObjectDetailsView(objectId) {
    $(document).ready(function(){
        $(document).on('click', '#btnDeleteRelation', function(){ //Event delegation

            var dataId = $(this).attr('data-id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = '/grabem/public/deleteObjectRenterRelation';
            /*var inputData = $('#delete_form').serialize();*/

            $.ajax({
                beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                url: url,
                type: 'POST',
                data: {
                    'dataId': dataId,
                    'objectId': objectId,
                    '_token': CSRF_TOKEN,
                },
                dataType: 'JSON',
                success: function (url) {
                    window.location.replace('');

                }
            });

        });
    });
}

function loadBootstrapModal() {
    $(document).ready(function(){
        $(document).on('click', '#btnOpenModal', function(){
            var dataId = $(this).attr('data-id');
            $("#modalDelete_"+dataId).modal();
        });
    });
}

function loadDatepickerOnInputClick() {
    $(document).ready(function(){
        $("#beginning_of_contract").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#end_of_contract").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
}

function addObjectFieldToCreateRenterView() {
    $(document).ready(function() {
        $('#clickHere').click(function(){
            $('#appendHere').append('<select id="object_id" class="form-control" name="object_id"><option>hi</option></select>');
        });
    });
}

