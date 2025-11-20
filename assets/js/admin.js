document.onkeydown = function(e) {
    if (e.ctrlKey && 
        (e.keyCode === 85 )) {
        return true;
    }
};
function showError(message, delay=6000) {
    Lobibox.notify("error", { 
        size: "mini",
        position: "bottom right",
        rounded: true,
        msg: message,
        sound: true,
        soundPath: base_url+'/assets/js/lobibox-master/sounds/',
        icon: 'fas fa-exclamation-circle',
        delay: delay
    });
}


function showSuccess(message, delay=6000) {
    Lobibox.notify("success", { 
        size: "mini",
        position: "bottom right",
        
        rounded: true,
        msg: message,
        sound: true,
        soundPath: base_url+'/assets/js/lobibox-master/sounds/',
        icon: 'fas fa-check-circle',
        delay: delay
    });
}

function showWarning(message, delay=6000) {
    Lobibox.notify("warning", { 
        size: "mini",
        position: "bottom right",
        rounded: true,
        msg: message,
        sound: true,
        soundPath: base_url+'/assets/js/lobibox-master/sounds/',
        icon: 'fas fa-exclamation-circle',
        delay: delay
    });
}


function showAlertError(message = 'Error.'){
    Lobibox.alert("error", //AVAILABLE TYPES: "error", "info", "success", "warning"
    {
        icons: {
            bootstrap: {
                
                info: 'fas fa-exclamation-circle'
            }
        },
        //icon: 'fas fa-exclamation-circle',
        title:'Notice',
        msg: message,
        closeButton: false,
        draggable: true,
        buttons: {
            ok: {
                'class': 'lobibox-btn lobibox-btn-cancel',
                text: 'Got it',
                closeOnClick: true
            }
        }
    });
}

function showAlertWarning(message = 'Error.'){
    Lobibox.alert("warning", //AVAILABLE TYPES: "error", "info", "success", "warning"
    {
        
        msg: message,
        closeButton: false,
        draggable: true,
        icon: 'fas fa-exclamation-circle',
        buttons: {
            ok: {
                'class': 'lobibox-btn lobibox-btn-default',
                text: 'Got it',
                closeOnClick: true
            }
        }
    });
}

function showAlertInfo(message = 'Error.'){
    Lobibox.alert("info", //AVAILABLE TYPES: "error", "info", "success", "warning"
    {
        
        msg: message,
        closeButton: false,
        draggable: true,
        icon: 'fas fa-exclamation-circle',
        buttons: {
            ok: {
                'class': 'lobibox-btn lobibox-btn-no',
                text: 'Got it',
                closeOnClick: true
            }
        }
    });
}

var base_url = $('#base_url').val();

var today = new Date ();
var date = (today.getMonth ()+1)+'/'+today.getDate ()+'/'+today.getFullYear ()+' '+today.getHours () +':'+ today.getMinutes()+':'+today.getSeconds();
$(document).ready(function () {
    
    
    $("html"). on("contextmenu",function(e){ return true; });

    
    
    $(document).on('click', '.refer-link', function(e){
        
        //get the section name from hash
        var sectionName = window.location.hash.slice(1);

        //then show the section
        if(sectionName){
            $('#' + sectionName ).show();
        }
        
    });
    

    $('#running-inventory-section').hide();
    $('#total-qty-section').hide();

    //DROPDOWN INIT
    $('select.basic_dropdown').select2({
        width: '100%',
        placeholder: 'Select...',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
    
    $('select.basic-dropdown').select2({
        width: '100%',
        placeholder: 'Select...',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    $('select.dynamic_dropdown').select2({
        width: '100%',
        placeholder: 'Select...',
        //dropdownPosition: 'below',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    $('select.dynamic_dropdown_no_order').select2({
        width: '100%',
        placeholder: 'Select...',
        //dropdownPosition: 'below',
        theme: 'bootstrap4'
    });

    $(".dropdown_2").select2({
        dropdownParent: $("#update-customer"),
        width: '100%',
        placeholder: 'Select...',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
    $(".dropdown_3").select2({
        dropdownParent: $("#add-customer"),
        width: '100%',
        placeholder: 'Select...',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
    $(".dropdown_4").select2({
        dropdownParent: $("#add-material"),
        width: '100%',
        placeholder: 'Select...',
        theme: 'bootstrap4',
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
    $("select.update-material-dropdown").select2({
        dropdownParent: $("#update-material"),
        width: '100%',
        placeholder: 'Select...',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
    $(".dropdown_5").select2({
        dropdownParent: $("#add-material-master"),
        width: '100%',
        placeholder: 'Select...',
        //dropdownPosition: 'above',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    $('select.dropdown_6').select2({
        width: '100%',
        dropdownParent: $("#add-material-master"),
        placeholder: 'Select...',
        //dropdownPosition: 'below',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    $("select.update-mm-dropdown-above").select2({
        dropdownParent: $("#update-material-master"),
        width: '100%',
        placeholder: 'Select...',
        //dropdownPosition: 'above',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    $('select.update-mm-dropdown-below').select2({
        width: '100%',
        dropdownParent: $("#update-material-master"),
        placeholder: 'Select...',
        //dropdownPosition: 'below',
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    $(document).on('keydown', 'input', function(e){
        var key = e.keyCode;

        // If the user has pressed enter
        if (key == 13) {
            //alert($('.text-area').val());
            //document.getElementByClass("text-area").value =document.getElementByClass("text-area").value + "\n";
            //$('.text-area').val() = $('.text-area').val() + "\n";
            //alert($('.text-area').val());
            //alert('Hello');
            return false;
        }
        else {
            return true;
        }
    });

    //DATAGRID INIT

    


	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){        
        $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
    });
	
    //USER SCRIPT
	$(document).on('click', '.add-user-btn', function(e){
        
        var formID = '#add-user-form';
        var modalID = '#modal-add-user';
        $(formID)[0].reset();  
        $(modalID).modal({show:true});
        $(formID).find('select').val('').trigger('change');
        $(formID).find('#uType-id').trigger('change');
        
    });

	$(document).on('change.select2', '.key', function(e){
        e.preventDefault();

        var id = $(this).val();
		
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/get-sLoc/',
            data:{id:id},
            method: 'POST',
            success:function(response){
                console.log(response);
             
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    $('.sLoc').empty();
                    $('.sLoc').append(parse_response['info']);
                }else{
                    $('.sLoc').empty();
                    //console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
			
            }
        });
    });
	
    $(document).on('change', '#uType-id', function(e){
        e.preventDefault();
        
        var id = $(this).val();
        moduleAccessGrid.ajax.url(base_url + 'admin/loadModuleAccessTemplateGrid/'+id).load();
        moduleAccessGrid.columns.adjust();
        moduleAccessGrid.ajax.reload();
        
        //alert('hello');
        $.ajax({
            url: base_url + 'admin/get-bcpresetdtl',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    
                    $('#add-user-form').find('.user-bc-id').empty();
                    $('#add-user-form').find('.user-bc-id').append(parse_response['info'].bcID);
                    
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });

        
    });

    $(document).on('change', '#uType2-id', function(e){
        e.preventDefault();
        
        var id = $(this).val();
        
        userModuleAccessGrid.ajax.url(base_url + 'admin/loadModuleAccessTemplateGrid/'+id).load();
        userModuleAccessGrid.columns.adjust();
        userModuleAccessGrid.ajax.reload();
        
        $.ajax({
            url: base_url + 'admin/get-bcpresetdtl',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    
                    $('#update-user').find('.user-bc-id').empty();
                    $('#update-user').find('.user-bc-id').append(parse_response['info'].bcID);
                    
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    
    
    var moduleAccessGrid = $('#tbl-module-access').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        scrollY:        "500px",
        scrollX:        "300px",
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   false,
		ordering: [],
        paging:false,
        searching:true,
        bInfo : true,
        select : true
		
    });
    
    var userModuleAccessGrid = $('.tbl-user-module-access').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        scrollY:        "500px",
        scrollX:        "300px",
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   false,
		ordering: [],
        paging: false,
        searching:true,//false by default
        bInfo : true,
        select : true,
        "ajax": {
            url : base_url+'admin/loadUserModuleAccessGrid',
            type : 'GET'
        }

    });

    $(document).on('click', '.change-access', function(e){
        e.preventDefault();
        $('#chAccessModal').modal({show:true});
        $('#change-access-form').find('.select2').trigger('click');
        
    });
    
    var userStatusID = $('#userStatusID').val();
    var userType = $('#userType').val();
    var userGrid = $('#tbl-user').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 },
            { responsivePriority: 5, targets: -3 },
            { responsivePriority: 6, targets: -4 },
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/userGrid/'+userStatusID+'/'+userType,
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        userGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        userGrid.button( '.buttons-excel' ).trigger();
        //alert('hello');
    });
    
    $(document).on('click', '.edit-user', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        var update_url = base_url + 'admin/update-user/';
        $.ajax({
            url: base_url + 'admin/modal-user/' + id,
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    // console.log(parse_response['info'].userTypeName);
                    $('#update-user').find('#id').val(id);
                    $('#update-user').find('#user-title').val(parse_response['info'].title);
                    $('#update-user').find('#user-fname').val(parse_response['info'].fname);
                    $('#update-user').find('#user-lname').val(parse_response['info'].lname);
                    $('#update-user').find('#user-email').val(parse_response['info'].email);
                    $('#update-user').find('#user-employee-no').val(parse_response['info'].employeeNo);
                    
                    $('#update-user').find('#key-id').empty();
                    $('#update-user').find('#key-id').append(parse_response['info'].keyID); 
                     
                    
                    $('#update-user').find('#sLoc-id').empty();
                    $('#update-user').find('#sLoc-id').append(parse_response['info'].slocID); 
                    
                    $('#update-user').find('#upline-id').empty();
                    $('#update-user').find('#upline-id').append(parse_response['info'].uplineID); 
                    
                    $('#update-user').find('#uType2-id').empty();
                    $('#update-user').find('#uType2-id').append(parse_response['info'].uTypeID);
                    
                    $('#update-user').find('.user-bc-id').empty();
                    $('#update-user').find('.user-bc-id').append(parse_response['info'].bcID);
                    
                    $('#update-user').find('.user-password').removeAttr('required');
                    $('#update-user').find('.user-password').removeAttr('minlength');
                    $('#update-user').find('.user-password-group').hide();

                    console.log(parse_response['info'].userTypeName);
                    if(parse_response['info'].agencyID == ''){
                        $('#update-user').find('#mobile-number').removeAttr('required');
                        $('#update-user').find('.user-gcash-group').hide();

                        $('#update-user').find('#agency-id').removeAttr('required');
                        $('#update-user').find('.user-agency-group').hide();
                        
                    } else {
                        
                        $('#update-user').find('#agency-id').empty();
                        $('#update-user').find('#agency-id').append(parse_response['info'].agencyID);
                        $('#update-user').find('#mobile-number').val(parse_response['info'].mobileNumber);
                    }
                    
                    //preload datagrid
                    $('#modal-edit-user').modal({show:true});
                    $('#modal-edit-user .modal-title').text("Update user "+parse_response['info'].userID+" - "+parse_response['info'].fname);
                    userModuleAccessGrid.ajax.url(base_url + 'admin/loadUserModuleAccessGrid/'+id).load();
					userModuleAccessGrid.columns.adjust();

                    $('#update-user').attr('action', update_url);
                    $('#update-user').find('#user-update-btn').html('Update');
					$('#update-user').find('.select2').trigger('click');
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.duplicate-user', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        var duplicate_url = base_url + 'admin/add-user/';
        $.ajax({
            url: base_url + 'admin/modal-user/' + id,
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    console.log(parse_response['info'].keyID);
                    $('#update-user').find('#id').val(id);
                    $('#update-user').find('#user-fname').val('');
                    $('#update-user').find('#user-lname').val('');
                    $('#update-user').find('#user-email').val('');
                    $('#update-user').find('#user-employee-no').val('');
                    
                    $('#update-user').find('#key-id').empty();
                    $('#update-user').find('#key-id').append(parse_response['info'].keyID); 
                     
                    
                    $('#update-user').find('#sLoc-id').empty();
                    $('#update-user').find('#sLoc-id').append(parse_response['info'].slocID); 
                    
                    $('#update-user').find('#upline-id').empty();
                    $('#update-user').find('#upline-id').append(parse_response['info'].uplineID); 
                    
                    $('#update-user').find('#uType2-id').empty();
                    $('#update-user').find('#uType2-id').append(parse_response['info'].uTypeID);

                    $('#update-user').find('.user-bc-id').empty();
                    $('#update-user').find('.user-bc-id').append(parse_response['info'].bcID);

                    $('#update-user').find('.user-password').attr('required', true);
                    $('#update-user').find('.user-password').attr('minlength', '7');
                    $('#update-user').find('.user-password-group').show();
                    
                    //preload datagrid
                    $('#modal-edit-user').modal({show:true});
                    $('#modal-edit-user .modal-title').text("Duplicate user "+parse_response['info'].userID+" - "+parse_response['info'].fname);
                    userModuleAccessGrid.ajax.url(base_url + 'admin/loadUserModuleAccessGrid/'+id).load();
                    userModuleAccessGrid.columns.adjust();

                    $('#update-user').attr('action', duplicate_url);
                    $('#update-user').find('#user-update-btn').html('Duplicate');
                    
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('click', '.email-switch-off', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        
        $.ajax({
            url: base_url + 'admin/user-email-switch-off/',
            data: {id:id},
            method: 'POST',
            dataType:"json",
            success:function(data){
                if(data.success==true){
                    showSuccess(data.successMsg);
                    userGrid.ajax.reload(null, false);
                }else{
                    showAlertError(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.email-switch-on', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        
        $.ajax({
            url: base_url + 'admin/user-email-switch-on/',
            data: {id:id},
            method: 'POST',
            dataType:"json",
            success:function(data){
                if(data.success==true){
                    showSuccess(data.successMsg);
                    userGrid.ajax.reload(null, false);
                }else{
                    showAlertError(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        $('#activate-user').find('#id').val(id);
        $('#activate-user').find('#val').html(val);
        $('#modal-active-user').modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        $('#deactivate-user').find('#id').val(id);
        $('#deactivate-user').find('#val').html(val);
        $('#modal-deactivate-user').modal({show:true});
    });

    $(document).on('click', '.reset-user', function(e){
        e.preventDefault();

        var user_id = $(this).attr('data-id');
        $('#update-password').find('#id').val(user_id);
        $('#modal-reset-user').modal({show:true});
    });

    $(document).on('submit', '#add-user-form', function(event){
        $('#loader-div').removeClass('loaded');
    });

    $(document).on('submit', '#update-password', function(event){
        $('#loader-div').removeClass('loaded');
    });

    $(document).on('click', '.upload-user-btn', function(e){
        var modalID = '#modal-upload-user';
        var formID = '#upload-user';
        $(modalID).modal({show:true});
        $(formID)[0].reset();
    });

    $(document).on('submit', '#upload-user', function(event){  
        event.preventDefault();
        var modalID = '#modal-upload-user';
        var formID = '#upload-user';
        var url = $(formID).data('url');

        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + url,
            method:'POST',
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            dataType:"json",
            success:function(data)  
            {
                $(formID)[0].reset();  
                $(modalID).modal('hide');
                $(modalID).on('hidden.bs.modal', function () {
                    $(this).removeData('bs.modal');
                });
                userGrid.ajax.reload(null, false);

                $('#modal-import-result').modal({show:true});
                $('#modal-import-result .modal-title').text('Upload Result');
                $(".tbl-import-result > tbody").empty();
                $(".tbl-import-result > tbody").append(data.import_table);
                if(!data.success){
                    showAlertError(data.msg);
                } else {    
                    showSuccess(data.msg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    //END USER SCRIPT



    //USER KEY SCRIPT
    var userKey_userID = $('#user-key-user-id').val();
    var userKeyGrid = $('#tbl-user-key').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 },
            { responsivePriority: 5, targets: -3 },
            { responsivePriority: 6, targets: -4 },
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/userKeyGrid/'+userKey_userID,
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        userKeyGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        userKeyGrid.button( '.buttons-excel' ).trigger();
        //alert('hello');
    });

    $(document).on('click', '.edit-user-key', function(e){
        e.preventDefault();
        var userID = $(this).attr('data-user-id');
        var keyID = $(this).attr('data-key-id');
        var userTypeID = $(this).attr('data-user-type-id');
        var hasFilter = $(this).attr('data-has-filter');
        $('#loader-div').removeClass('loaded');
        var update_url = base_url + 'admin/update-user-key/';
        $.ajax({
            url: base_url + 'admin/modal-user-key',
            data: {userID:userID, keyID:keyID, userTypeID:userTypeID},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    console.log(parse_response['info'].keyID);
                    $('#update-user-key').find('#user-id').val(userID);
                    $('#update-user-key').find('#has-filter').val(hasFilter);
                    //$('#update-user-key').find('#user-type-id').val(userTypeID);

                    $('#update-user-key').find('#key-id').empty();
                    $('#update-user-key').find('#key-id').append(parse_response['info'].keyID);
                    
                    $('#update-user-key').find('#uType2-id').empty();
                    $('#update-user-key').find('#uType2-id').append(parse_response['info'].uTypeID);
                    
                    
                    //preload datagrid
                    $('#modal-edit-user-key').modal({show:true});
                    $('#modal-edit-user-key .modal-title').text("Update user key of "+parse_response['info'].fname+" - "+parse_response['info'].lname+' for '+parse_response['info'].key);
                    userModuleAccessGrid.ajax.url(base_url + 'admin/loadUserModuleAccessGrid/'+userID+'/'+keyID+'/'+userTypeID).load();
					userModuleAccessGrid.columns.adjust();

                    $('#update-user-key').attr('action', update_url);
					$('#update-user-key').find('.select2').trigger('click');
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });


    //END OF USER KEY SCRIPT



    //USER ROLE SCRIPT

    $(document).on('change', '.user-role-copy-for-preset', function(e){
        e.preventDefault();
        
        var id = $(this).val();
        
        userModuleAccessGrid.ajax.url(base_url + 'admin/loadModuleAccessTemplateGrid/'+id).load();
        userModuleAccessGrid.columns.adjust();
        userModuleAccessGrid.ajax.reload();
        
        moduleAccessGrid.ajax.url(base_url + 'admin/loadModuleAccessTemplateGrid/'+id).load();
        moduleAccessGrid.columns.adjust();
        moduleAccessGrid.ajax.reload();

        //alert('hello');
    });

    $(document).on('click', '.add-user-role-btn', function(e){
        
        var formID = '#add-user-role-form';
        var modalID = '#modal-add-user-role';
        $(formID)[0].reset();  
        $(modalID).modal({show:true});
        $(formID).find('select').val('').trigger('change');
        moduleAccessGrid.ajax.url(base_url + 'admin/loadModulesGrid').load();
        moduleAccessGrid.columns.adjust();
    });

    $(document).on('change.select2', '#user-role-fetch-user', function(e){
        e.preventDefault();

        var id = $(this).val();
		
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/get-users/',
            data:{id:id},
            method: 'POST',
            success:function(response){
                console.log(response);
             
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    $('.users-list').empty();
                    $('.users-list').append(parse_response['info']);
                }else{
                    $('.users-list').empty();
                    //console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
			
            }
        });
    });

    $(document).on('change', '#user-role', function(e){
        e.preventDefault();
        
        var id = $(this).val();
        
        
        moduleAccessGrid.ajax.url(base_url + 'admin/loadModulesGrid/'+id).load();
        moduleAccessGrid.columns.adjust();
    });
    

    $(document).on('click', '.module-tbl-label', function(){
    
        var id = $(this).attr('data-id');
        
        if($(this).attr('readonly') == 'readonly'){
            return false;
        }
        
        if($(this).is(":checked"))
        {
            $(".check-"+id).prop('checked', true);
        } else {
            $(".check-"+id).prop('checked', false);
        }
    });

    var userRoleGrid = $('#tbl-user-roles').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/userRoleGrid',
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        userRoleGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        userRoleGrid.button( '.buttons-excel' ).trigger();
        //alert('hello');
    });

    $(document).on('submit', '#add-user-role-form', function(event){  
        event.preventDefault();
        var formID = '#add-user-role-form';
        var modalID = '#modal-add-user-role';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-user-role/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    userRoleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.edit-user-role', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        var update_url = base_url + 'admin/update-user-role/';
        $.ajax({
            url: base_url + 'admin/modal-user-role/',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    console.log(parse_response['info'].keyID);
                    $('#update-user-role').find('#id').val(id);
                    
                    $('#update-user-role').find('#user-role-fetch-user').empty();
                    $('#update-user-role').find('#user-role-fetch-user').append(parse_response['info'].uTypeID);

                    $('#update-user-role').find('.user-role-copy-for-preset').empty();
                    $('#update-user-role').find('.user-role-copy-for-preset').append(parse_response['info'].uTypeID);

                    $('#update-user-role').find('#bc-id-preset').empty();
                    $('#update-user-role').find('#bc-id-preset').append(parse_response['info'].bcID);
                    
                    //preload datagrid
                    $('#modal-edit-user-role').modal({show:true});
                    $('#modal-edit-user-role .modal-title').text("Update user role "+parse_response['info'].presetHdrID);
                    userModuleAccessGrid.ajax.url(base_url + 'admin/loadUserModulePresetGrid/'+id).load();
					userModuleAccessGrid.columns.adjust();
					userModuleAccessGrid.ajax.reload();

                    $('#update-user-role').find('#user-role-fetch-user').trigger('change');

                    $('#update-user-role').attr('action', update_url);
                    $('#update-user-role').find('#user-role-update-btn').html('Update');
                    $('#update-user-role').find('.select2').trigger('click');
					
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#update-user-role', function(event){  
        event.preventDefault();
        var formID = '#update-user-role';
        var modalID = '#modal-edit-user-role';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-user-role/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    userRoleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var formID = '#activate-user-role';
        var modalID = '#modal-activate-user-role';
        
        $(formID).find('#id').val(id);  
        $(modalID).modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var formID = '#deactivate-user-role';
        var modalID = '#modal-deactivate-user-role';

        $(formID).find('#id').val(id);  
        $(modalID).modal({show:true});
    });

    $(document).on('submit', '#deactivate-user-role', function(event){  
        event.preventDefault();
        var formID = '#deactivate-user-role';
        var modalID = '#modal-deactivate-user-role';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-user-role/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    userRoleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-user-role', function(event){  
        event.preventDefault();
        var formID = '#activate-user-role';
        var modalID = '#modal-activate-user-role';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-user-role/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    userRoleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    //END OF USER ROLE SCRIPT




    // ROLE SCRIPT

    $(document).on('click', '.add-role-btn', function(e){
        
        var formID = '#add-role-form';
        var modalID = '#modal-add-role';
        $(formID)[0].reset();  
        $(modalID).modal({show:true});
        
    });

    var roleGrid = $('#tbl-roles').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/roleGrid',
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        roleGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        roleGrid.button( '.buttons-excel' ).trigger();
        
    });

    $(document).on('submit', '#add-role-form', function(event){  
        event.preventDefault();
        var formID = '#add-role-form';
        var modalID = '#modal-add-role';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-role/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    roleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.edit-role', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        
        $.ajax({
            url: base_url + 'admin/modal-role/',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-role').find('#id').val(id);
                    
                    $('#update-role').find('#user-type-name').val(parse_response['info'].userTypeName);
                    $('#update-role').find('#user-type-level').val(parse_response['info'].userTypeLevel);
                    
                    $('#modal-edit-role').modal({show:true});
                    $('#modal-edit-role .modal-title').text("Update role "+parse_response['info'].userTypeName);
                    $('#update-role').find('#role-update-btn').html('Update');
					
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#update-role', function(event){  
        event.preventDefault();
        var formID = '#update-role';
        var modalID = '#modal-edit-role';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-role/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    roleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var formID = '#activate-role';
        var modalID = '#modal-activate-role';
        
        $(formID).find('#id').val(id);  
        $(modalID).modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var formID = '#deactivate-role';
        var modalID = '#modal-deactivate-role';

        $(formID).find('#id').val(id);  
        $(modalID).modal({show:true});
    });

    $(document).on('submit', '#deactivate-role', function(event){  
        event.preventDefault();
        var formID = '#deactivate-role';
        var modalID = '#modal-deactivate-role';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-role/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    roleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-role', function(event){  
        event.preventDefault();
        var formID = '#activate-role';
        var modalID = '#modal-activate-role';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-role/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    roleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    //END OF ROLE SCRIPT





    //USER SLOC SCRIPT
    

    $(document).on('click', '.add-user-sloc-btn', function(e){
        
        var formID = '#add-user-sloc-form';
        var modalID = '#modal-add-user-sloc';
        $(formID)[0].reset();  
        $(modalID).modal({show:true});
        $(formID).find('select').val('').trigger('change');
        //$('.users-role-for-key').val('');
        //$('.users-role-for-key').trigger('change');
        //$('.key').val('');
        //$('.key').trigger('change');

    });

    var userSlocGrid = $('#tbl-user-sloc').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/userSlocGrid',
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        userSlocGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        userSlocGrid.button( '.buttons-excel' ).trigger();
        
    });

    $(document).on('submit', '#add-user-sloc-form', function(event){  
        event.preventDefault();
        var formID = '#add-user-sloc-form';
        var modalID = '#modal-add-user-sloc';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-user-sloc/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    userSlocGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var formID = '#activate-user-sloc';
        var modalID = '#modal-activate-user-sloc';
        
        $(formID).find('#id').val(id);  
        $(modalID).modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var formID = '#deactivate-user-sloc';
        var modalID = '#modal-deactivate-user-sloc';

        $(formID).find('#id').val(id);  
        $(modalID).modal({show:true});
    });

    $(document).on('submit', '#deactivate-user-sloc', function(event){  
        event.preventDefault();
        var formID = '#deactivate-user-sloc';
        var modalID = '#modal-deactivate-user-sloc';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-user-sloc/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    userSlocGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-user-sloc', function(event){  
        event.preventDefault();
        var formID = '#activate-user-sloc';
        var modalID = '#modal-activate-user-sloc';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-user-sloc/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    userSlocGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    //END OF USER SLOC SCRIPT



    // SYSTEM MODULES SCRIPT

    $(document).on('click', '.add-sys-module-btn', function(e){
        
        var formID = '#add-sys-module-form';
        var modalID = '#modal-add-sys-module';
        $(formID)[0].reset();  
        $(modalID).modal({show:true});
        
    });

    var sysModuleGrid = $('#tbl-sys-modules').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/sysModuleGrid',
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        sysModuleGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        sysModuleGrid.button( '.buttons-excel' ).trigger();
        
    });

    $(document).on('submit', '#add-sys-module-form', function(event){  
        event.preventDefault();
        var formID = '#add-sys-module-form';
        var modalID = '#modal-add-sys-module';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-sys-module/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    sysModuleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.edit-sys-module', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        
        $.ajax({
            url: base_url + 'admin/modal-sys-module/',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-sys-module').find('#id').val(id);
                    
                    $('#update-sys-module').find('#module-desc').val(parse_response['info'].moduleDesc);
                    $('#update-sys-module').find('#alias').val(parse_response['info'].alias);
                    $('#update-sys-module').find('#link').val(parse_response['info'].link);
                    $('#update-sys-module').find('#link-name').val(parse_response['info'].linkName);
                    
                    $('#modal-edit-sys-module').modal({show:true});
                    $('#modal-edit-sys-module .modal-title').text("Update system module "+parse_response['info'].moduleDesc);
                    $('#update-sys-module').find('#sys-module-update-btn').html('Update');
					
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#update-sys-module', function(event){  
        event.preventDefault();
        var formID = '#update-sys-module';
        var modalID = '#modal-edit-sys-module';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-sys-module/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    sysModuleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var formID = '#activate-sys-module';
        var modalID = '#modal-activate-sys-module';
        
        $(formID).find('#id').val(id);  
        $(modalID).modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var formID = '#deactivate-sys-module';
        var modalID = '#modal-deactivate-sys-module';

        $(formID).find('#id').val(id);  
        $(modalID).modal({show:true});
    });

    $(document).on('submit', '#deactivate-sys-module', function(event){  
        event.preventDefault();
        var formID = '#deactivate-sys-module';
        var modalID = '#modal-deactivate-sys-module';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-sys-module/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    sysModuleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-sys-module', function(event){  
        event.preventDefault();
        var formID = '#activate-sys-module';
        var modalID = '#modal-activate-sys-module';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-sys-module/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    sysModuleGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    //END OF SYSTEM MODULES SCRIPT






    //LOCATIOS CLICK HERE
    $(document).on('submit', '#add-towngroup', function(event){  
        event.preventDefault();
        var formID = '#add-towngroup';
        var modalID = '#modal-add-towngroup';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-tg/',
            method:'POST',  
            data: $(formID).serialize(), 
            dataType:"json", 
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    towngroupGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.edit-towngroup', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/modal-towngroup/',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-towngroup').find('#id').val(id);
                    $('#update-towngroup').find('#tg-sDesc').val(parse_response['info'].tgSDesc);
                    $('#update-towngroup').find('#tg-lDesc').val(parse_response['info'].tgLDesc);

                    $('#update-towngroup').find('#bc-id').empty();
                    $('#update-towngroup').find('#bc-id').append(parse_response['info'].bc);

                    $('#modal-edit-towngroup').modal({show:true});
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#update-towngroup', function(event){  
        event.preventDefault();
        var formID = '#update-towngroup';
        var modalID = '#modal-edit-towngroup';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-towngroup/',
            method:'POST',  
            data: $(formID).serialize(), 
            dataType:"json", 
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    towngroupGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#activate-towngroup').find('#id').val(id);
        $('#modal-active-towngroup').modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#deactivate-towngroup').find('#id').val(id);
        $('#modal-deactivate-towngroup').modal({show:true});
    });

    $(document).on('submit', '#deactivate-towngroup', function(event){  
        event.preventDefault();
        var formID = '#deactivate-towngroup';
        var modalID = '#modal-deactivate-towngroup';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-towngroup/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    towngroupGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-towngroup', function(event){  
        event.preventDefault();
        var formID = '#activate-towngroup';
        var modalID = '#modal-active-towngroup';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-towngroup/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    towngroupGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#add-area', function(event){  
        event.preventDefault();
        var formID = '#add-area';
        var modalID = '#modal-add-area';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-area/',
            method:'POST',  
            data: $(formID).serialize(), 
            dataType:"json", 
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    areaGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.edit-area', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var bcID = $(this).attr('data-bc-id');
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/modal-area/',
            data: {id:id, bcID:bcID},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-area').find('#id').val(id);
                    $('#update-area').find('#bc-id').val(bcID);
                    $('#update-area').find('#area-sDesc').val(parse_response['info'].areaSDesc);
                    $('#update-area').find('#area-lDesc').val(parse_response['info'].areaLDesc);

                    $('#update-area').find('#tg-id').empty();
                    $('#update-area').find('#tg-id').append(parse_response['info'].tg);

                    $('#modal-edit-area').modal({show:true});
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#update-area', function(event){  
        event.preventDefault();
        var formID = '#update-area';
        var modalID = '#modal-edit-area';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-area/',
            method:'POST',  
            data: $(formID).serialize(), 
            dataType:"json", 
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    areaGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#activate-area').find('#id').val(id);
        $('#modal-active-area').modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#deactivate-area').find('#id').val(id);
        $('#modal-deactivate-area').modal({show:true});
    });

    $(document).on('submit', '#deactivate-area', function(event){  
        event.preventDefault();
        var formID = '#deactivate-area';
        var modalID = '#modal-deactivate-area';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-area/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    areaGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-area', function(event){  
        event.preventDefault();
        var formID = '#activate-area';
        var modalID = '#modal-active-area';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-area/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    areaGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#add-custmatprice', function(event){  
        event.preventDefault();
        var formID = '#add-custmatprice';
        var modalID = '#modal-add-custmatprice';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-custmatprice/',
            method:'POST',  
            data: $(formID).serialize(), 
            dataType:"json", 
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    customerMaterialGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.edit-custmatprice', function(e){
        e.preventDefault();
        var id = $(this).attr('data-primary-id');
        var mat_id = $(this).attr('data-mat-id');
        var cust_id = $(this).attr('data-cust-id');
        var bc_id = $(this).attr('data-bc-id');
        var tg_id = $(this).attr('data-tg-id');
        
        if(id != null){
            var postData = {id:id};
            $('#update-custmatprice').find('#id').val(id);
            $('#update-custmatprice').find('.town-display').hide();
        } else if(mat_id != null && cust_id != null){
            var postData = {cust_id:cust_id, mat_id:mat_id};
            $('#update-custmatprice').find('#cust-id').val(cust_id);
            $('#update-custmatprice').find('#mat-id').val(mat_id);
            $('#update-custmatprice').find('.bc-display').hide();
            $('#update-custmatprice').find('.town-display').hide();
            $('#update-custmatprice').find('.town-area-display').hide();
        } else if(mat_id != null && bc_id != null){
            var postData = {mat_id:mat_id,bc_id:bc_id};
            $('#update-custmatprice').find('#mat-id').val(mat_id);
            $('#update-custmatprice').find('#bc-id').val(bc_id);
            $('#update-custmatprice').find('.customer-display').hide();
            $('#update-custmatprice').find('.town-display').hide();
            $('#update-custmatprice').find('.town-area-display').hide();
        } else if(mat_id != null && tg_id != null){
            var postData = {mat_id:mat_id,tg_id:tg_id};
            $('#update-custmatprice').find('#mat-id').val(mat_id);
            $('#update-custmatprice').find('#bc-id').val(bc_id);
            $('#update-custmatprice').find('.customer-display').hide();
            $('#update-custmatprice').find('.town-area-display').hide();
        } else if(mat_id != null){
            var postData = {mat_id:mat_id};
            $('#update-custmatprice').find('#mat-id').val(mat_id);
            $('#update-custmatprice').find('.customer-display').hide();
            $('#update-custmatprice').find('.bc-display').hide();
            $('#update-custmatprice').find('.town-display').hide();
            $('#update-custmatprice').find('.town-area-display').hide();
        } else {
            var postData = {};
        }

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/modal-custmatprice/',
            data: postData,
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-custmatprice').find('#cust-name').val(parse_response['info'].custFullName);
                    $('#update-custmatprice').find('#mat-name').val(parse_response['info'].matDesc);
                    $('#update-custmatprice').find('#bc-name').val(parse_response['info'].bcName);
                    $('#update-custmatprice').find('#town-name').val(parse_response['info'].towngroup);
                    $('#update-custmatprice').find('#town-area-name').val(parse_response['info'].area);

                    $('#update-custmatprice').find('#price1').val(parse_response['info'].price1);
                    $('#update-custmatprice').find('#price2').val(parse_response['info'].price2);
                    $('#update-custmatprice').find('#price3').val(parse_response['info'].price3);
                    $('#update-custmatprice').find('#eqpk').val(parse_response['info'].eqpk);

                    $('#update-custmatprice').find('#suom').empty();
                    $('#update-custmatprice').find('#suom').append(parse_response['info'].suom);

                    $('#modal-edit-custmatprice').modal({show:true});
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#update-custmatprice', function(event){  
        event.preventDefault();
        var formID = '#update-custmatprice';
        var modalID = '#modal-edit-custmatprice';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-custmatprice/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    customerMaterialGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        
        var id = $(this).attr('data-primary-id');
        var mat_id = $(this).attr('data-mat-id');
        var cust_id = $(this).attr('data-cust-id');
        var bc_id = $(this).attr('data-bc-id');
        var tg_id = $(this).attr('data-tg-id');
        
        if(id != null){
            $('#activate-custmatprice').find('#id').val(id);
        } else if(mat_id != null && cust_id != null){
            $('#activate-custmatprice').find('#cust-id').val(cust_id);
            $('#activate-custmatprice').find('#mat-id').val(mat_id);
        } else if(mat_id != null && bc_id != null){
            $('#activate-custmatprice').find('#mat-id').val(mat_id);
            $('#activate-custmatprice').find('#bc-id').val(bc_id);
        } else if(mat_id != null && tg_id != null){
            $('#activate-custmatprice').find('#mat-id').val(mat_id);
            $('#activate-custmatprice').find('#bc-id').val(bc_id);
        } else if(mat_id != null){
            $('#activate-custmatprice').find('#mat-id').val(mat_id);
        } else {
        }

        $('#modal-active-custmatprice').modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        
        var id = $(this).attr('data-primary-id');
        var mat_id = $(this).attr('data-mat-id');
        var cust_id = $(this).attr('data-cust-id');
        var bc_id = $(this).attr('data-bc-id');
        var tg_id = $(this).attr('data-tg-id');
        
        if(id != null){
            $('#deactivate-custmatprice').find('#id').val(id);
        } else if(mat_id != null && cust_id != null){
            $('#deactivate-custmatprice').find('#cust-id').val(cust_id);
            $('#deactivate-custmatprice').find('#mat-id').val(mat_id);
        } else if(mat_id != null && bc_id != null){
            $('#deactivate-custmatprice').find('#mat-id').val(mat_id);
            $('#deactivate-custmatprice').find('#bc-id').val(bc_id);
        } else if(mat_id != null && tg_id != null){
            $('#deactivate-custmatprice').find('#mat-id').val(mat_id);
            $('#deactivate-custmatprice').find('#bc-id').val(bc_id);
        } else if(mat_id != null){
            $('#deactivate-custmatprice').find('#mat-id').val(mat_id);
        } else {
        }

        $('#modal-deactivate-custmatprice').modal({show:true});
    });

    $(document).on('submit', '#deactivate-custmatprice', function(event){  
        event.preventDefault();
        var formID = '#deactivate-custmatprice';
        var modalID = '#modal-deactivate-custmatprice';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-custmatprice/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    customerMaterialGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-custmatprice', function(event){  
        event.preventDefault();
        var formID = '#activate-custmatprice';
        var modalID = '#modal-active-custmatprice';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-custmatprice/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    customerMaterialGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });


    //STORAGE LOCATION | NOTIF SCRIPT

    $(document).on('click', '.add-sloc', function(e){
        

        var formID = '#add-sLoc';
        var modalID = '#modal-add-sLoc';
        $(modalID).modal({show:true});
        $(formID)[0].reset();

        $(formID).find('select').val('').trigger('change');
    });

    var slocIDVal = $('#sloc-id-val-for-notif').val();
    var sLocGrid = $('#tbl-sLoc').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        //"responsive": true,
        "processing": true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 },
            { responsivePriority: 5, targets: 2 },
            { responsivePriority: 6, targets: -3 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/sLocGrid/'+slocIDVal,
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    var param1 = $('#param1').val();
    var param2 = $('#param2').val();
    var param3 = $('#param3').val();
    var param4 = $('#param4').val();
    var notifGrid = $('.tbl-view-notif').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "processing": true,
        'responsive': false,
        "columnDefs": [
            {
                targets : [ 0 ],
                visible : false,
                searchable : false
            }         
        ],
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        //scrollCollapse: true,
        "ajax": {
            url : base_url + 'admin/notifGrid/'+param1+'/'+param2+'/'+param3+'/'+param4,
            type : 'GET'
        },
        //scrollX: true,
        paging:         true,
        fixedColumns:   false,
        order: [],
        searching:true,
        bInfo : true,
        select : true,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:nth-child(2) c[r^="A"]', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
        
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        notifGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.dl-dt', function(e){
        
        notifGrid.button( '.buttons-excel' ).trigger();
        
    });


    var historyGrid = $('.tbl-view-history-cg').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "processing": true,
        "columnDefs": [
            {
                targets : [ 0 ],
                visible : false,
                searchable : false
            },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: -1 }            
        ],
        //scrollCollapse: true,
        select : true,
        paging:         true,
        fixedColumns:   false,
        ordering: false,
        searching:true,
        bInfo : true
        
    });

    

    $('#clear-history-btn').show();
    $('.clear-dt-history').click(function () {
        $('#loader-div').removeClass('loaded');
        var ids = $.map(notifGrid.rows('.selected').data(), function (item) {
            return item[0] //NOTIF ID
        });
        if(notifGrid.rows('.selected').data().length > 0){
            var statusID = 15;
            var trigger = 'clear';
            $.ajax({
                url: base_url + 'admin/update_usernotif',
                method:'POST',
                data: {statusID : statusID, trigger:trigger, notifID:ids},
                dataType:"json",
                success:function(data)  
                {
                    if(data.success){
                        
                        $('#announcement-notif').empty();
                        $('#announcement-notif').append(data.item);

                        notifGrid.ajax.reload(null, false);
                        showSuccess(notifGrid.rows('.selected').data().length + ' row(s) cleared');
                    }
                },
                error:function(xhr, textStatus, errorThrown){
                    showError('Error in Saving!');
                    console.log(xhr.responseText);
                    
                }
            });
        } else {
            showWarning(notifGrid.rows('.selected').data().length + ' row(s) cleared');
        }
        $('#loader-div').addClass('loaded');
    });

    $(document).on('click', '.notif-item', function(e){

        $('#clear-history-btn').show();
        var id = 0;
        var notifID = $(this).attr('data-id');
        var notifTypeID = $(this).attr('data-typeid')
        var slocName = $(this).attr('data-name');
        var transTypeID = $(this).attr('data-transtype');
        var refID = $(this).attr('data-ref-id');
        $('#loader-div').removeClass('loaded');
        $('#modal-view-notif').modal({show:true});
        //alert(notifID);
        //alert(notifTypeID);
        if(notifID && slocName){
            //$('#modal-view-notif .modal-title').text("Notif details of "+slocName);
            //window.location.replace(base_url + 'admin/notifications/'+id+'/'+notifTypeID+'/'+notifID+'/15');
            //notifGrid.ajax.url(base_url + 'admin/notifGrid/'+id+'/'+notifTypeID+'/'+notifID+'/15').load();
            if(notifTypeID == 2){
                window.location.replace(base_url + 'transactional/emp-monitoring-pending/'+refID);
            } else if (notifTypeID == 1){
                window.location.replace(base_url + 'admin/storloc/'+refID);
            } else if (notifTypeID == 3){
                window.location.replace(base_url + 'transactional/cg-performance/'+transTypeID+'/'+refID);
            }

        } else {
            //$('#modal-view-notif .modal-title').text("All Notif details");
            window.location.replace(base_url + 'admin/notifications/0/0/0/15');
            //notifGrid.ajax.url(base_url + 'admin/notifGrid/0/0/0/15').load();
        }
        notifGrid.columns.adjust();
        $(document).on('click', '.refresh-dt', function(e){
            notifGrid.ajax.reload(null, false);
        });

        var statusID = 14;
        var trigger = 'read';
        $.ajax({
            url: base_url + 'admin/update_usernotif',
            method:'POST',
            data: {statusID : statusID, trigger:trigger, notifID:notifID},
            dataType:"json",
            success:function(data)  
            {
                if(data.success){
                    
                    $('#announcement-notif').empty();
                    $('#announcement-notif').append(data.item);
                }
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                
            }
        });

        $('#loader-div').addClass('loaded');
    });
                    

    $(document).on('click', '.refresh-dt', function(e){
        
        sLocGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        sLocGrid.button( '.buttons-excel' ).trigger();
    });

    $(document).on('click', '.upload-sloc-btn', function(e){
        var modalID = '#modal-upload-sLoc';
        var formID = '#upload-sLoc';
        $(modalID).modal({show:true});
        $(formID)[0].reset();
    });

    $(document).on('click', '.add-substat', function(e){
        var formID = '#add-substat';
        var modalID = '#modal-add-substat';
        $(modalID).modal({show:true});
        $(formID)[0].reset();
    });

    $(document).on('submit', '#add-substat', function(event){  
        event.preventDefault();

        var formID = '#add-substat';
        var modalID = '#modal-add-substat';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-substat/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    if($('.dynamic-substatus').val() !== undefined){
                        var option = new Option(data.subStatDesc, data.subStatusID);
                        $('.dynamic-substatus').append($(option));
                        $(".dynamic-substatus").val(data.subStatusID);
                        $('.dynamic_dropdown').trigger('change');
                    }
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#upload-sLoc', function(event){  
        event.preventDefault();
        var formID = '#add-sLoc';
        var modalID = '#modal-add-sLoc';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/upload-sloc/',
            method:'POST',
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            dataType:"json",
            success:function(data)  
            {
                $(formID)[0].reset();  
                $(modalID).modal('hide');
                $(modalID).on('hidden.bs.modal', function () {
                    $(this).removeData('bs.modal');
                });
                sLocGrid.ajax.reload(null, false);

                $('#modal-import-result').modal({show:true});
                $('#modal-import-result .modal-title').text('Upload Result');
                $(".tbl-import-result > tbody").empty();
                $(".tbl-import-result > tbody").append(data.importTable);
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#add-sLoc', function(event){  
        event.preventDefault();
        var formID = '#add-sLoc';
        var modalID = '#modal-add-sLoc';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-sLoc/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    sLocGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
 
    $(document).on('click', '.edit-sLoc', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/modal-sLoc/',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-sLoc').find('#id').val(id);
                    
                    $('#update-sLoc').find('#sLoc-code').val(parse_response['info'].slocCode);
                    $('#update-sLoc').find('#mobbilenumberslabel').html(parse_response['info'].mobileNumber);

                    
                    $('#update-sLoc').find('#sLoc-name').val(parse_response['info'].slocName);
                    
                    $('#update-sLoc').find('#sLoc-addr').val(parse_response['info'].slocAddr);
                    
                    $('#update-sLoc').find('#bc-id').empty();
                    $('#update-sLoc').find('#bc-id').append(parse_response['info'].bcID);

                    $('#update-sLoc').find('#sLocType-id').empty();
                    $('#update-sLoc').find('#sLocType-id').append(parse_response['info'].slocTypeID);
                    $('#update-sLoc').find('#litterMaterialID').empty();
                    $('#update-sLoc').find('#litterMaterialID').append(parse_response['info'].litterMaterialID);

                    $('#update-sLoc').find('#heatSourceID').empty();
                    $('#update-sLoc').find('#heatSourceID').append(parse_response['info'].heatSourceID);

                    $('#update-sLoc').find('#farmTypeID').empty();
                    $('#update-sLoc').find('#farmTypeID').append(parse_response['info'].farmTypeID);

                    $('#update-sLoc').find('#provinceID').empty();
                    $('#update-sLoc').find('#provinceID').append(parse_response['info'].provinceID);

                    $('#update-sLoc').find('#vetID').empty();
                    $('#update-sLoc').find('#vetID').append(parse_response['info'].vetID);

                    $('#update-sLoc').find('#firstName').val(parse_response['info'].firstName);
                    $('#update-sLoc').find('#surName').val(parse_response['info'].surName);                    
                    $('#update-sLoc').find('#farmName').val(parse_response['info'].farmName);                    
                    $('#update-sLoc').find('#farm').val(parse_response['info'].farm);                    
                    $('#update-sLoc').find('#dateStarted').val(parse_response['info'].dateStarted);
                    $("#dateStartedParent").datepicker("update", new Date(parse_response['info'].dateStarted));

                    $('#update-sLoc').find('#capacity').val(parse_response['info'].capacity);                    
                    $('#update-sLoc').find('#noOfHouse').val(parse_response['info'].noOfHouse);                    
                    $('#update-sLoc').find('#farmCoordinates').val(parse_response['info'].farmCoordinates);
                    $('#update-sLoc').find('#homeAddress').val(parse_response['info'].homeAddress);
                    $('#update-sLoc').find('#cpNo').val(parse_response['info'].cpNo);
                    $('#update-sLoc').find('#email').val(parse_response['info'].email);

                    $('#update-sLoc').find('.select2').trigger('click');

                    $('#modal-edit-sLoc').modal({show:true});
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.mobile-redirect', function(e){
        e.preventDefault();
        if($(this).attr('data-id')){
            var id = $(this).attr('data-id');
        } else {
            var id = $('#update-sLoc').find('#id').val();
        }
        $('#loader-div').removeClass('loaded');
        var url = base_url + 'admin/mobile/'+id;
        printWindow = window.open( url ,"_self");
        
        $('#loader-div').addClass('loaded');
    });

    $(document).on('click', '.history-sLoc', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var notifTypeID = 1; //sloc
        var slocName = $(this).attr('data-name');
        $('#loader-div').removeClass('loaded');
        $('#modal-view-history-cg').modal({show:true});
        $('#modal-view-history-cg .modal-title').text("Logs of "+slocName);

        historyGrid.ajax.url(base_url + 'admin/historyGrid/'+id+'/'+notifTypeID+'/0/16').load();
        historyGrid.columns.adjust();
        $(document).on('click', '.refresh-dt', function(e){
            historyGrid.ajax.reload(null, false);
        });
        $('#loader-div').addClass('loaded');
    });

    
    
    $(document).on('submit', '#update-sLoc', function(event){  
        event.preventDefault();
        var formID = '#update-sLoc';
        var modalID = '#modal-edit-sLoc';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-sLoc/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    sLocGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        var subStatDesc = $(this).attr('data-substat');
        
        $('#activate-sLoc').find('#id').val(id);
        $('#activate-sLoc').find('#val').html(val);
        $('#activate-sLoc').find('#substat-val').html(subStatDesc);
        $('#modal-active-sLoc').modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        
        
        $('#deactivate-sLoc').find('#id').val(id);
        $('#deactivate-sLoc').find('#val').html(val);

        $('#modal-deactivate-sLoc').modal({show:true});
    });

    $(document).on('submit', '#deactivate-sLoc', function(event){  
        event.preventDefault();
        var formID = '#deactivate-sLoc';
        var modalID = '#modal-deactivate-sLoc';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-sLoc/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    sLocGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-sLoc', function(event){  
        event.preventDefault();
        var formID = '#activate-sLoc';
        var modalID = '#modal-active-sLoc';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-sLoc/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    sLocGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    // END OF STORAGE LOCATION | NOTIF SCRIPT


    //DASHBOARD SCRIPT
    


    //LOGS SCRIPT

    var logsGrid = $('#tbl-sys-logs').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        //"responsive": true,
        "processing": true,
        "serverSide": true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 },
            { responsivePriority: 5, targets: 2 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/sysLogsGrid',
            type : 'POST'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:nth-child(2) c[r^="A"]', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    

    $(document).on('click', '.refresh-dt', function(e){
        
        logsGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        logsGrid.button( '.buttons-excel' ).trigger();
        
    });


    var userFeedbackGrid = $('#tbl-user-feedback').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "processing": true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        scrollCollapse: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/userFeedbackGrid',
            type : 'POST'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:nth-child(2) c[r^="A"]', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
        
    });

    $(document).on('click', '.refresh-dt', function(e){
        userFeedbackGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.dl-dt', function(e){
        
        userFeedbackGrid.button( '.buttons-excel' ).trigger();
        
    });
    

    var activityGrid = $('.tbl-view-activity-log').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "processing": true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        scrollCollapse: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/activityGrid',
            type : 'POST'
        }
        
    });

    $(document).on('click', '.refresh-dt', function(e){
        activityGrid.ajax.reload(null, false);
    });

    $(document).on('click', '#activityLogBtn', function(e){
        
        $('#modal-view-activity-log').modal({show:true});
        
    });

    $(document).on('submit', '#uploadPhotoForm', function(event){  
        event.preventDefault();
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url:base_url+'login/update_profile_pic',
            method:'POST',
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            dataType:"json",
            success:function(data)  
            {  
                if(data.success){
                    
                    //alert(data);
                    $('#uploadPhotoForm')[0].reset();  
                    $('#uploadPhotoModal').modal('hide');
                    $('#uploadPhotoModal').on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    url = base_url+'admin';
                    window.location.reload(true);
                    //$('#profileModal').modal('show');
                    
                } else {
                    showAlertError(data.successMsg);
                }

                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                $eui.messager.alert('Error', 'Error in Saving Transaction!');
                console.log(xhr.responseText);

                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('click', '.background-color-switch', function(e){
        var backgroundColor = $(this).attr('data-color');
        
        var postData = { backgroundColor:backgroundColor };
        $.ajax({
            url: base_url + 'admin/put-user-theme-background/',
            method:'POST',
            data: postData, 
            dataType:"json",
            success:function(data)  
            {
                if(data.success){
                    location.reload(true);
                    //showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
        
    });

    $(document).on('click', '.sidebar-color-switch', function(e){
        var sideBarColor = $(this).attr('data-color');
        
        var postData = { sideBarColor:sideBarColor };
        $.ajax({
            url: base_url + 'admin/put-user-theme-sidebar/',
            method:'POST',
            data: postData, 
            dataType:"json",
            success:function(data)  
            {
                if(data.success){
                    //showSuccess(data.successMsg);
                    location.reload(true);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
        
    });

    $(document).on('click', '.topbar-color-switch', function(e){
        var topBarColor = $(this).attr('data-color');
        
        var postData = { topBarColor:topBarColor };
        $.ajax({
            url: base_url + 'admin/put-user-theme-topbar/',
            method:'POST',
            data: postData, 
            dataType:"json",
            success:function(data)  
            {
                if(data.success){
                    //showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
        
    });

    $(document).on('click', '.logo-header-color-switch', function(e){
        var logoHeaderColor = $(this).attr('data-color');
        
        var postData = { logoHeaderColor:logoHeaderColor };
        $.ajax({
            url: base_url + 'admin/put-user-theme-logo-header/',
            method:'POST',
            data: postData, 
            dataType:"json",
            success:function(data)  
            {
                if(data.success){
                    //showSuccess(data.successMsg);
                    location.reload(true);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
        
    });

    $('.changeBtnColor').on('click', function(){
        //alert('hello');
        var btnColor = $(this).attr('data-color');
        
        var postData = { btnColor:btnColor };
        $.ajax({
            url: base_url + 'admin/put-user-theme-btn/',
            method:'POST',
            data: postData, 
            dataType:"json",
            success:function(data)  
            {
                if(data.success){
                    //showSuccess(data.successMsg);
                    location.reload(true);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
        
    });



    $(document).on('click', '.select2', function(e){
        //you can uncomment below codes to see its structure 
        //console.log($('.select2-container').html()) 
        //below change the background color for the input 
        $('#'+$('span[aria-owns]', this).attr('aria-owns')) 
        .parent() 
        .siblings('.select2-search') 
        .find('input') 
        .css('background-color', '#ffffcc') 
        //below change the font color for the selected option 
        //$('#'+$('span[aria-owns]', this).attr('aria-owns')) 
        //.find('li[aria-selected=true]') 
        //.css('color', 'yellow') 
        //below change the font color for <select> 
        $('>span>span>span', this).css('color', 'black') 
        //below change the background color for the arrow of <select> 
        $('>span .select2-selection__arrow', this).css('background-color', 'red') 

        
    });

    //END OF LOGS SCRIPT


    //BUSINESS CENTER SCRIPT
    $(document).on('click', '.add-bc', function(e){
        

        var formID = '#add-bc';
        var modalID = '#modal-add-bc';
        $(modalID).modal({show:true});
        $(formID)[0].reset();

        $(formID).find('select').val('').trigger('change');
    });

    var centerTypeID = $('#centerTypeID').val();
    var bcGrid = $('#tbl-bc').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        //"responsive": true,
        "processing": true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 },
            { responsivePriority: 5, targets: 2 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/bcGrid/'+centerTypeID,
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        bcGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        bcGrid.button( '.buttons-excel' ).trigger();
        //alert('hello');
    });
    
    $(document).on('submit', '#add-bc', function(event){  
        event.preventDefault();
        var formID = '#add-bc';
        var modalID = '#modal-add-bc';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-bc/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    if($('.dynamic-bc').val() !== undefined){
                        var option = new Option(data.bcName, data.bcID);
                        $('.dynamic-bc').append($(option));
                        $(".dynamic-bc").val(data.bcID);
                        $('.dynamic_dropdown').trigger('change');
                        $('.select2').trigger('click');
                    } else {
                        bcGrid.ajax.reload(null, false);
                    }
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('click', '.edit-bc', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/modal-bc/',
            data: {id:id, centerTypeID:centerTypeID},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-bc').find('#id').val(id);
                    
                    $('#update-bc').find('#rg-id').empty();
                    $('#update-bc').find('#rg-id').append(parse_response['info'].rgID);
                    
                    $('#update-bc').find('#center-type-id').empty();
                    $('#update-bc').find('#center-type-id').append(parse_response['info'].centerTypeID);
                    
                    $('#update-bc').find('#bc-code').val(parse_response['info'].bcCode);

                    $('#update-bc').find('#bc-name').val(parse_response['info'].bcName);
                    
                    $('#update-bc').find('#plant-code').val(parse_response['info'].pCode);
                    $('#update-bc').find('.select2').trigger('click');

                    
                    
                    $('#modal-edit-bc').modal({show:true});
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('submit', '#update-bc', function(event){  
        event.preventDefault();
        var formID = '#update-bc';
        var modalID = '#modal-edit-bc';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-bc/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    $('#centerTypeID').val(data.centerTypeID);
                    bcGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        
        $('#activate-bc').find('#id').val(id);
        $('#activate-bc').find('#val').html(val);
        $('#modal-active-bc').modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        
        $('#deactivate-bc').find('#id').val(id);
        $('#deactivate-bc').find('#val').html(val);
        $('#modal-deactivate-bc').modal({show:true});
    });

    $(document).on('submit', '#deactivate-bc', function(event){  
        event.preventDefault();
        var formID = '#deactivate-bc';
        var modalID = '#modal-deactivate-bc';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-bc/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    bcGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-bc', function(event){  
        event.preventDefault();
        var formID = '#activate-bc';
        var modalID = '#modal-active-bc';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-bc/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    bcGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    //END OF BUSINESS CENTER SCRIPT


    //REGION SCRIPT
    $(document).on('click', '.add-region', function(e){
        

        var formID = '#add-region';
        var modalID = '#modal-add-region';
        $(modalID).modal({show:true});
        $(formID)[0].reset();

        $(formID).find('select').val('').trigger('change');
    });

    var regionGrid = $('#tbl-region').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "responsive": true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/regionGrid',
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        regionGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        regionGrid.button( '.buttons-excel' ).trigger();
        //alert('hello');
    });
    
    $(document).on('submit', '#add-region', function(event){  
        event.preventDefault();
        var formID = '#add-region';
        var modalID = '#modal-add-region';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-region/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    regionGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('click', '.edit-region', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/modal-region/',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-region').find('#id').val(id);
                    
                    $('#update-region').find('#region-sDesc').val(parse_response['info'].rgSDesc);

                    $('#update-region').find('#region-lDesc').val(parse_response['info'].rgLDesc);
                    
                    $('#modal-edit-region').modal({show:true});
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('submit', '#update-region', function(event){  
        event.preventDefault();
        var formID = '#update-region';
        var modalID = '#modal-edit-region';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-region/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    regionGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        
        $('#activate-region').find('#id').val(id);
        $('#activate-region').find('#val').html(val);
        $('#modal-active-region').modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var val = $(this).attr('data-val');
        
        $('#deactivate-region').find('#id').val(id);
        $('#deactivate-region').find('#val').html(val);
        $('#modal-deactivate-region').modal({show:true});
    });

    $(document).on('submit', '#deactivate-region', function(event){  
        event.preventDefault();
        var formID = '#deactivate-region';
        var modalID = '#modal-deactivate-region';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-region/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    regionGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-region', function(event){  
        event.preventDefault();
        var formID = '#activate-region';
        var modalID = '#modal-active-region';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-region/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    regionGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    //END OF REGION SCRIPT
    
    
    
    


    //KEY SCRIPT
    $(document).on('click', '.add-key', function(e){
        

        var formID = '#add-key';
        var modalID = '#modal-add-key';
        $(modalID).modal({show:true});
        $(formID)[0].reset();

        $(formID).find('select').val('').trigger('change');
    });

    $(document).on('change', '.users-role-for-key', function(e){
        e.preventDefault();

        var id = $(this).val();
        var keyID = null;
		
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/get-users-array',
            data:{id:id, keyID:keyID},
            method: 'POST',
            success:function(response){
                console.log(response);
             
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    $('.users-list').empty();
                    $('.users-list').append(parse_response['info']);
                }else{
                    $('.users-list').empty();
                    //console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
			
            }
        });
    });

    $(document).on('change', '.users-role-for-key-update', function(e){
        e.preventDefault();

        var id = $(this).val();
        var keyID = $('#update-key').find('#id').val();

        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/get-users-array',
            data:{id:id, keyID:keyID},
            method: 'POST',
            success:function(response){
                console.log(response);
             
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    $('.users-list').empty();
                    $('.users-list').append(parse_response['info']);
                }else{
                    $('.users-list').empty();
                    //console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
			
            }
        });
    });

    var keyGrid = $('#tbl-key').DataTable({
        "pagingType": "full",
        "language": {
            "emptyTable":     "No data available",
            "lengthMenu":     "Show _MENU_ entries",
            "info":           "Displaying _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty":      "Displaying 0 to 0 of 0 entries",
            'search': '<i class="fa fa-search" aria-hidden="true"></i>',
            "paginate": {
                "first":      '<i class="fas fa-fast-backward"></i>',
                "last":       '<i class="fas fa-fast-forward"></i>',
                "next":       '<i class="fas fa-step-forward"></i>',
                "previous":   '<i class="fas fa-step-backward"></i>'
            },
        },
        "responsive": true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: -2 },
            { responsivePriority: 5, targets: 2 }
        ],
        "order": [],
        select : true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "ajax": {
            url : base_url+'admin/keyGrid',
            type : 'GET'
        },
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Run Date : '+date,
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    //$('row:first c', sheet).attr( 's', '42' );
                    //$('row c[r*="3"]', sheet).attr('s', expDtColor);
                },
                autoFilter: true
            }
        ]
    });

    $(document).on('click', '.refresh-dt', function(e){
        
        keyGrid.ajax.reload(null, false);
    });

    $(document).on('click', '.print-dt', function(e){
        
        keyGrid.button( '.buttons-excel' ).trigger();
        //alert('hello');
    });
    
    $(document).on('submit', '#add-key', function(event){  
        event.preventDefault();
        var formID = '#add-key';
        var modalID = '#modal-add-key';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/add-key/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    keyGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('click', '.edit-key', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/modal-key/',
            data: {id:id},
            method: 'POST',
            success:function(response){
                var parse_response = JSON.parse(response);
                
                if(parse_response['result'] == 1){
                    
                    $('#update-key').find('#id').val(id);
                    
                    $('#update-key').find('#bcID').empty();
                    $('#update-key').find('#bcID').append(parse_response['info'].bcID);

                    $('#update-key').find('#keyCode').val(parse_response['info'].keyCode);
                    $('#update-key').find('#keyCode2').val(parse_response['info'].keyCode2);
                    $('#update-key').find('.select2').trigger('click');
                    
                    $('#modal-edit-key').modal({show:true});
                }else{
                    console.log('Error please contact your administrator.');
                }
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('submit', '#update-key', function(event){  
        event.preventDefault();
        var formID = '#update-key';
        var modalID = '#modal-edit-key';
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/update-key/',
            method:'POST',
            data: $(formID).serialize(), 
            dataType:"json",
            success:function(data)
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    $(modalID).on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                    keyGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    
    $(document).on('click', '.toggle-inactive', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var keyID = $(this).attr('data-key-id');
        
        
        $('#activate-key').find('#id').val(id);
        $('#activate-key').find('#keyID').val(keyID);
        $('#modal-active-key').modal({show:true});
    });

    $(document).on('click', '.toggle-active', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var keyID = $(this).attr('data-key-id');

        
        $('#deactivate-key').find('#id').val(id);
        $('#deactivate-key').find('#keyID').val(keyID);
        $('#modal-deactivate-key').modal({show:true});
    });

    $(document).on('submit', '#deactivate-key', function(event){  
        event.preventDefault();
        var formID = '#deactivate-key';
        var modalID = '#modal-deactivate-key';
        
        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/deactivate-key/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    keyGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });

    $(document).on('submit', '#activate-key', function(event){  
        event.preventDefault();
        var formID = '#activate-key';
        var modalID = '#modal-active-key';

        $('#loader-div').removeClass('loaded');
        $.ajax({
            url: base_url + 'admin/activate-key/',
            method:'POST',
            data: $(formID).serialize(),
            dataType:"json",
            success:function(data)  
            {
                if(!data.success){
                    showAlertError(data.successMsg);
                } else {
                    $(formID)[0].reset();  
                    $(modalID).modal('hide');
                    keyGrid.ajax.reload(null, false);
                    showSuccess(data.successMsg);
                }
                $('#loader-div').addClass('loaded');
            },
            error:function(xhr, textStatus, errorThrown){
                showError('Error in Saving!');
                console.log(xhr.responseText);
                $('#loader-div').addClass('loaded');
            }
        });
    });
    //END OF KEY SCRIPT
    

    //HIDING UI
    $("div.add-access").hide();
    $("#additional-access").click(function() {
        if($(this).is(":checked"))
        {
            $("div.add-access").show();
            $("div.update-access").hide();
            
        } else {
            $("div.add-access").hide();
            $("div.update-access").show();
        }
    });
    $("#additional-access-2").click(function() {
        if($(this).is(":checked"))
        {
            $("div.add-access").show();
            $("div.update-access").hide();
        } else {
            $("div.add-access").hide();
            $("div.update-access").show();
        }
    });
    $("#additional-access-3").click(function() {
        if($(this).is(":checked"))
        {
            $("div.add-access").show();
            $("div.update-access").hide();
        } else {
            $("div.add-access").hide();
            $("div.update-access").show();
        }
    });


    //SELECTING ALL
    $('.users-role-for-key').on("select2:select", function (e) { 
        var data = e.params.data.text;
        if(data==' Select All'){

            $(".users-role-for-key > option").prop("selected","selected");
            $(".users-role-for-key").trigger("change");
        }
        $(".users-role-for-key option[value=-1]").prop("selected", false).parent().trigger("change");
    });

    $('.users-role-for-key-update').on("select2:select", function (e) { 
        var data = e.params.data.text;
        if(data==' Select All'){

            $(".users-role-for-key-update > option").prop("selected","selected");
            $(".users-role-for-key-update").trigger("change");
        }
        $(".users-role-for-key-update option[value=-1]").prop("selected", false).parent().trigger("change");
    });

	$('.users-list').on("select2:select", function (e) { 
        var data = e.params.data.text;
        if(data==' Select All'){

            $(".users-list > option").prop("selected","selected");
            $(".users-list").trigger("change");
        }
        $(".users-list option[value=-1]").prop("selected", false).parent().trigger("change");
    });
    $('.key').on("select2:select", function (e) { 
        var data = e.params.data.text;
        if(data==' Select All'){

            $(".key > option").prop("selected","selected");
            $(".key").trigger("change");
        }
        $(".key option[value=-1]").prop("selected", false).parent().trigger("change");
    });
    $('.bc').on("select2:select", function (e) { 
        var data = e.params.data.text;
        if(data==' Select All'){

            $(".bc > option").prop("selected","selected");
            $(".bc").trigger("change");
        }
        $(".bc option[value=-1]").prop("selected", false).parent().trigger("change");
    });
	
	$('.sLoc').on("select2:select", function (e) { 
        var data = e.params.data.text;
        if(data==' Select All'){

            $(".sLoc > option").prop("selected","selected");
            $(".sLoc").trigger("change");
        }
        $(".sLoc option[value=-1]").prop("selected", false).parent().trigger("change");
    });
	
    $('.subgroup').on("select2:select", function (e) { 
        var data = e.params.data.text;
        if(data==' Select All'){

            $(".subgroup > option").prop("selected","selected");
            $(".subgroup").trigger("change");
        }
        $(".subgroup option[value=-1]").prop("selected", false).parent().trigger("change");
    });

    $('.materials').on("select2:select", function (e) { 
        var data = e.params.data.text;
        if(data==' Select All'){

            $(".materials > option").prop("selected","selected");
            $(".materials").trigger("change");
        }
        $(".materials option[value=-1]").prop("selected", false).parent().trigger("change");
    });

    //NUMERIC INPUTS
    $(document).on("input", "input.numeric", function() {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    //DATE PICKERS

    $('.datepicker').datepicker({
        clearBtn: true,
        format: 'mm/dd/yyyy',
        autoclose: true,
        viewMode: "days",
        minViewMode: "days",
        startDate: '01/01/2010',
        immediateUpdates: true,
        todayHighlight: true,
        daysOfWeekHighlighted: ['00']
    });

    $('.yearpicker').datepicker({
        clearBtn: true,
        format: 'yyyy',
        autoclose: true,
        viewMode: "years",
        minViewMode: "years",
        startDate: '2021',
        immediateUpdates: true,
        todayHighlight: true
    });

    $('.monthpicker').datepicker({
        clearBtn: true,
        format: 'mm/yyyy',
        autoclose: true,
        viewMode: "months",
        minViewMode: "months",
        startDate: '01/2020',
        immediateUpdates: true,
        todayHighlight: true
    });

    $('#loader-div').addClass('loaded');

    


    $(document).on('click', '#userGuide', function(){
            
        var url = base_url+'assets/userguide/cgis_user_guide.pdf';
        newPageTitle = $('#sys-name').val()+' User Guide!';
        document.querySelector('title').textContent = newPageTitle;
        printWindow = window.open( url , '_blank');
        printWindow.focus();

    });

    $(document).on('click', '.clear-trans-employees', function(){
        
        
        var modalID = '#modal-clear-trans';
        var docTypeID = $(this).attr('data-doctype');

        Lobibox.confirm({
            title: "System Notice",
            msg: 'Are you sure to clear all employee?',
            //class: 'info',
            //icon: 'fa fa-exclamation-circle',
            callback: function(box, type, ev){
                
                if (type === 'yes'){
                    $.ajax({
                        url: base_url + 'admin/clear-employee',
                        method:'POST',
                        data: {transTypeID:1},
                        dataType:"json",
                        success:function(data)
                        {
                            if(!data.success){
                                showAlertError(data.successMsg);
                                
                            } else {
                                $('.refresh-dt').trigger('click');
                                //$(modalID).modal('hide');
                                showSuccess(data.successMsg);
                            }
                        },
                        error:function(xhr, textStatus, errorThrown){
                            
                            console.log(xhr.responseText);
                            
                        }
                    });
                }
            }
        });

        

    });


    

    


    /* FORM VALIDATION */
    initValidationDefaults();
    /* var form = $('#change-password-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        rules: {
            'new-password': {
                
                minlength: 7
            },
            'confirm-password':{
                
                minlength: 7,
                equalTo: "#change-password-form [name=new-password]"
            }
        }
    }); */

    var form = $('#add-region');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-region');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#update-profile-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#update-password-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules: {
            
            'confirm-pass':{
                equalTo: "#update-password-form [name=new-pass]"
            }
        }
    });


    var form = $('#add-user-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules: {
            'user-employee-no': {
                required: true,
                minlength: 6
            },
            'user-email':{
                required: true,
                email: true
            },
            'user-password': {
                required: true,
                minlength: 7
            }
        }
    });

    var form = $('#update-user');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules: {
            'user-employee-no': {
                required: true,
                minlength: 6
            },
            'user-email':{
                required: true,
                email: true
            }
        }
    });

    var form = $('#update-password');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules: {
            'password2':{
                equalTo: "#update-password [name=password]"
            }
        }
    });

    var form = $('#add-user-role-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#update-user-role-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#add-role-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-role');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-sys-module-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-sys-module');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-key');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-key');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-user-sloc-form');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-bc');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-bc');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-province');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-province');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    
    
    var form = $('#probationary');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser, .itemized_dropdown',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#post-probationary');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#cancel-probationary');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#reset-probationary');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#emp-monitoring-interact');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules:{
            'mapFileName':{
                required:true,
                extension: "xlsx"
            }
        },
        messages: {  // <-- you must declare messages inside of "messages" option
            'mapFileName':{
                required:"This field is required",                  
                extension:"Select valid input file format"
            }
        }
    });
    
    var form = $('#add-doc-placement');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#update-doc-placement');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#cancel-doc-placement');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#undo-doc-placement');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    
    
    /* var form = $('#cgperformance');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser'
    }); */
    
    var form = $('#post-cgperformance');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#cancel-cgperformance');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#undo-cgperformance');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#upload-performance');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules:{
            'sloc-file':{
                required:true,
                extension: "xlsx"
            }
        },
        messages: {  // <-- you must declare messages inside of "messages" option
            'sloc-file':{
                required:"This field is required",                  
                extension:"Select valid input file format"
            }
        }
    });
    
    

    var form = $('#upload-harvest');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules:{
            'harvest-file':{
                required:true,
                extension: "xlsx"
            }
        },
        messages: {  // <-- you must declare messages inside of "messages" option
            'harvest-file':{
                required:"This field is required",                  
                extension:"Select valid input file format"
            }
        }
    });
    
    var form = $('#undo-harvest');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#cancel-harvest');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#clean-up');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#undo-clean-up');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });

    var form = $('#cancel-clean-up');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#upload-clean-up');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules:{
            'clean-up-file':{
                required:true,
                extension: "xlsx"
            }
        },
        messages: {  // <-- you must declare messages inside of "messages" option
            'clean-up-file':{
                required:"This field is required",                  
                extension:"Select valid input file format"
            }
        }
    });
    
    var form = $('#add-placement-filter');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-harvest-filter');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-clean-up-filter');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-industry-capacity-filter');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-doc-inventory-filter');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#cancel-industry-capacity');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#undo-industry-capacity');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#form-batchcode');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#upload-batchcode');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules:{
            'batchcode-file':{
                required:true,
                extension: "xlsx"
            }
        },
        messages: {  // <-- you must declare messages inside of "messages" option
            'batchcode-file':{
                required:"This field is required",                  
                extension:"Select valid input file format"
            }
        }
    });
    
    var form = $('#add-vet');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-vet');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-farmtype');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-farmtype');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-heatsource');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-heatsource');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-littermaterial');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-littermaterial');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-growtype');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-growtype');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#docageconf');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-hatchery');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-hatchery');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-industry');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-industry');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-industry-group');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-industry-group');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-mobile');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-mobile');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-mobile-credits');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-mobile-credits');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#add-user-rating');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
        rules:{
            'rating':{
                required:true
            },
            'user-feedback[]':{
                required:true
            }
        },
    });



    var form = $('#add-maprating');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-maprating');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    
    var form = $('#add-employmentstatus');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-employmentstatus');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    
    var form = $('#add-designation');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-designation');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    
    var form = $('#add-position');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-position');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    
    var form = $('#add-department');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    var form = $('#update-department');
    form.validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        onfocusout: function(e) {  // this option is not needed
            this.element(e);       // this is the default behavior
        },
    });
    
    
    $(document).on('click', '#logoutAct', function(e){
        var userRatingInd = $('#userRatingInd').val();
        if(userRatingInd){
            modalID = '#logoutModal';
        } else {
            modalID = '#logoutModal2';
        }
        $(modalID).modal({show:true});
    });

    $(document).on('click', '#noRateBtn', function(e){
        modalID = '#logoutModal2';
        $(modalID).modal('hide');
        modalID = '#logoutModal';
        $(modalID).modal({show:true});
    });
    
    // END FORM VALIDATION

    /*$(document).ready(function () {
      var base_url = $('#base_url').val();
      var slocID = $('#dashboard-slocID').val();
      var yearFrom = $('#dashboard-yearFrom').val();
      var yearTo = $('#dashboard-yearTo').val();
      var transTypeID = $('#dashboard-transTypeID').val();
      $.ajax({
        url: base_url + 'admin/performanceDashboard',
        data: {slocID:slocID, yearFrom:yearFrom, yearTo:yearTo, transTypeID:transTypeID},
        type: "POST",
        dataType:"json",
        success: function (data) {
            var cg_name = [];
            var net_placement = [];
            var gross_placement = [];
            var harvested_heads = [];
            console.log(data);
            //console.log(data['test1'].slocName);
            
        },
        error: function (data) {

        }
      });
    });*/

    // setInterval(function() {
        

    //     get_dynamic_count();
    // }, 60000);

    get_dynamic_count();
    
    

    $('#add-user-rating').find('.feedback-group').hide();
    $(document).on('click', '.rating-btn-bad', function(e){
    
        $('#add-user-rating').find('.feedback-group').show();
        $('#add-user-rating').find('.feedback-group-label').text('How can the system improve?');
    });
    $(document).on('click', '.rating-btn-good', function(e){
    
        $('#add-user-rating').find('.feedback-group').show();
        $('#add-user-rating').find('.feedback-group-label').text('What did the system do well?');
    });
    

    $(document).on('click', '#show_password', function(e){
    
        $('.password').attr('type', $('.password').is(':password') ? 'text' : 'password');
    });
	
    $('div.modal').attr('data-backdrop', 'static');
});

function get_dynamic_count(){
    var sideBarColorVal = $('#sideBarColorVal').val();
    var btnColorVal = $('#btnColorVal').val();
    var base_url = $('#base_url').val();

    $.ajax({
        url: base_url + 'admin/get_notification_count',
        method:'POST',
        dataType:"json",
        success:function(data)  
        {
            if(data.counter){
                if(data.counter > 0){
                    $('#notif-counter').addClass('notification');
                    $('#notif-counter').text(data.counter);
                }
            } else {
                $('#notif-counter').removeClass('notification');

                $('#notif-counter').text(data.counter);
            }

            /* if(sideBarColorVal == 'orange' || sideBarColorVal == 'orange2'){
                var badgeColor = 'badge-default';
            } else {
                var badgeColor = 'badge-warning';
            } */

            var badgeColor = 'badge-'+btnColorVal;
            
            if(data.pending_placement > 0){
                $('#doc-placement-badge').removeClass('badge '+badgeColor);
                $('#doc-placement-badge').addClass('badge '+badgeColor);
                $('#doc-placement-badge').text(data.pending_placement);
            }else{
                $('#doc-placement-badge').removeClass('badge '+badgeColor);
                $('#doc-placement-badge').text('');
            }

            if(data.pending_performance > 0){
                $('#cg-performance-badge').removeClass('badge '+badgeColor);
                $('#cg-performance-badge').addClass('badge '+badgeColor);
                $('#cg-performance-badge').text(data.pending_performance);
            }else{
                $('#cg-performance-badge').removeClass('badge '+badgeColor);
                $('#cg-performance-badge').text('');
            }
            
            if(data.pending_harvest > 0){
                $('#harvest-badge').removeClass('badge '+badgeColor);
                $('#harvest-badge').addClass('badge '+badgeColor);
                $('#harvest-badge').text(data.pending_harvest);
            }else{
                $('#harvest-badge').removeClass('badge '+badgeColor);
                $('#harvest-badge').text('');
            }
            
            if(data.pending_clean_up > 0){
                $('#clean-up-badge').removeClass('badge '+badgeColor);
                $('#clean-up-badge').addClass('badge '+badgeColor);
                $('#clean-up-badge').text(data.pending_clean_up);
            }else{
                $('#clean-up-badge').removeClass('badge '+badgeColor);
                $('#clean-up-badge').text('');
            }

            if(data.pending_doc_text_buffer > 0){
                $('#doc-text-buffer-badge').removeClass('badge '+badgeColor);
                $('#doc-text-buffer-badge').addClass('badge '+badgeColor);
                $('#doc-text-buffer-badge').text(data.pending_doc_text_buffer);
            }else{
                $('#doc-text-buffer-badge').removeClass('badge '+badgeColor);
                $('#doc-text-buffer-badge').text('');
            }
            
            if(data.pending_industry_capacity > 0){
                $('#industry-capacity-badge').removeClass('badge '+badgeColor);
                $('#industry-capacity-badge').addClass('badge '+badgeColor);
                $('#industry-capacity-badge').text(data.pending_industry_capacity);
            }else{
                $('#industry-capacity-badge').removeClass('badge '+badgeColor);
                $('#industry-capacity-badge').text('');
            }
        },
        error:function(xhr, textStatus, errorThrown){
            showError('Error in Saving!');
            console.log(xhr.responseText);
            
        }
    });


    $('#lineChart').sparkline([102,109,120,99,110,105,115], {
        type: 'line',
        height: '70',
        width: '100%',
        lineWidth: '2',
        lineColor: 'rgba(255, 255, 255, .5)',
        fillColor: 'rgba(255, 255, 255, .15)'
    });

    $('#lineChart2').sparkline([99,125,122,105,110,124,115], {
        type: 'line',
        height: '70',
        width: '100%',
        lineWidth: '2',
        lineColor: 'rgba(255, 255, 255, .5)',
        fillColor: 'rgba(255, 255, 255, .15)'
    });

    $('#lineChart3').sparkline([105,103,123,100,95,105,115], {
        type: 'line',
        height: '70',
        width: '100%',
        lineWidth: '2',
        lineColor: 'rgba(255, 255, 255, .5)',
        fillColor: 'rgba(255, 255, 255, .15)'
    });
}


function clearNotif(){
    var base_url = $('#base_url').val();
    
    var statusID = 13;
    var trigger = 'view';

    $.ajax({
        url: base_url + 'admin/update_usernotif',
        method:'POST',
        data: {statusID:statusID, trigger:trigger},
        dataType:"json",
        success:function(data)  
        {
            if(data.success){
                $('#notif-counter').html('');
                $('#notif-counter').removeClass('notification');
                if(data.counter > 0){
                    $('#notif-dropdown-title').html('You have new notification{s}');
                } else {
                    $('#notif-dropdown-title').html('Notification(s)');
                }
                $('#announcement-notif').empty();
                $('#announcement-notif').append(data.item);
            }
        },
        error:function(xhr, textStatus, errorThrown){
            
            console.log(xhr.responseText);
            
        }
    });
}


function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function convert_num(number){
    if(number >= 1000000000){
        number = number/1000000000;
        number = number_format(number, 3, '.', ',') + ' B';
    }else if(number >= 1000000 && number < 1000000000){
        number = number/1000000;
        number = number_format(number, 3, '.', ',') + ' M';
    }else if(number > 1000 && number < 1000000){
        number = number/1000;
        number = number_format(number, 2, '.', ',') + ' K';
    }else if(number > 99 && number < 999){
        number = number/1000;
        number = number_format(number, 2, '.', ',');
    }else{
         number = '';
    }
    return number;
}

function toFixed(num, fixed) {
    var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
    return num.toString().match(re)[0];
}

function initValidationDefaults(){
    //FORM VALIDATION CODE  FOR BOOTSTRAP3
    // override jquery validate plugin defaults
    $.validator.setDefaults({
        highlight: function (element) {
            var $el = $(element);
            var $fgroup = $el.closest('.form-group');
            $fgroup.removeClass('has-success')
                    .addClass('has-error')
                    .addClass('has-feedback')
                    .find('.form-control-feedback').remove();
            var $feedback = $('<i class="form-control-feedback fa fa-times-circle-o"></i>');
            //var $feedback = $('<i class="form-control-feedback"></i>');
            var type = $el[0].type;
            if (type === 'radio' || type === 'radio-inline' || type === 'checkbox' || type === 'checkbox-inline') {
                $fgroup.append($feedback);
            } else if (type === 'file' && $el.closest('.input.input-file').length > 0) {
                //Checking if this input is custom file input
                var $inputWrapper = $el.closest('.input.input-file');
                if ($inputWrapper.length > 0) {
                    $inputWrapper.append($feedback);
                }
            } else {
                if ($el.parent('.input-group').length) {
                    $feedback.insertAfter($el.parent());
                } else {
                    $feedback.insertAfter($el);
                }
            }
            
        },
        unhighlight: function (element) {
            var $el = $(element);
            var $fgroup = $el.closest('.form-group');
            $fgroup.removeClass('has-error')
                    .addClass('has-success')
                    .addClass('has-feedback')
                    .find('.form-control-feedback').remove();
            var $feedback = $('<i class="form-control-feedback fa fa-check"></i>');
            //var $feedback = $('<i class="form-control-feedback"></i>');
            var type = $el[0].type;
            if (type === 'radio' || type === 'radio-inline' || type === 'checkbox' || type === 'checkbox-inline') {
                $fgroup.append($feedback);
            } else if (type === 'file' && $el.closest('.input.input-file').length > 0) {
                //Checking if this input is custom file input
                var $inputWrapper = $el.closest('.input.input-file');
                if ($inputWrapper.length > 0) {
                    $inputWrapper.append($feedback);
                }
            } else {
                if ($el.parent('.input-group').length) {
                    $feedback.insertAfter($el.parent());
                } else {
                    $feedback.insertAfter($el);
                }
            }

            
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, $el) {
            var type = $el[0].type;
            var $fgroup = $el.closest('.form-group');
            if (type === 'radio' || type === 'radio-inline' || type === 'checkbox' || type === 'checkbox-inline') {
                $fgroup.append(error);
            } else if (type === 'file' && $el.closest('.input.input-file').length > 0) {
                //Checking if this input is custom file input
                var $inputWrapper = $el.closest('.input.input-file');
                if ($inputWrapper.length > 0) {
                    $inputWrapper.append(error);
                }
            } else {
                if ($el.parent('.input-group').length) {
                    error.insertAfter($el.parent());
                } else {
                    error.insertAfter($el);
                }
            }
        }
    });
}

    