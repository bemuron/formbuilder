//csrf token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

var close = document.getElementsByClassName("closebtn");
var i;
var mIsAlertOn;

for (i = 0; i < close.length; i++) {
  close[i].onclick = function(){
    var div = this.parentElement;
    div.style.opacity = "0";
    setTimeout(function(){ div.style.display = "none"; }, 600);
  };
}

//show the active side menu item
switch(window.location.pathname){
    case "/home":
        document.getElementsByClassName("nav-item")[0].className += " active";
    break;
}

//handles the addition of a text input
$('#btnInputField').on('click', function (e) {
    var clone = $('#tIField').clone();

    var fieldArr = [];
    $('#componentContainer .componentItem').each(function() {
        fieldArr.push(parseInt($(this).attr('data-item')))
    })
    var i = fieldArr.length

    clone.find('.componentItem').attr('data-item', i)
        clone.find('#textInput').attr('name', 'txInput[' + i + ']')
        $('#componentContainer').append(clone.html())
        $('body,html').animate({ scrollTop: $(this).offset().top }, 'fast')
        initialiseFields();

});

//handles the addition of a email input
$('#btnEmailInputField').on('click', function (e) {
    var clone = $('#emailField').clone();

    var fieldArr = [];
    $('#componentContainer .componentItem').each(function() {
        fieldArr.push(parseInt($(this).attr('data-item')))
    })
    var i = fieldArr.length

    clone.find('.componentItem').attr('data-item', i)
        clone.find('#emailInputId').attr('name', 'emailInput[' + i + ']')
        $('#componentContainer').append(clone.html())
        $('body,html').animate({ scrollTop: $(this).offset().top }, 'fast')
        initialiseFields();

});

//handles the addition of a number input
$('#btnNumInputField').on('click', function (e) {
    var clone = $('#numberField').clone();

    var fieldArr = [];
    $('#componentContainer .componentItem').each(function() {
        fieldArr.push(parseInt($(this).attr('data-item')))
    })
    var i = fieldArr.length;

    clone.find('.componentItem').attr('data-item', i)
        clone.find('#numInputId').attr('name', 'numberInput[' + i + ']')
        $('#componentContainer').append(clone.html())
        $('body,html').animate({ scrollTop: $(this).offset().top }, 'fast')
        initialiseFields();

});

//handles the addition of a date input
$('#btnDateInputField').on('click', function (e) {
    var clone = $('#dateField').clone();

    var fieldArr = [];
    $('#componentContainer .componentItem').each(function() {
        fieldArr.push(parseInt($(this).attr('data-item')))
    })
    var i = fieldArr.length;

    clone.find('.componentItem').attr('data-item', i)
        clone.find('#dateInputId').attr('name', 'dateInput[' + i + ']')
        $('#componentContainer').append(clone.html())
        $('body,html').animate({ scrollTop: $(this).offset().top }, 'fast')
        initialiseFields();

});

//handles the addition of a radio buttons
$('#btnRadioInputField').on('click', function (e) {
    var clone = $('#radioButtons').clone();

    var fieldArr = [];
    $('#componentContainer .componentItem').each(function() {
        fieldArr.push(parseInt($(this).attr('data-item')))
    })
    var i = fieldArr.length;

    clone.find('.componentItem').attr('data-item', i);
    $('#componentContainer').append(clone.html());
    $('body,html').animate({ scrollTop: $(this).offset().top }, 'fast');

    initialiseFields();

    addRadio();

});

//handles the addition of a check boxes
$('#btnCheckInputField').on('click', function (e) {
    var clone = $('#checkBoxes').clone();

    var fieldArr = [];
    $('#componentContainer .componentItem').each(function() {
        fieldArr.push(parseInt($(this).attr('data-item')));
    });
    var i = fieldArr.length;

    clone.find('.componentItem').attr('data-item', i);
    $('#componentContainer').append(clone.html());
    $('body,html').animate({ scrollTop: $(this).offset().top }, 'fast');

    initialiseFields();

    addCheckbox();

});

//handles the addition of a check boxes
$('#btnTxAreaInputField').on('click', function (e) {
    var clone = $('#textAreaCon').clone();

    var fieldArr = [];
    $('#componentContainer .componentItem').each(function() {
        fieldArr.push(parseInt($(this).attr('data-item')))
    })
    var i = fieldArr.length;

    clone.find('.componentItem').attr('data-item', i)
        clone.find('textarea').attr('name', 'txtAreaInput[' + i + ']')
        $('#componentContainer').append(clone.html())
        $('body,html').animate({ scrollTop: $(this).offset().top }, 'fast')
        initialiseFields();

});

$('#componentContainer').sortable({
    handle: '.item-move',
    classes: {
        "ui-sortable": "highlight"
    }
})

function initialiseFields() {
    $('[contenteditable="true"]').each(function() {
        $(this).on("blur focusout", function() {
            if ($(this).text() == "") {
                $(this).text($(this).attr("title"))
            }
        })

    })
    $('.componentContainer .form-check').find('label').on('keypress keyup paste cut', function() {
        $(this).siblings('input').val($(this).text())
    })
    $('.componentContainer .req-chk').on('click', function() {
        if ($(this).siblings('input[type="checkbox"]').is(":checked") == true) {
            $(this).siblings('input[type="checkbox"]').prop("checked", false).trigger("change")
        } else {
            $(this).siblings('input[type="checkbox"]').prop("checked", true).trigger("change")
        }
    })
    $('.removeItem').on('click', function(e) {
        $(this).closest('.componentItem').remove()
    })
    $('.req-item').on('change', function() {
        var _parent = $(this).closest('.componentItem')
        if ($(this).is(":checked") == true) {
            _parent.find("input").first().attr('required', true)
            _parent.find("textarea").first().attr('required', true)
            $(this).attr('checked', true)
        } else {
            _parent.find("input").first().attr('required', false)
            _parent.find("textarea").first().attr('required', false)
            $(this).attr('checked', false)
        }
    })
}

//adds the radio buttons
function addRadio() {
    $('.add_radio').on('click', function() {
        var radioObj = $(this)
        var field = radioObj.closest('.componentItem').attr('data-item')
        radioField(radioObj, field, "Enter Option")
    })
}

//adds the check box
function addCheckbox() {
    $('.add_chk').on('click', function() {
        var checkBoxObj = $(this)
        var field = checkBoxObj.closest('.componentItem').attr('data-item')
        checkboxField(checkBoxObj, field, "Enter Option")
    })
}

//set up the radio field
function radioField(radio, field, radioText = "option") {
    var radioDiv = $("<div>")
    var removeDiv = $("<div>")
    radioDiv.attr({
        "class": "col-sm-11 d-flex align-items-center",
    })
    removeDiv.attr({
        "class": "col-sm-1 rem-on-display",
    })
    removeDiv.append("<button class='btn btn-sm btn-default' type='button'><span class='fa fa-times'></span></button>")
    removeDiv.attr('onclick', "$(this).closest('.row').remove()")
    var item = createRadioField(field, radioText)
    radioDiv.append(item)
    rowElem = $("<div class='row w-100'>")
    rowElem.append(removeDiv)
    rowElem.append(radioDiv)
    radio.closest('.componentItem').find('.add_radio').before(rowElem)
}

//set up the check box
function checkboxField(checkBox, field, text = "option") {
    var boxDiv = $("<div>")
    var removeDiv = $("<div>")
    boxDiv.attr({
        "class": "col-sm-11 d-flex align-items-center",
    })
    removeDiv.attr({
        "class": "col-sm-1 rem-on-display",
    })
    removeDiv.append("<button class='btn btn-sm btn-default' type='button'><span class='fa fa-times'></span></button>")
    removeDiv.attr('onclick', "$(this).closest('.row').remove()")
    var item = createCheckboxField(field, text)
    boxDiv.append(item)
    rowElem = $("<div class='row w-100'>")
    rowElem.append(removeDiv)
    rowElem.append(boxDiv)
    checkBox.closest('.componentItem').find('.add_chk').before(rowElem)
}

function createRadioField(field, radioText) {

    var element = $('<div>')
    element.attr({
        "class": "form-check q-fc"
    })
    var inputElem = $('<input>')
    inputElem.attr({
        "class": "form-check-input",
        "name": "customRadio[" + field + "]",
        "type": "radio",
        "value": radioText
    })
    var label = $('<label>')
    label.attr({
        "class": "form-check-label",
        "contenteditable": true,
        "title": "Enter option here"
    })
    label.text(radioText)
    element.append(inputElem)
    element.append(label)
    return element
}

function createCheckboxField(field, boxText) {

    var element = $('<div>')
    element.attr({
        "class": "form-check q-fc"
    })
    var inputElem = $('<input>')
    inputElem.attr({
        "class": "form-check-input",
        "name": "box[" + field + "][]",
        "type": "checkbox",
        "value": boxText
    })
    var label = $('<label>')
    label.attr({
        "class": "form-check-label",
        "contenteditable": true,
        "title": "Enter option here"
    })
    label.text(boxText)
    element.append(inputElem)
    element.append(label)
    return element
}

//save the form
function saveForm() {
    var new_el = $('<div>')
    var form_el = $('#componentContainer').clone()
    var form_code = $("[name='form_code']").length > 0 ? $("[name='form_code']").val() : "";
    var title = document.getElementById("form-title").value;
    var description = document.getElementById("form-description").value;
    form_el.find("[name='form_code']").remove()
    new_el.append(form_el)
    //start_loader();
    $.ajax({
        url: "/save-form",
        type: 'POST',
        data: { 
            _token: CSRF_TOKEN,
            form_data: new_el.html(), 
            description: description, 
            title: title, 
            form_code: form_code
        },
        //dataType: 'json',
        error: err => {
            console.log(new_el.html());
            console.log(err)
            alert("an error occured")
        },
        success: function(resp) {
            console.log(resp);
            if (typeof resp == 'object' && resp.status == 'success') {
                alert("Form successfully saved")
                location.href = "./"
            } else {
                console.log(resp)
                alert("an error occured")
            }
            //end_loader()
        }
    })
}

$('#saveFormBtn').on('click', function() {
    saveForm();
});

//date input
$('#dateInput').datepicker({ dateFormat: 'yy-mm-dd' });

//get all forms
function getAllForms(){
    //display the forms created
if ($.fn.DataTable.isDataTable('#forms_table')) {
  $('#forms_table').DataTable().destroy();
}
$('#forms_table tbody').empty();
$('#forms_table').DataTable({
  //responsive: true,
  processing: true,
  //serverSide: true,
  order: [],
  ajax: {
      url: "/get-all-forms",
      dataSrc: function (json) {
          //console.log(json.length);
        var return_data = new Array();
        for(var i=0;i< json.length; i++){
          return_data.push({
            action: displayActionButtons(json[i].id),
              name: json[i].form_name,
              description: json[i].description,
              title: json[i].form_title,
              form_code: json[i].form_code,
              created_at: formatDate(json[i].created_at),
              created_by: json[i].created_by
            });
            
          }
          return return_data;
        }
    },
    columns: [
    {data: 'name'},
    {data: 'title'},
    {data: 'description'},
    {data: 'form_code'},
    {data: 'created_at'},
    {data: 'created_by'},
    {data: 'action', orderable: false, searchable: false}
    ]
});
}

//show modal to create a new form
$('#createFormBtn').on('click', function (e) {
  $('#form_modal').modal("show");
});

//get all events
function getAllEvents(){
    //display the events created
if ($.fn.DataTable.isDataTable('#events_table')) {
  $('#events_table').DataTable().destroy();
}
$('#events_table tbody').empty();
$('#events_table').DataTable({
  //responsive: true,
  processing: true,
  //serverSide: true,
  order: [],
  ajax: {
      url: "/events/table-list",
      dataSrc: function (json) {
          //console.log(json.length);
        var return_data = new Array();
        for(var i=0;i< json.length; i++){
          return_data.push({
            action: displayEventActionButtons(json[i].id),
              name: json[i].name,
              description: json[i].description,
              image: displayEventImage(json[i].image),
              created_at: formatDate(json[i].created_at),
              created_by: json[i].created_by
            });
            
          }
          return return_data;
        }
    },
    columns: [
    {data: 'name'},
    {data: 'description'},
    {data: 'image', orderable: false, searchable: false},
    {data: 'created_at'},
    {data: 'created_by'},
    {data: 'action', orderable: false, searchable: false}
    ]
});
}


//show the respective table data after page load
window.onload = function() {
  var pageTitle = document.getElementById("page-title");
  if(pageTitle != null){
      if(pageTitle.innerHTML == "Manage Forms") {
              getAllForms();
          //default:  
      }
  }
}

//format the date
function formatDate(dateToFormat){
  var date = new Date(dateToFormat);
  return date.toLocaleDateString("en-GB",{day: "numeric", month: "short",year: "numeric"});
}

//display action buttons
function displayActionButtons(formId){
  var actions =  "<div class='btn-toolbar'> <div> "+
  "<a href='#' class='btn btn-xs btn-outline-dark btn-icon' onclick='getElectionDetails("+formId+")' id='edit-election' data-id='"+formId+"'><i class='bi bi-pencil-square'></i> </a> "+
  "<a href='#' class='btn btn-xs btn-outline-danger btn-icon' onclick='confirmFormDelete("+formId+")' id='delete-election' data-id='"+formId+"' data-toggle='modal' data-animation='effect-scale'> <i class='bi bi-trash'></i> </a> "+
  "<a href='#' class='btn btn-xs btn-outline-success btn-icon' onclick='launchForm("+formId+")' id='delete-election' data-id='"+formId+"' data-toggle='modal' data-animation='effect-scale'> <i class='bi bi-box-arrow-up-right'></i></a>"+
  "</div></div>";

  return actions;
}

function launchForm(formId){
    var baseUrl = window.location.origin;
    window.open(baseUrl+"/form/"+formId, "_blank");
}

//confirm deletion of a form
function confirmFormDelete(formId){
    $('#delete_form_modal').modal("show");

    document.getElementById("deleteFormText").innerHTML = "Confirm delete of this form";

    $('#deletFormBtn').click(function(){
        deleteForm(formId);
    
  });
}

//deletion of a form
function deleteForm(formId){

}
